@extends('layouts.app')
@section('title','Monitoring & Reports')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Mitigation Monitoring & Reporting</h2>

                <div class="row mb-4">
                    <div class="col-md-6" style="height: 350px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">Status Summary</h5>
                                <ul class="list-group">
                                    @foreach($statusSummary as $status => $count)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ $status }}</span>
                                        <span class="badge bg-primary">{{ $count }}</span>
                                    </li>
                                    @endforeach
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Overdue</span>
                                        <span class="badge bg-danger">{{ $overdueCount }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mitigation Table (unchanged) --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Risk</th>
                                        <th>Strategy</th>
                                        <th>Staff</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Overdue?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mitigations as $mitigation)
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
                                            @if($mitigation->is_overdue)
                                            <span class="text-danger fw-bold">Yes</span>
                                            @else
                                            <span class="text-success">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">No mitigation data available.</td>
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statusChart').getContext('2d');

        const statusLabels = {
            !!json_encode(array_keys($statusSummary)) !!
        };
        const statusData = {
            !!json_encode(array_values($statusSummary)) !!
        };

        const backgroundColors = ['#0d6efd', '#ffc107', '#198754', '#dc3545'];

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Mitigation Status',
                    data: statusData,
                    backgroundColor: backgroundColors.slice(0, statusLabels.length),
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
    });
</script>