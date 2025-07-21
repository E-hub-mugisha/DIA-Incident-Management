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
                                <h5 class="card-title">Total Risks</h5>
                                <p class="card-text fs-3">{{ $totalRisks }}</p>
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

                {{-- Charts --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <canvas id="mitigationStatusChart"></canvas>
                    </div>

                    <div class="col-md-6">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>

                {{-- Active Risks Without Mitigation --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card border-danger">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Active Risks Without Mitigation</h5>
                                <ul class="mb-0">
                                    @forelse($risksWithoutMitigation as $risk)
                                    <li>{{ $risk->title }} (Department: {{ $risk->department->name ?? '-' }})</li>
                                    @empty
                                    <li>All active risks are mitigated.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Risks Table --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h4 class="card-title">Recent Risks</h4>
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Department</th>
                                                <th>Category</th>
                                                <th>Likelihood</th>
                                                <th>Impact</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentRisks as $risk)
                                            <tr>
                                                <td>{{ $risk->title }}</td>
                                                <td>{{ $risk->department->name ?? '-' }}</td>
                                                <td>{{ $risk->category->name ?? '-' }}</td>
                                                <td>{{ $risk->likelihood }}</td>
                                                <td>{{ $risk->impact }}</td>
                                                <td>{{ $risk->status }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No recent risks found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
            }, // month names (Jan, Feb...)
            datasets: [{
                label: 'Mitigations Created',
                data: {
                    !!json_encode(array_values($monthlyData)) !!
                }, // counts per month
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