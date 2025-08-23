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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIncidentModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Incident
                        </button>
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
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incidents as $index => $incident)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ route('incidents.show', $incident->id ) }}">{{ $incident->title }} </a></td>
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
                                        <td>
                                            @php
                                            $statusColors = ['new' => 'primary', 'acknowledged' => 'warning', 'in_progress' => 'info', 'resolved' => 'success'];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$incident->status] ?? 'secondary' }}">{{ ucwords(str_replace('_', ' ', $incident->status)) }}</span>

                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showIncidentModal{{ $incident->id }}">
                                                View
                                            </button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editIncidentModal{{ $incident->id }}">
                                                Edit
                                            </button>
                                            
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#generateReportModal{{ $incident->id }}">
                                                Generate Report
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteIncidentModal{{ $incident->id }}">
                                                Delete
                                            </button>
                                        </td>

                                    </tr>

                                    {{-- Show Incident Modal --}}
                                    <div class="modal fade
                                            " id="showIncidentModal{{ $incident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content shadow rounded-4">
                                                <div class="modal-header bg-info text-white rounded-top-4">
                                                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Incident Details</h5>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Title:</strong> {{ $incident->title }}</p>
                                                            <p><strong>Description:</strong> {{ $incident->description }}</p>
                                                            <p><strong>Category:</strong> {{ $incident->category->name ?? 'N/A' }}</p>
                                                            <p><strong>Severity:</strong> {{ $incident->severity }}</p>
                                                            <p><strong>Reported By:</strong> {{ $incident->reportedBy->name ?? 'N/A' }}</p>
                                                            <p><strong>Assigned To:</strong> {{ $incident->assignedTo->name ?? 'N/A' }}</p>
                                                            <p><strong>Status:</strong> {{ $incident->status }}</p>
                                                            <p><strong>Location:</strong> {{ $incident->location ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <form action="{{ route('incident-reviews.store') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="incident_id" value="{{ $incident->id }}">

                                                                <div class="mb-3">
                                                                    <label for="rating" class="form-label">Rating (1–5)</label>
                                                                    <select name="rating" id="rating" class="form-select" required>
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                                            @endfor
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="comment" class="form-label">Comment</label>
                                                                    <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="media" class="form-label">Upload File (optional)</label>
                                                                    <input type="file" name="media" class="form-control">
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Edit Incident Modal --}}
                                    <div class="modal fade" id="editIncidentModal{{ $incident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST" action="{{ route('incidents.update', $incident->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content shadow rounded-4">
                                                    <div class="modal-header bg-warning text-white rounded-top-4">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-pencil-square me-2"></i>Edit Incident
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="mb-3">
                                                            <label for="title{{ $incident->id }}" class="form-label">Title</label>
                                                            <input id="title{{ $incident->id }}" name="title" class="form-control" value="{{ $incident->title }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="description{{ $incident->id }}" class="form-label">Description</label>
                                                            <textarea id="description{{ $incident->id }}" name="description" class="form-control" required>{{ $incident->description }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="category_id{{ $incident->id }}" class="form-label">Category</label>
                                                            <select id="category_id{{ $incident->id }}" name="category_id" class="form-select" required>
                                                                <option value="">-- Select Category --</option>
                                                                @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $incident->category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="severity{{ $incident->id }}" class="form-label">Severity</label>
                                                            <select id="severity{{ $incident->id }}" name="severity" class="form-select" required>
                                                                <option value="">-- Severity --</option>
                                                                @foreach (['low', 'medium', 'high', 'critical'] as $option)
                                                                <option value="{{ $option }}" {{ $incident->severity == $option ? 'selected' : '' }}>
                                                                    {{ ucfirst($option) }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="reported_by{{ $incident->id }}" class="form-label">Reported By</label>
                                                            <select id="reported_by{{ $incident->id }}" name="reported_by" class="form-select" required>
                                                                <option value="">-- Reported By --</option>
                                                                @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" {{ $incident->reported_by == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="assigned_to{{ $incident->id }}" class="form-label">Assigned To</label>
                                                            <select id="assigned_to{{ $incident->id }}" name="assigned_to" class="form-select">
                                                                <option value="">-- Assigned To --</option>
                                                                @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" {{ $incident->assigned_to == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="status{{ $incident->id }}" class="form-label">Status</label>
                                                            <select id="status{{ $incident->id }}" name="status" class="form-select" required>
                                                                <option value="">-- Status --</option>
                                                                @foreach (['new', 'acknowledged', 'in_progress', 'resolved'] as $status)
                                                                <option value="{{ $status }}" {{ $incident->status == $status ? 'selected' : '' }}>
                                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="location{{ $incident->id }}" class="form-label">Location</label>
                                                            <input id="location{{ $incident->id }}" name="location" class="form-control" value="{{ $incident->location }}">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update Incident</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Generate Report Modal --}}
                                    <div class="modal fade" id="generateReportModal{{ $incident->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info text-white rounded-top-4">
                                                    <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i>Generate Incident Report</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to generate a report for this incident?</p>
                                                    <p><strong>{{ $incident->title }}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('incidents.report', $incident->id) }}" class="btn btn-info">
                                                        <i class="bi bi-file-earmark-pdf me-1"></i> Download Report
                                                    </a>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Delete Incident Modal --}}
                                    <div class="modal fade" id="deleteIncidentModal{{ $incident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow rounded-4">
                                                <div class="modal-header bg-danger text-white rounded-top-4">
                                                    <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Incident</h5>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this incident?</p>
                                                    <p><strong>{{ $incident->title }}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="{{ route('incidents.destroy', $incident->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Report Incident Modal --}}
                                        <div class="modal fade" id="reportIncidentModal{{ $incident->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow rounded-4">
                                                    <div class="modal-header bg-info text-white rounded-top-4">
                                                        <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i>Report Incident</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('incidents.report', $incident->id) }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to generate a report for this incident?</p>
                                                            <p><strong>{{ $incident->title }}</strong></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-info">Generate Report</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
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

    {{-- Add Modal --}}
    <div class="modal fade" id="addIncidentModal" tabindex="-1" aria-labelledby="addIncidentModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <form method="POST" action="{{ route('incidents.store') }}">
                @csrf
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title" id="addIncidentModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>Add Incident
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label for="incidentTitle" class="form-label">Title</label>
                            <input type="text" id="incidentTitle" name="title" class="form-control" placeholder="Enter incident title" required>
                        </div>

                        <div class="mb-3">
                            <label for="incidentDescription" class="form-label">Description</label>
                            <textarea id="incidentDescription" name="description" class="form-control" placeholder="Describe the incident" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="incidentCategory" class="form-label">Category</label>
                            <select id="incidentCategory" name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="incidentSeverity" class="form-label">Severity</label>
                            <select id="incidentSeverity" name="severity" class="form-select" required>
                                <option value="">-- Select Severity --</option>
                                @foreach (['low', 'medium', 'high', 'critical'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="reportedBy" class="form-label">Reported By</label>
                            <select id="reportedBy" name="reported_by" class="form-select" required>
                                <option value="">-- Select Reporter --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="assignedTo" class="form-label">Assigned To</label>
                            <select id="assignedTo" name="assigned_to" class="form-select">
                                <option value="">-- Assign to Someone (Optional) --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="incidentStatus" class="form-label">Status</label>
                            <select id="incidentStatus" name="status" class="form-select" required>
                                <option value="">-- Select Status --</option>
                                @foreach (['new', 'acknowledged', 'in_progress', 'resolved'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="incidentLocation" class="form-label">Location</label>
                            <input type="text" id="incidentLocation" name="location" class="form-control" placeholder="Where did the incident occur?">
                        </div>
                    </div>

                    <div class="modal-footer bg-light rounded-bottom-4 px-4 py-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit Incident
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection