@extends('layouts.app')
@section('title','Incidents')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0"><i class="bi bi-shield-exclamation me-2 text-danger"></i>Incident Management</h4>
                        <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIncidentModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Incident
                        </button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Severity</th>
                                        <th>Reported By</th>
                                        <th>Assigned To</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incidents as $index => $incident)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $incident->title }}</td>
                                        <td>{{ $incident->category->name ?? 'N/A' }}</td>
                                        <td>{{ $incident->severity }}</td>
                                        <td>{{ $incident->reportedBy->name ?? 'N/A' }}</td>
                                        <td>
                                            @if (is_null($incident->assigned_to))
                                            <!-- Trigger Assign Button -->
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal{{ $incident->id }}">
                                                Assign
                                            </button>

                                            <!-- Assign Modal -->
                                            <div class="modal fade" id="assignModal{{ $incident->id }}" tabindex="-1" aria-labelledby="assignModalLabel{{ $incident->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('incidents.assign', $incident->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignModalLabel{{ $incident->id }}">Assign Incident</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="assigned_to_{{ $incident->id }}" class="form-label">Assign To</label>
                                                                    <select name="assigned_to" id="assigned_to_{{ $incident->id }}" class="form-select" required>
                                                                        <option value="">-- Select User --</option>
                                                                        @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">Assign</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @else
                                            {{ $incident->assignedTo->name }}
                                            @endif

                                        </td>
                                        <td>{{ $incident->location ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                            $statusColors = ['new' => 'primary', 'acknowledged' => 'warning', 'in_progress' => 'info', 'resolved' => 'success'];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$incident->status] ?? 'secondary' }}">{{ ucwords(str_replace('_', ' ', $incident->status)) }}</span>

                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showIncidentModal{{ $incident->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editIncidentModal{{ $incident->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteIncidentModal{{ $incident->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    {{-- Show Incident Modal --}}
                                    <div class="modal fade" id="showIncidentModal{{ $incident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow rounded-4">
                                                <div class="modal-header bg-info text-white rounded-top-4">
                                                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Incident Details</h5>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Title:</strong> {{ $incident->title }}</p>
                                                    <p><strong>Description:</strong> {{ $incident->description }}</p>
                                                    <p><strong>Category:</strong> {{ $incident->category->name ?? 'N/A' }}</p>
                                                    <p><strong>Severity:</strong> {{ $incident->severity }}</p>
                                                    <p><strong>Reported By:</strong> {{ $incident->reportedBy->name ?? 'N/A' }}</p>
                                                    <p><strong>Assigned To:</strong> {{ $incident->assignedTo->name ?? 'N/A' }}</p>
                                                    <p><strong>Status:</strong> {{ $incident->status }}</p>
                                                    <p><strong>Location:</strong> {{ $incident->location ?? 'N/A' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
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

</div>

@endsection