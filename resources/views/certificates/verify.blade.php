<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - Hirify</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; font-family: 'Manrope', sans-serif; background: #f7f9fc; display: grid; place-items: center; padding: 24px; }
        .card { width: min(560px,100%); background: #fff; border-radius: 24px; border: 1px solid rgba(15,23,42,.08); box-shadow: 0 24px 60px rgba(15,23,42,.1); padding: 40px; }
        .logo { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 24px; }
        .logo span { color: #26c6da; }
        h1 { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 8px; }
        p { color: #5b6b82; margin: 0 0 20px; font-size: 14px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
        input { width: 100%; border: 1px solid rgba(15,23,42,.12); border-radius: 12px; padding: 12px 14px; font: inherit; font-size: 14px; outline: none; letter-spacing: 2px; text-transform: uppercase; }
        input:focus { border-color: #26c6da; box-shadow: 0 0 0 4px rgba(38,198,218,.15); }
        button { width: 100%; border: 0; border-radius: 12px; padding: 13px; font: inherit; font-weight: 700; color: #fff; cursor: pointer; background: linear-gradient(135deg, #26c6da, #1aa8c0); }
        .result { margin-top: 24px; padding: 20px; border-radius: 16px; }
        .result.valid { background: #f0fdf4; border: 1px solid #bbf7d0; }
        .result.invalid { background: #fef2f2; border: 1px solid #fecaca; }
        .result-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        .result.valid .result-title { color: #15803d; }
        .result.invalid .result-title { color: #b91c1c; }
        .field { margin-bottom: 8px; }
        .field-label { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .field-value { font-size: 14px; font-weight: 600; color: #0f172a; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">Hirify<span>.</span></div>
    <h1>Verifikasi Sertifikat</h1>
    <p>Masukkan kode verifikasi yang tertera di sertifikat untuk memvalidasi keasliannya.</p>

    <form method="GET" action="{{ route('certificates.verify') }}">
        <div class="form-group">
            <label for="code">Kode Verifikasi</label>
            <input id="code" name="code" type="text" value="{{ request('code') }}" placeholder="XXXX-XXXX-XXXX" required>
        </div>
        <button type="submit">Verifikasi Sekarang</button>
    </form>

    @if($searched)
        @if($certificate)
            <div class="result valid">
                <div class="result-title">✅ Sertifikat Valid</div>
                <div class="field">
                    <div class="field-label">Pemegang Sertifikat</div>
                    <div class="field-value">{{ $certificate->user_name }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Pelatihan</div>
                    <div class="field-value">{{ $certificate->course_title }}</div>
                </div>
                @if($certificate->instructor_name)
                <div class="field">
                    <div class="field-label">Instruktur</div>
                    <div class="field-value">{{ $certificate->instructor_name }}</div>
                </div>
                @endif
                <div class="field">
                    <div class="field-label">Tanggal Terbit</div>
                    <div class="field-value">{{ $certificate->issued_at->format('d M Y') }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Nomor Sertifikat</div>
                    <div class="field-value">{{ $certificate->certificate_number }}</div>
                </div>
            </div>
        @else
            <div class="result invalid">
                <div class="result-title">❌ Sertifikat Tidak Ditemukan</div>
                <p style="margin:0;font-size:13px;color:#b91c1c;">Kode verifikasi <strong>{{ $code }}</strong> tidak valid atau tidak terdaftar di sistem Hirify.</p>
            </div>
        @endif
    @endif
</div>
</body>
</html>
