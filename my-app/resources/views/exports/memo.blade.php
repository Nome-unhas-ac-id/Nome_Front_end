<!doctype html>
<html lang="id">
<head><meta charset="UTF-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:11px;line-height:1.5}h1{font-size:18px}h2{font-size:14px}table{border-collapse:collapse;width:100%}td,th{border:1px solid #aaa;padding:5px}.letter{page-break-before:always}</style></head>
<body>
<h1>{{ $memo->title }}</h1>
<p>Tanggal: {{ $memo->meeting_date->format('Y-m-d') }}<br>
Waktu: {{ $memo->meeting_time ?: '-' }} — {{ $memo->meeting_end_time ?: '-' }} WITA<br>
Lokasi: {{ $memo->location ?: '-' }}<br>Pimpinan: {{ $memo->leader_name ?: '-' }}<br>Notulis: {{ $memo->notetaker_name ?: '-' }}</p>
<h2>Agenda</h2><p>{{ $memo->agenda ?: '-' }}</p>
<h2>Ringkasan</h2>{!! $summary !!}
<h2>Daftar Hadir</h2><ol>@foreach ($memo->attendees ?? [] as $person)<li>{{ $person['name'] }} — {{ $person['agency_or_position'] ?? '' }}</li>@endforeach</ol>
@if ($memo->letter)<section class="letter"><h1>Surat Pengantar</h1>@foreach ($memo->letter as $field => $value)@if ($value)<p><strong>{{ str_replace('_', ' ', ucfirst($field)) }}:</strong> {{ $value }}</p>@endif @endforeach</section>@endif
</body></html>
