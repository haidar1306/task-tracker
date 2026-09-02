<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Events\User\UserDeleted;
use App\Domains\Auth\Events\User\UserDestroyed;
use App\Domains\Auth\Events\User\UserRestored;
use App\Domains\Auth\Events\User\UserStatusChanged;
use App\Domains\Auth\Events\User\UserUpdated;
use App\Domains\Auth\Models\User;
use App\Models\Guest;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param $type
     * @param bool|int $perPage
     * @return mixed
     */
    public function getByType($type, $perPage = false)
    {
        if (is_numeric($perPage)) {
            return $this->model::byType($type)->paginate($perPage);
        }

        return $this->model::byType($type)->get();
    }

    /**
     * Register User
     *
     * @param array $data
     * @return User
     *
     * @throws GeneralException
     */
    public function registerUser(array $data = []): User
    {
        DB::beginTransaction();

        try {
            // Create User
            $user = $this->createUser($data);

            // Create Guest Profile
            Guest::create([
                'first_name' => $data['name'] ?? null,
                'last_name' => '',
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'status' => 1,
            ]);

            DB::commit();

            return $user;

        } catch (Exception $e) {

            DB::rollBack();

            \Log::error('Registration Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw new GeneralException(
                __('There was a problem creating your account.')
            );
        }
    }

    /**
     * Register Provider.
     *
     * @param $info
     * @param $provider
     * @return mixed
     *
     * @throws GeneralException
     */
    public function registerProvider($info, $provider): User
    {
        $user = $this->model::where('provider_id', $info->id)->first();

        if (!$user) {
            DB::beginTransaction();

            try {
                $user = $this->createUser([
                    'name' => $info->name,
                    'email' => $info->email,
                    'lang' => 'en',
                    'provider' => $provider,
                    'provider_id' => $info->id,
                    'email_verified_at' => now(),
                ]);

                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();

                \Log::error('Provider Registration Error', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                throw new GeneralException(
                    __('There was a problem connecting to :provider', [
                        'provider' => $provider
                    ])
                );
            }
        }

        return $user;
    }

    /**
     * Store User.
     *
     * @param array $data
     * @return User
     *
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): User
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser([
                'type' => $data['type'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'lang' => $data['lang'] ?? 'en',
                'email_verified_at' => isset($data['email_verified'])
                    && $data['email_verified'] === '1'
                    ? now()
                    : null,
                'active' => isset($data['active'])
                    && $data['active'] === '1',
            ]);

            $user->syncRoles($data['roles'] ?? []);

            if (!config('boilerplate.access.user.only_roles')) {
                $user->syncPermissions($data['permissions'] ?? []);
            }

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(
                __('There was a problem creating this user. Please try again.')
            );
        }

        event(new UserCreated($user));

        DB::commit();

        if (
            !isset($data['email_verified']) &&
            isset($data['send_confirmation_email']) &&
            $data['send_confirmation_email'] === '1'
        ) {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }

    /**
     * Update User.
     *
     * @param User $user
     * @param array $data
     * @return User
     *
     * @throws \Throwable
     */
    public function update(User $user, array $data = []): User
    {
        DB::beginTransaction();

        try {
            $user->update([
                'type' => $user->isMasterAdmin()
                    ? $this->model::TYPE_ADMIN
                    : $data['type'] ?? $user->type,

                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            if (!$user->isMasterAdmin()) {

                $user->syncRoles($data['roles'] ?? []);

                if (!config('boilerplate.access.user.only_roles')) {
                    $user->syncPermissions($data['permissions'] ?? []);
                }
            }

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(
                __('There was a problem updating this user. Please try again.')
            );
        }

        event(new UserUpdated($user));

        DB::commit();

        return $user;
    }

    /**
     * Update Profile.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $data = []): User
    {
        $user->name = $data['name'] ?? null;

        if (
            $user->canChangeEmail() &&
            isset($data['email']) &&
            $user->email !== $data['email']
        ) {
            $user->email = $data['email'];
            $user->email_verified_at = null;

            $user->sendEmailVerificationNotification();

            session()->flash('resent', true);
        }

        return tap($user)->save();
    }

    /**
     * Update Password.
     *
     * @param User $user
     * @param $data
     * @param bool $expired
     * @return User
     *
     * @throws \Throwable
     */
    public function updatePassword(User $user, $data, $expired = false): User
    {
        if (isset($data['current_password'])) {
            throw_if(
                !Hash::check($data['current_password'], $user->password),
                new GeneralException(__('That is not your old password.'))
            );
        }

        if ($expired) {
            $user->password_changed_at = now();
        }

        $user->password = $data['password'];

        return tap($user)->update();
    }

    /**
     * Mark User Status.
     *
     * @param User $user
     * @param $status
     * @return User
     *
     * @throws GeneralException
     */
    public function mark(User $user, $status): User
    {
        if ($status === 0 && auth()->id() === $user->id) {
            throw new GeneralException(__('You can not do that to yourself.'));
        }

        if ($status === 0 && $user->isMasterAdmin()) {
            throw new GeneralException(
                __('You can not deactivate the administrator account.')
            );
        }

        $user->active = $status;

        if ($user->save()) {
            event(new UserStatusChanged($user, $status));

            return $user;
        }

        throw new GeneralException(
            __('There was a problem updating this user. Please try again.')
        );
    }

    /**
     * Delete User.
     *
     * @param User $user
     * @return User
     *
     * @throws GeneralException
     */
    public function delete(User $user): User
    {
        if ($user->id === auth()->id()) {
            throw new GeneralException(__('You can not delete yourself.'));
        }

        if ($this->deleteById($user->id)) {
            event(new UserDeleted($user));

            return $user;
        }

        throw new GeneralException(
            __('There was a problem deleting this user. Please try again.')
        );
    }

    /**
     * Restore User.
     *
     * @param User $user
     * @return User
     *
     * @throws GeneralException
     */
    public function restore(User $user): User
    {
        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(
            __('There was a problem restoring this user. Please try again.')
        );
    }

    /**
     * Permanently Destroy User.
     *
     * @param User $user
     * @return bool
     *
     * @throws GeneralException
     */
    public function destroy(User $user): bool
    {
        if ($user->forceDelete()) {
            event(new UserDestroyed($user));

            return true;
        }

        throw new GeneralException(
            __('There was a problem permanently deleting this user. Please try again.')
        );
    }

    /**
     * Create User.
     *
     * @param array $data
     * @return User
     */
    protected function createUser(array $data = []): User
    {
        return $this->model::create([
            'type' => $data['type'] ?? $this->model::TYPE_USER,

            'name' => $data['name'] ?? null,

            'email' => $data['email'] ?? null,

            'password' => $data['password'] ?? null,

            // REQUIRED on your live PostgreSQL database
            'lang' => $data['lang'] ?? 'en',

            'provider' => $data['provider'] ?? null,

            'provider_id' => $data['provider_id'] ?? null,

            'email_verified_at' => $data['email_verified_at'] ?? null,

            'active' => $data['active'] ?? true,
        ]);
    }
}