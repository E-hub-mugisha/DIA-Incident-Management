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
                                        <th>Incident</th>
                                        <th>Action Plan</th>
                                        <th>Responsible</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mitigations as $mitigation)
                                    <tr>
                                        <td>{{ $mitigation->incident->title }}</td>
                                        <td>{{ $mitigation->mitigation }}</td>
                                        <td>{{ $mitigation->user->name }}</td>
                                        <td>{{ $mitigation->incident->status }}</td>
                                        <td>
                                            <span class="badge bg-{{ $mitigation->incident->status == 'Completed' ? 'success' : ($mitigation->status == 'In Progress' ? 'warning' : 'secondary') }}">
                                                {{ $mitigation->incident->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('incidents.show', $mitigation->incident->id ) }}" class="btn btn-sm btn-warning">view</a>
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
                        <label>Incident</label>
                        <select name="incident_id" class="form-select" required>
                            <option value="">Select incident</option>
                            @foreach( $incidents as $incident)
                            <option value="{{ $incident->id }}">{{ $incident->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Mitigation Plan</label>
                        <input type="text" name="mitigation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select user</option>
                            @foreach( $users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
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