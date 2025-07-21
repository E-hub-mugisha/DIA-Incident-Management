@extends('layouts.app')
@section('title','Mitigations')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mitigation Actions</h4>

                        {{-- Success & Error Alerts --}}
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- Add Button --}}
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Mitigation</button>

                            {{-- Table --}}
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Risk</th>
                                        <th>Action Plan</th>
                                        <th>Responsible</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mitigations as $mitigation)
                                    <tr>
                                        <td>{{ $mitigation->risk->title }}</td>
                                        <td>{{ $mitigation->strategy }}</td>
                                        <td>{{ $mitigation->staff->name }}</td>
                                        <td>{{ $mitigation->deadline }}</td>
                                        <td>
                                            <span class="badge bg-{{ $mitigation->status == 'Completed' ? 'success' : ($mitigation->status == 'In Progress' ? 'warning' : 'secondary') }}">
                                                {{ $mitigation->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $mitigation->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $mitigation->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($mitigations as $mitigation)
    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal{{ $mitigation->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('mitigations.update', $mitigation->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mitigation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="risk_id" value="{{ $mitigation->risk_id }}">
                    <div class="mb-3">
                        <label>Strategy Plan</label>
                        <input type="text" name="strategy" class="form-control" value="{{ $mitigation->strategy }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Staff</label>
                        <select name="staff_id" class="form-select" required>
                            <option value="">Select staff</option>
                            @foreach( $staffs as $staff)
                            <option value="{{ $staff->id }}" {{ $mitigation->staff_id ? 'selected' : ''}}>{{ $mitigation->staff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="{{ $mitigation->deadline }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Not Started', 'In Progress', 'Completed', 'Overdue'] as $status)
                            <option value="{{ $status }}" {{ $mitigation->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    @foreach($mitigations as $mitigation)
    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteModal{{ $mitigation->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('mitigations.destroy', $mitigation->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this mitigation action?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    {{-- Add Modal --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('mitigations.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Mitigation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Risk</label>
                        <select name="risk_id" class="form-select" required>
                            <option value="">Select Risk</option>
                            @foreach( $risks as $risk)
                            <option value="{{ $risk->id }}">{{ $risk->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Strategy Plan</label>
                        <input type="text" name="strategy" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Staff</label>
                        <select name="staff_id" class="form-select" required>
                            <option value="">Select staff</option>
                            @foreach( $staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deadline</label>
                        <input type="date" name="deadline" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Overdue">Overdue</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection