@extends('backend.layouts.app')

@section('title', 'State Management')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">State Management</h1>
                <p class="mb-0 text-muted">Manage states country-wise</p>
            </div>

            <button type="button" class="btn btn-primary" id="addStateBtn">
                <i class="fas fa-plus"></i> Add State
            </button>
        </div>
        <!-- Edit State Modal -->
        <div class="modal fade" id="editStateModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit State</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit_state_id">

                        <div class="mb-3">
                            <label class="form-label">Country</label>

                            <input type="text" id="editCountryName" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="edit_state_name" class="form-label">
                                State Name
                            </label>

                            <input type="text" id="edit_state_name" class="form-control">

                            <div class="invalid-feedback" id="editStateNameError"></div>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button" class="btn btn-primary" id="updateStateBtn">
                            Update
                        </button>

                    </div>

                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-sm">

            <div class="card-body">

                {{-- Country --}}
                <div class="mb-4">
                    <label for="country_id" class="form-label">
                        Country
                    </label>

                    <select id="country_id" class="form-control">
                        <option value="">Select Country</option>

                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- States --}}
                <div>
                    <h5 class="mb-3">States</h5>

                    <div id="statesList">

                        <div class="text-muted text-center py-4">
                            Please select a country.
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add State</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Country</label>

                        <input type="text" id="selectedCountryName" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="state_name" class="form-label">
                            State Name
                        </label>

                        <input type="text" id="state_name" class="form-control" placeholder="Enter state name">

                        <div class="invalid-feedback" id="stateNameError"></div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-primary" id="saveStateBtn">
                        <i class="fas fa-save"></i>
                        Save
                    </button>

                </div>

            </div>
           
        </div>
    </div>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(document).ready(function () {
            /*
            |--------------------------------------------------------------------------
            | LOAD STATES
            |--------------------------------------------------------------------------
            */

            function loadStates() {

                let countryId = $('#country_id').val();

                if (!countryId) {
                    $('#statesList').html(`
                                        <div class="text-muted text-center py-4">
                                            Please select a country.
                                        </div>
                                    `);
                    return;
                }

                $('#statesList').html(`
                                    <div class="text-center py-4">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        Loading states...
                                    </div>
                                `);

                $.ajax({
                    url: "{{ url('/admin/state-management/states') }}/" + countryId,
                    type: "GET",
                    cache: false,
                    data: {
                        _t: Date.now()
                    },

                    success: function (states) {

                        console.log('STATES LOADED:', states);

                        if (!states || states.length === 0) {

                            $('#statesList').html(`
                                                <div class="text-muted text-center py-4">
                                                    No states found for this country.
                                                </div>
                                            `);

                            return;
                        }

                        let html = '';

                        $.each(states, function (index, state) {

                            html += `
                                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                                                    <div>
                                                        <strong>${state.name}</strong>
                                                    </div>

                                                    <div>

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-primary edit-state"
                                                            data-id="${state.id}"
                                                            data-name="${state.name}">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-danger delete-state"
                                                            data-id="${state.id}">
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </button>

                                                    </div>

                                                </div>
                                            `;
                        });

                        $('#statesList').html(html);
                    },

                    error: function (xhr) {

                        console.log('LOAD STATES ERROR:', xhr.status);
                        console.log(xhr.responseText);

                        $('#statesList').html(`
                                            <div class="alert alert-danger">
                                                Failed to load states.
                                            </div>
                                        `);
                    }
                });
            }


            // country change.......

            $('#country_id').on('change', function () {
                loadStates();
            });


        //    add state modal

            $('#addStateBtn').on('click', function () {

                let countryId = $('#country_id').val();

                if (!countryId) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Country',
                        text: 'Please select a country first.'
                    });

                    return;
                }

                let countryName = $('#country_id option:selected').text().trim();

                $('#selectedCountryName').val(countryName);

                $('#state_name').val('');
                $('#state_name').removeClass('is-invalid');
                $('#stateNameError').text('');

                $('#addStateModal').modal('show');
            });

// add state.....

            $('#saveStateBtn').on('click', function () {

                let button = $(this);

                let countryId = $('#country_id').val();
                let stateName = $('#state_name').val().trim();

                $('#state_name').removeClass('is-invalid');
                $('#stateNameError').text('');

                if (!stateName) {

                    $('#state_name').addClass('is-invalid');
                    $('#stateNameError').text('State name is required.');

                    return;
                }

                button.prop('disabled', true);

                $.ajax({

                    url: "{{ url('/admin/state-management/states') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        country_id: countryId,
                        name: stateName
                    },

                    success: function (response) {

                        console.log('ADD SUCCESS:', response);

                        $('#addStateModal').modal('hide');

                        $('#state_name').val('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // Immediately reload fresh list
                        loadStates();
                    },

                    error: function (xhr) {

                        console.log('ADD ERROR:', xhr.status);
                        console.log(xhr.responseText);

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            if (errors && errors.name) {

                                $('#state_name').addClass('is-invalid');
                                $('#stateNameError').text(errors.name[0]);
                            }

                            return;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'State could not be added.'
                        });
                    },

                    complete: function () {
                        button.prop('disabled', false);
                    }
                });
            });

            //edit state.....

            $(document).on('click', '.edit-state', function () {

                let stateId = $(this).data('id');
                let stateName = $(this).data('name');

                console.log('EDIT:', stateId, stateName);

                $('#edit_state_id').val(stateId);
                $('#edit_state_name').val(stateName);

                $('#edit_state_name').removeClass('is-invalid');
                $('#editStateNameError').text('');

                $('#editStateModal').modal('show');
            });


            // update state

            $('#updateStateBtn').on('click', function () {

                let button = $(this);

                let stateId = $('#edit_state_id').val();
                let stateName = $('#edit_state_name').val().trim();

                console.log('UPDATE:', stateId, stateName);

                $('#edit_state_name').removeClass('is-invalid');
                $('#editStateNameError').text('');

                if (!stateName) {

                    $('#edit_state_name').addClass('is-invalid');
                    $('#editStateNameError').text('State name is required.');

                    return;
                }

                button.prop('disabled', true);

                $.ajax({

                    url: "{{ url('/admin/state-management/states') }}/" + stateId,

                    type: "PUT",

                    data: {
                        _token: "{{ csrf_token() }}",
                        name: stateName
                    },

                    success: function (response) {

                        console.log('UPDATE SUCCESS:', response);

                        $('#editStateModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: response.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // Immediately reload fresh list
                        loadStates();
                    },
                    error: function (xhr) {

                        console.log('UPDATE ERROR:', xhr.status);
                        console.log(xhr.responseText);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors && errors.name) {

                                $('#edit_state_name').addClass('is-invalid');
                                $('#editStateNameError').text(errors.name[0]);
                            }
                            return;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'State could not be updated.'
                        });
                    },

                    complete: function () {
                        button.prop('disabled', false);
                    }
                });
            });

           //delete state.....
            $(document).on('click', '.delete-state', function () {
                let stateId = $(this).data('id');
                console.log('DELETE:', stateId);
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This state will be deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }
                    $.ajax({
                        url: "{{ url('/admin/state-management/states') }}/" + stateId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            console.log('DELETE SUCCESS:', response);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message,
                                timer: 1200,
                                showConfirmButton: false
                            });
                            // Immediately reload fresh list
                            loadStates();
                        },
                        error: function (xhr) {
                            console.log('DELETE ERROR:', xhr.status);
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'State could not be deleted.'
                            });
                        }
                    });
                });
            });

          //table load......
            if ($('#country_id').val()) {
                loadStates();
            }
        });
    </script>
@endpush