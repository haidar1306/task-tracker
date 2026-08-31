@extends('backend.layouts.app')

@section('title', 'Activity Logs')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title">
                    <!-- <i class="fas fa-history mr-2"></i> -->
                    Activity Logs
                </h3>

                <span class="badge badge-primary">
                    Total : {{ $activityLogs->total() }}
                </span>

            </div>
            <div class="card-body border-bottom">

                <form method="GET" action="{{ route('admin.admin.activity-logs.index') }}">

                    <div class="row">


                        {{-- Search --}}
                        <div class="col-md-4">

                            <input type="text" id="activitySearch" class="form-control" placeholder="Search description...">

                        </div>



                        {{-- Module --}}
                        <div class="col-md-3">

                            <select name="module" class="form-control">

                                <option value="">
                                    All Modules
                                </option>


                                @foreach($modules as $module)

                                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>

                                        {{ $module }}

                                    </option>

                                @endforeach


                            </select>

                        </div>



                        {{-- Action --}}
                        <div class="col-md-3">

                            <select name="action" class="form-control">

                                <option value="">
                                    All Actions
                                </option>


                                @foreach($actions as $action)

                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>

                                        {{ $action }}

                                    </option>

                                @endforeach


                            </select>

                        </div>



                        {{-- Buttons --}}
                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-filter"></i>
                                Filter

                            </button>


                            <a href="{{ route('admin.admin.activity-logs.index') }}" class="btn btn-secondary">

                                Reset

                            </a>

                        </div>


                    </div>


                </form>


            </div>

            <div class="card-body p-0">

                <table class="table table-hover table-bordered mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="60">#</th>

                            <th>User</th>

                            <th>Module</th>

                            <th>Action</th>

                            <th>Description</th>

                            <th>IP Address</th>

                            <th>Date</th>
                            <!-- <th>location</th> -->

                        </tr>

                    </thead>

                    <tbody>

                    <tbody id="activityTable">

                        @include('backend.activity-logs.partials.rows', [
                            'activityLogs' => $activityLogs,
                            'search' => null
                        ])

                    </tbody>
                    </tbody>

                </table>

            </div>

            @if($activityLogs->hasPages())

                <div class="card-footer">

                    {{ $activityLogs->links() }}

                </div>

            @endif
            <div>

        </div>

    </div>

@endsection
@push('after-scripts')

<script>

$(document).ready(function () {

    let timer;

    $('#activitySearch').on('keyup', function () {

        clearTimeout(timer);

        let search = $(this).val();

        timer = setTimeout(function () {

            $.ajax({

                url: "{{ route('admin.admin.activity-logs.search') }}",

                type: "GET",

                data: {
                    search: search
                },

                success: function (response) {

                    $('#activityTable').html(response.html);

                },

                error: function () {

                    console.log("Search Error");

                }

            });

        }, 300);

    });

});

</script>
@endpush