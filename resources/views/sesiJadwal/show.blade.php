<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sesi</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Manrope', sans-serif; margin:0; background:#f7fafc; color:#0f172a }
        .container { width: min(900px, calc(100% - 32px)); margin: 24px auto; }
        .card { background:#fff; padding:18px; border-radius:12px; box-shadow:0 8px 30px rgba(15,23,42,0.06) }
        .muted { color:#64748b }
        .btn { padding:8px 12px; border-radius:10px; background:#0f172a; color:#fff; text-decoration:none }
        .note-box { margin-top:12px; padding:12px; background:#f1f5f9; border-radius:8px }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('mentor.sesiJadwal.index') }}">← Kembali</a>
        <div class="card" style="margin-top:12px">
            <h2>{{ $session->topic }}</h2>
            <div class="muted">{{ $session->date }} • {{ $session->time }} • Durasi: {{ $session->duration }} menit</div>
            <div style="margin-top:8px">Platform: <a href="{{ $session->platform }}" target="_blank">{{ $session->platform }}</a></div>
            <div style="margin-top:8px">Status: <strong>{{ $session->status }}</strong></div>

            @if(session('success'))<div style="margin-top:8px;padding:10px;background:#ecfdf5;border-radius:8px">{{ session('success') }}</div>@endif
            @if(session('error'))<div style="margin-top:8px;padding:10px;background:#fff1f2;border-radius:8px">{{ session('error') }}</div>@endif

            <div style="margin-top:14px">
                <a href="{{ route('sesiJadwal.edit', $session->id) }}" class="btn">Edit Sesi</a>
            </div>

            <h3 style="margin-top:18px">Catatan Hasil Sesi</h3>
            @if($session->notes)
                <div class="note-box">{!! nl2br(e($session->notes)) !!}</div>
            @else
                <div class="muted">Belum ada catatan.</div>
            @endif

            @if($session->status === 'Completed' && !$session->notes)
                <form action="{{ route('sesiJadwal.notes', $session->id) }}" method="POST" style="margin-top:12px">
                    @csrf
                    <textarea name="notes" rows="5" style="width:100%;padding:10px;border-radius:8px;border:1px solid #e2e8f0" placeholder="Tuliskan notes, kesimpulan, rekomendasi..."></textarea>
                    <div style="margin-top:8px"><button class="btn">Simpan Catatan</button></div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>
