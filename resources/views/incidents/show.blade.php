@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="page-inner">

        <div class="row g-4">

            <!-- Incident Details -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted' : '' }}">
                    <div class="card-header {{ $incident->status === 'resolved' ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                        <h5 class="mb-0">Case Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Title:</strong> {{ $incident->title }}</p>
                        <p><strong>Description:</strong> {{ $incident->description }}</p>
                        <p><strong>Location:</strong> {{ $incident->location }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge 
                                {{ $incident->status === 'open' ? 'bg-success' : ($incident->status === 'in_progress' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ ucfirst($incident->status) }}
                            </span>
                        </p>
                        <p><strong>Category:</strong> {{ $incident->category->name ?? 'N/A' }}</p>
                        <p><strong>Reported By:</strong> {{ $incident->reporter->name ?? 'N/A' }}</p>
                        <p><strong>Reported On:</strong> {{ $incident->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted opacity-75' : '' }}">
                    <div class="card-header {{ $incident->status === 'resolved' ? 'bg-secondary text-white' : 'bg-info text-white' }}">
                        <h5 class="mb-0">Evidences</h5>
                    </div>
                    <div class="card-body">
                        @if($incident->reviews->count())
                        @foreach($incident->reviews as $review)
                        <div class="mb-3 pb-2 border-bottom {{ $incident->status === 'resolved' ? 'opacity-75' : '' }}">
                            <p class="mt-1">{{ $review->comment }}</p>
                            @if($review->media)
                            <a href="{{ asset('storage/' . $review->media) }}" target="_blank">📎 View Attachment</a><br>
                            @endif
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted">No evidences yet.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Notes & Leave Review -->
        <div class="row g-4 mt-3">

            <!-- Daily Notes -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted opacity-75' : '' }}">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Daily Notes</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('incidents.notes.store', $incident->id) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="note" class="form-control" rows="3" placeholder="Add daily note..."
                                    @if($incident->status === 'resolved') disabled @endif></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary"
                                @if($incident->status === 'resolved') disabled @endif>
                                Add Note
                            </button>
                        </form>
                        <hr>
                        @foreach ($incident->dailyNotes()->latest()->get() as $note)
                        <div class="mb-3 p-2 bg-light rounded {{ $incident->status === 'resolved' ? 'opacity-75' : '' }}">
                            <small class="text-muted"><strong>{{ $note->user->name }}</strong> - {{ $note->created_at->format('M d, Y H:i') }}</small>
                            <p class="mb-0">{{ $note->note }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Leave Review -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted opacity-75' : '' }}">
                    <div class="card-header {{ $incident->status === 'resolved' ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                        <h5 class="mb-0">Add evidences</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('incident-reviews.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="incident_id" value="{{ $incident->id }}">

                            <div class="mb-3">
                                <label class="form-label">Comment</label>
                                <textarea name="comment" class="form-control" rows="3"
                                    @if($incident->status === 'resolved') disabled @endif></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attach Media (Optional)</label>
                                <input type="file" name="media" class="form-control"
                                    @if($incident->status === 'resolved') disabled @endif>
                            </div>

                            <button type="submit" class="btn btn-primary"
                                @if($incident->status === 'resolved') disabled @endif>
                                Submit evidences
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Audit Logs & Mitigations -->
        <div class="row g-4 mt-3">

            <!-- Audit Logs -->
            <!-- <div class="col-md-7">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'opacity-75' : '' }}">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Audit Logs</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
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
                                        <td colspan="7" class="text-center text-muted">No audit logs found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Feedback -->
             <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted opacity-75' : '' }}">
                    <div class="card-header {{ $incident->status === 'resolved' ? 'bg-secondary text-white' : 'bg-info text-white' }}">
                        <h5 class="mb-0">Feedback</h5>
                        <!-- add button to give feedback -->
                         @if( Auth::check() && $incident->status !== 'resolved' && (Auth::user()->role == 'admin' || Auth::user()->role == 'handler') )
                        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#feedbackModal">Give Feedback</button>
                        @endif
                        <!-- Feedback Modal -->
                        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="feedbackModalLabel">Submit Feedback</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('incidents.feedback.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="incident_id" value="{{ $incident->id }}">
                                            <div class="mb-3">
                                                <label for="comment" class="form-label">Comment</label>
                                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="media" class="form-label">Attach Media (Optional)</label>
                                                <input class="form-control" type="file" id="media" name="media">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($incident->feedbacks->count())
                        @foreach($incident->feedbacks as $feedback)
                        <div class="mb-3 pb-2 border-bottom {{ $incident->status === 'resolved' ? 'opacity-75' : '' }}">
                            <p class="mt-1">{{ $feedback->comment }}</p>
                            @if($feedback->media)
                            <a href="{{ asset('storage/' . $feedback->media) }}" target="_blank">📎 View Attachment</a><br>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted">No feedback available.</p>
                        @endif
                    </div>
                </div>
            </div>



            <!-- Mitigations -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 {{ $incident->status === 'resolved' ? 'bg-light text-muted opacity-75' : '' }}">
                    <div class="card-header {{ $incident->status === 'resolved' ? 'bg-secondary text-white' : 'bg-secondary text-white' }}">
                        <h5 class="mb-0">Resolutions</h5>
                    </div>
                    <div class="card-body">
                        @if($incident->mitigations->count())
                        <ul class="list-group mb-3 {{ $incident->status === 'resolved' ? 'opacity-75' : '' }}">
                            @foreach($incident->mitigations as $mitigation)
                            <li class="list-group-item {{ $incident->status === 'resolved' ? 'bg-white text-muted' : '' }}">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-3">{{ $mitigation->mitigation }}</p>&nbsp;
                                    
                                    <p class="mb-3">
                                        <strong>{{ $mitigation->user->name }}</strong>
                                        <small class="text-muted">{{ $mitigation->created_at->format('d M Y H:i') }}</small>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted">No mitigations recorded yet.</p>
                        @endif

                        <form action="{{ route('incidents.mitigations.store', $incident->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Add Resolution</label>
                                <textarea name="mitigation" class="form-control" rows="3"
                                    @if($incident->status === 'resolved') disabled @endif></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary"
                                @if($incident->status === 'resolved') disabled @endif>
                                Add Resolution
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection