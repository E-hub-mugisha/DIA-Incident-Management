@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">

            <!-- Left Column: Incident Details -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Incident Details</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Title:</strong> {{ $incident->title }}</p>
                        <p><strong>Description:</strong> {{ $incident->description }}</p>
                        <p><strong>Location:</strong> {{ $incident->location }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($incident->status) }}</p>
                        <p><strong>Category:</strong> {{ $incident->category->name ?? 'N/A' }}</p>
                        <p><strong>Reported By:</strong> {{ $incident->reporter->name ?? 'N/A' }}</p>
                        <p><strong>Reported On:</strong> {{ $incident->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Reviews -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Reviews</h4>
                    </div>
                    <div class="card-body">
                        @if($incident->reviews->count())
                        @foreach($incident->reviews as $review)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-muted"> ({{ $review->rating }}/5)</span>
                            <p>{{ $review->comment }}</p>
                            @if($review->media)
                            <a href="{{ asset('storage/' . $review->media) }}" target="_blank">📎 View Attachment</a><br>
                            @endif
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @endforeach
                        @else
                        <p>No reviews yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Form (Full Width) -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Daily Notes</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('incidents.notes.store', $incident->id) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="note" class="form-control" rows="3" placeholder="Add daily note..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Note</button>
                        </form>
                        <hr>
                        @foreach ($incident->dailyNotes()->latest()->get() as $note)
                        <div class="mb-2">
                            <small><strong>{{ $note->user->name }}</strong> - {{ $note->created_at->format('M d, Y H:i') }}</small>
                            <p>{{ $note->note }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Leave a Review</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('incident-reviews.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="incident_id" value="{{ $incident->id }}">

                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea name="comment" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating (1-5)</label>
                                <select name="rating" class="form-select" required>
                                    <option value="">Select Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="media" class="form-label">Attach Media (Optional)</label>
                                <input type="file" name="media" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-4">Audit Logs</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Event</th>
                                        <th>Changed</th>
                                        <th>Old Values</th>
                                        <th>New Values</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($incident->auditLogs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($log->user)->name ?? 'System' }}</td>
                                        <td><span class="badge bg-info text-dark">{{ ucfirst($log->event) }}</span></td>
                                        <td>
                                            @foreach(json_decode($log->changed_values ?? '[]', true) as $key => $val)
                                            <strong>{{ $key }}</strong><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach(json_decode($log->old_values ?? '[]', true) as $key => $val)
                                            <strong>{{ $key }}:</strong> {{ $val }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach(json_decode($log->new_values ?? '[]', true) as $key => $val)
                                            <strong>{{ $key }}:</strong> {{ $val }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-muted text-center">No audit logs found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-4">Mitigations</h4>
                    </div>
                    <div class="card-body">
                        @if($incident->mitigations->count())
                        <ul class="list-group mb-4">
                            @foreach($incident->mitigations as $mitigation)
                            <li class="list-group-item">
                                <strong>{{ $mitigation->user->name }}</strong>
                                <small class="text-muted">{{ $mitigation->created_at->format('d M Y H:i') }}</small>
                                <p>{{ $mitigation->mitigation }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>No mitigations recorded yet.</p>
                        @endif

                        <form action="{{ route('incidents.mitigations.store', $incident->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="mitigation" class="form-label">Add Mitigation</label>
                                <textarea name="mitigation" id="mitigation" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Mitigation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection