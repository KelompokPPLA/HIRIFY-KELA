<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Sesi</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body{font-family:Manrope, sans-serif;margin:0;background:#f7fafc;color:#0f172a}.container{width:min(900px,calc(100%-32px));margin:24px auto}.card{background:#fff;padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(15,23,42,0.06)}.btn{padding:8px 12px;border-radius:10px;background:#0f172a;color:#fff;text-decoration:none}.input{width:100%;padding:10px;border-radius:8px;border:1px solid #e6edf3;margin-top:6px}</style>
</head>
<body>
    <div class="container">
        <a href="{{ route('mentor.sesiJadwal.index') }}">← Kembali</a>
        <div class="card" style="margin-top:12px">
            <h2>Buat Sesi Baru</h2>
            @if($errors->any())
                <div style="margin-top:8px;padding:10px;background:#fff1f2;border-radius:8px">
                    <ul style="margin:0;padding-left:18px">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sesiJadwal.store') }}" method="POST" style="margin-top:12px">
                @csrf
                <label>Topik</label>
                <input class="input" name="topic" value="{{ old('topic') }}" required>

                <label style="margin-top:8px">Tanggal</label>
                <input class="input" type="date" name="date" value="{{ old('date') }}" required>

                <label style="margin-top:8px">Waktu</label>
                <input class="input" type="time" name="time" value="{{ old('time') }}" required>

                <label style="margin-top:8px">Durasi (menit)</label>
                <input class="input" type="number" name="duration" value="{{ old('duration', 60) }}" required>

                <label style="margin-top:8px">Platform (link)</label>
                <input class="input" name="platform" value="{{ old('platform') }}">

                <label style="margin-top:8px">Status</label>
                <select class="input" name="status">
                    <option>Pending</option>
                    <option>Confirmed</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>

                <div style="margin-top:12px"><button class="btn">Simpan</button></div>
            </form>
        </div>
    </div>
</body>
</html>
