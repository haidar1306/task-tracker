@extends('backend.layouts.app')

@section('title', 'Inquiries')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Inquiry List</h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->subject }}</td>
                            <td>{{ $inquiry->created_at->format('d M Y h:i A') }}</td>
                            <td class="text-center">

                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn btn-sm btn-info"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Delete this inquiry?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No inquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="mt-3">
                {{ $inquiries->links() }}
            </div>

        </div>
    </div>

@endsection