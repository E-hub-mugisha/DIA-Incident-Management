@extends('layouts.app')
@section('title','Users')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Management</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-plus-circle"></i> Add User
                            </button>
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit User Modal -->
                                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('users.update', $user->id) }}">
                                                @csrf @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title">Edit User</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-3" placeholder="Full Name" required>
                                                        <select name="role" class="form-select mb-3" required>
                                                            @foreach(['admin','handler','reporter'] as $role)
                                                            <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ $role }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary" type="submit">Update</button>
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
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
                        <input type="email" name="email" class="form-control mb-3" placeholder="Email Address" required>
                        <select name="role" class="form-select mb-3" required>
                            <option disabled selected>Select Role</option>
                            @foreach(['admin','handler','reporter'] as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Create User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection