<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Rules\Captcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class RegisterController.
 */
class RegisterController
{
    use RegistersUsers;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterController constructor.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Redirect users after registration.
     */
    public function redirectPath()
    {
        return route('frontend.hotel.dashboard');
    }

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);

        return view('frontend.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'phone' => ['required', 'digits_between:10,15'],
            'password' => array_merge(
                ['max:100'],
                PasswordRules::register($data['email'] ?? null)
            ),
            'terms' => ['required', 'in:1'],
            'g-recaptcha-response' => [
                'required_if:captcha_status,true',
                new Captcha,
            ],
        ], [
            'terms.required' => __('You must accept the Terms & Conditions.'),
            'g-recaptcha-response.required_if' => __(
                'validation.required',
                ['attribute' => 'captcha']
            ),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);

        return $this->userService->registerUser($data);
    }

    /**
     * Set correct access for the newly registered user.
     */
    protected function registered(Request $request, $user)
    {
        $user->forceFill([
            'type' => User::TYPE_USER,
            'active' => true,
        ])->save();

        // Assign the standard role only when it is not already present.
        if (!$user->hasRole('User')) {
            $user->assignRole('User');
        }

       return redirect()->to(url('hotel/dashboard'));
    }
    
}