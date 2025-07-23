@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Admin Dashboard</h1>

                {{-- Export Buttons --}}
                <div class="mb-4">
                    <a href="{{ route('dashboard.export.excel') }}" class="btn btn-success btn-sm">Export Excel</a>
                    <a href="{{ route('dashboard.export.pdf') }}" class="btn btn-danger btn-sm">Export PDF</a>
                </div>

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text fs-3">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total incidents</h5>
                                <p class="card-text fs-3">{{ $totalIncidents }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Mitigations</h5>
                                <p class="card-text fs-3">{{ $totalMitigations }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Departments</h5>
                                <p class="card-text fs-3">{{ $totalDepartments }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Charts --}}
            <div class="row mb-4">
                <div class="col-md-5">
                    <canvas id="mitigationStatusChart"></canvas>
                </div>

                <div class="col-md-7">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>

            {{-- Active incidents Without Mitigation --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h5 class="card-title text-danger">Active incidents Without Mitigation</h5>
                            <div class="table-responsive">
                                <table id="basic-datatables" class="table table-striped table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Severity</th>
                                            <th>Reported By</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th class="text-center">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($IncidentsWithoutMitigation as $index => $incident)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $incident->title }}</td>
                                            <td>{{ $incident->category->name ?? 'N/A' }}</td>
                                            <td>{{ $incident->severity }}</td>
                                            <td>{{ $incident->reportedBy->name ?? 'N/A' }}</td>

                                            <td>{{ $incident->location ?? 'N/A' }}</td>
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
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal{{ $incident->id }}">
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
                                                                    <h5 class="modal-title" id="assignModalLabel{{ $incident->id }}">Assign Incident: {{ $incident->title }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="assigned_to_{{ $incident->id }}" class="form-label">Assign To</label>
                                                                        <select name="assigned_to" id="assigned_to_{{ $incident->id }}" class="form-select" required>
                                                                            <option value="">-- Select Handler/Admin --</option>
                                                                            @foreach($users as $user)
                                                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status_{{ $incident->id }}" class="form-label">Status</label>
                                                                        <select name="status" id="status_{{ $incident->id }}" class="form-select" required>
                                                                            <option value="new">New</option>
                                                                            <option value="acknowledged">Acknowledged</option>
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
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteIncidentModal{{ $incident->id }}">
                                                    Delete
                                                </button>

                                            </td>
                                        </tr>

                                        {{-- Show Incident Modal --}}
                                        <div class="modal fade
                                            " id="showIncidentModal{{ $incident->id }}" tabindex="-1">
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


                                        {{-- Delete Incident Modal --}}
                                        <div class="modal fade
                                            " id="deleteIncidentModal{{ $incident->id }}" tabindex="-1">
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
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent incidents Table --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
    </div>
</div>
</div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mitigation Status Pie Chart
    const statusCtx = document.getElementById('mitigationStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: {
                !!json_encode(array_keys($statusSummary)) !!
            },
            datasets: [{
                label: 'Mitigation Status',
                data: {
                    !!json_encode(array_values($statusSummary)) !!
                },
                backgroundColor: ['#0d6efd', '#ffc107', '#198754', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Mitigation Status Overview'
                }
            }
        }
    });

    // Monthly Line Chart
    const monthCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: {
                !!json_encode(array_keys($monthlyData)) !!
            },
            datasets: [{
                label: 'Mitigations Created',
                data: {
                    !!json_encode(array_values($monthlyData)) !!
                },
                borderColor: '#0d6efd',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Mitigation Trends (' + new Date().getFullYear() + ')'
                }
            }
        }
    });
</script>
@endsection