<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Incident Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #444;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #222;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #2c3e50;
            border-left: 4px solid #2c3e50;
            padding-left: 8px;
        }

        .details p {
            margin: 4px 0;
        }

        .highlight {
            background-color: #f9f9f9;
            padding: 6px;
            border-radius: 4px;
            border-left: 4px solid #3498db;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            color: #000;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #888;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Incident Report</h2>
        <p>Generated on {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="section-title">Incident Details</div>
    <div class="details">
        <div class="highlight"><strong>ID:</strong> {{ $incident->id }}</div>
        <p><strong>Title:</strong> {{ $incident->title }}</p>
        <p><strong>Description:</strong> {{ $incident->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($incident->status) }}</p>
        <p><strong>Reported By:</strong> {{ $incident->reportedBy->name ?? 'N/A' }}</p>
        <p><strong>Assigned To:</strong> {{ $incident->assignedTo->name ?? 'Unassigned' }}</p>
        <p><strong>Created At:</strong> {{ $incident->created_at->format('d M Y H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $incident->updated_at->format('d M Y H:i') }}</p>
    </div>

    @if($incident->mitigations)
        <div class="section-title">Mitigation Details</div>
        <table>
            <tr>
                <th>Action Taken</th>
                <th>Mitigated By</th>
                <th>Mitigated At</th>
            </tr>
            @foreach($incident->mitigations as $mitigation)
            <tr>
                <td>{{ $mitigation->mitigation }}</td>
                <td>{{ $mitigation->user->name ?? 'N/A' }}</td>
                <td>{{ $mitigation->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </table>
    @endif

    <div class="footer">
        Confidential • Internal Use Only
    </div>
</body>
</html>
