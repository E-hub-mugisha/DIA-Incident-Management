@extends('layouts.app')
@section('title','Staff')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Staff Management</h4>

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Add Button -->
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                                Add Staff
                            </button>

                            <!-- Staff Table -->
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staff as $index => $member)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $member->user->name ?? 'N/A' }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>{{ $member->position }}</td>
                                        <td>{{ $member->department->name ?? 'N/A' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $member->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal{{ $member->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editStaffModal{{ $member->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('staff.update', $member->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">Edit Staff</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label>User</label>
                                                            <select name="user_id" class="form-select" required>
                                                                @foreach($users as $user)
                                                                <option value="{{ $user->id }}" {{ $member->user_id == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label>Names</label>
                                                            <input type="text" name="name" value="{{ $member->name }}" class="form-control" placeholder="Name" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label>Email</label>
                                                            <input type="email" name="email" value="{{ $member->email }}" class="form-control" placeholder="Email" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label>Phone</label>
                                                            <input type="text" name="phone" value="{{ $member->phone }}" class="form-control" placeholder="Phone">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label>Position</label>
                                                            <input type="text" name="position" value="{{ $member->position }}" class="form-control" placeholder="Position">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label>Department</label>
                                                            <select name=" department_id" class="form-select" required>
                                                            @foreach($departments as $dept)
                                                            <option value="{{ $dept->id }}" {{ $member->department_id == $dept->id ? 'selected' : '' }}>
                                                                {{ $dept->name }}
                                                            </option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-warning" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteStaffModal{{ $member->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('staff.destroy', $member->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Delete Staff</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete <strong>{{ $member->name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-danger" type="submit">Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('staff.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>User</label>
                            <select name="user_id" class="form-select" required>
                                <option value="" disabled selected>Select user</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Names</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                        </div>
                        <div class="form-group mb-3">
                            <label>Position</label>
                            <input type="text" name="position" class="form-control" placeholder="Position">
                        </div>
                        <div class="form-group mb-3">
                            <label>Department</label>
                            <select name="department_id" class="form-select" required>
                                <option value="" disabled selected>Select department</option>
                                @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Add Staff</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection