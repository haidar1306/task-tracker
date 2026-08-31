<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            <i class="fas fa-user-circle text-primary"></i>
            My Profile
        </h4>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 text-center">

                <img src="{{ $logged_in_user->avatar }}"
                     class="rounded-circle shadow mb-3"
                     width="150"
                     height="150">

                <h5 class="font-weight-bold">
                    {{ $logged_in_user->name }}
                </h5>

                <span class="badge badge-success">
                    {{ $logged_in_user->roles->first()->name ?? 'Admin' }}
                </span>

            </div>

            <div class="col-md-9">

                <table class="table table-bordered">

                    <tr>
                        <th width="220">Full Name</th>
                        <td>{{ $logged_in_user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $logged_in_user->email }}</td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td>
                            {{ $logged_in_user->roles->first()->name ?? 'Admin' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Timezone</th>
                        <td>
                            {{ $logged_in_user->timezone ?? 'Asia/Kolkata' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Account Created</th>
                        <td>
                            {{ $logged_in_user->created_at->format('d M Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>
                            {{ $logged_in_user->updated_at->format('d M Y') }}
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>