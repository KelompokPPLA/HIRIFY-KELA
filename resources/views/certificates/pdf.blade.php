<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->course_title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #fff;
            width: 297mm;
            height: 210mm;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cert {
            width: 270mm;
            height: 190mm;
            border: 8px solid #0f172a;
            border-radius: 12px;
            position: relative;
            padding: 20mm 22mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #fff;
        }
        .cert::before {
            content: '';
            position: absolute;
            inset: 6px;
            border: 2px solid #26c6da;
            border-radius: 8px;
            pointer-events: none;
        }
        .logo {
            font-size: 28px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -1px;
            margin-bottom: 4px;
        }
        .logo span { color: #26c6da; }
        .subtitle {
            font-size: 11px;
            color: #64748b;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #26c6da, #0f172a);
            border-radius: 2px;
            margin: 0 auto 20px;
        }
        .cert-title {
            font-size: 13px;
            color: #64748b;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .recipient {
            font-size: 36px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .completion-text {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 6px;
        }
        .course-name {
            font-size: 22px;
            font-weight: 700;
            color: #26c6da;
            margin-bottom: 14px;
        }
        .meta {
            display: flex;
            gap: 40px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .meta-item { text-align: center; }
        .meta-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .meta-value { font-size: 12px; font-weight: 700; color: #0f172a; margin-top: 2px; }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }
        .cert-number { font-size: 9px; color: #94a3b8; }
        .verify-code { font-size: 9px; color: #64748b; text-align: right; }
        .verify-code strong { color: #26c6da; font-size: 11px; letter-spacing: 1px; }
    </style>
</head>
<body>
<div class="cert">
    <div class="logo">Hirify<span>.</span></div>
    <div class="subtitle">Platform Pengembangan Karier</div>
    <div class="divider"></div>

    <div class="cert-title">Certificate of Completion</div>
    <div class="recipient">{{ $certificate->user_name }}</div>
    <div class="completion-text">telah berhasil menyelesaikan pelatihan</div>
    <div class="course-name">{{ $certificate->course_title }}</div>

    <div class="meta">
        @if($certificate->instructor_name)
        <div class="meta-item">
            <div class="meta-label">Instruktur</div>
            <div class="meta-value">{{ $certificate->instructor_name }}</div>
        </div>
        @endif
        <div class="meta-item">
            <div class="meta-label">Tanggal Penyelesaian</div>
            <div class="meta-value">{{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Nomor Sertifikat</div>
            <div class="meta-value">{{ $certificate->certificate_number }}</div>
        </div>
    </div>

    <div class="footer">
        <div class="cert-number">Sertifikat ini diterbitkan secara resmi oleh Hirify</div>
        <div class="verify-code">
            Kode Verifikasi: <strong>{{ $certificate->verification_code }}</strong><br>
            Verifikasi di: {{ config('app.url') }}/sertifikat/verifikasi
        </div>
    </div>
</div>
</body>
</html>
