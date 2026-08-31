@extends('backend.layouts.app')

@section('title', 'Inquiry Details')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Inquiry Details</h3>

                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="200">Name</th>
                        <td>{{ $inquiry->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $inquiry->email }}</td>
                    </tr>

                    <tr>
                        <th>Subject</th>
                        <td>{{ $inquiry->subject }}</td>
                    </tr>

                    <tr>
                        <th>Message</th>
                        <td>{{ $inquiry->message }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-warning">
                                {{ $inquiry->status }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Admin Notes</th>
                        <td>
                            {{ $inquiry->admin_notes ?? 'No notes added.' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Received At</th>
                        <td>{{ $inquiry->created_at->format('d M Y h:i A') }}</td>
                    </tr>

                </table>
                <div class="mt-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#replyModal">
                        <i class="fas fa-envelope"></i>
                        Reply
                    </button>
                </div>

            </div>

        </div>

    </div>

@endsection
<div class="modal fade"
     id="replyModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('admin.admin.inquiries.reply.store',$inquiry->id) }}"
                  method="POST">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Reply Inquiry
                    </h5>

                    <button class="close"
                            data-dismiss="modal">
                        &times;
                    </button>

                </div>

                <div class="modal-body">

                    <label>Reply</label>

                    <textarea
                        name="reply"
                        rows="6"
                        class="form-control"
                        required></textarea>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-success">
                        Submit Reply
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>