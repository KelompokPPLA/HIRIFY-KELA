<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Hirify</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background: #f7f9fc; color: #0f172a; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #10182d 0%, #1e3a5f 100%); padding: 40px 48px; text-align: center; }
        .header-logo { font-size: 28px; font-weight: 800; color: #26c6da; letter-spacing: -0.5px; }
        .header-logo span { color: #fff; }
        .body { padding: 48px; }
        .greeting { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 16px; }
        .text { font-size: 15px; color: #5b6b82; line-height: 1.7; margin-bottom: 24px; }
        .btn-wrapper { text-align: center; margin: 32px 0; }
        .btn { display: inline-block; background: #26c6da; color: #fff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-size: 15px; font-weight: 700; letter-spacing: 0.3px; }
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 32px 0; }
        .link-fallback { font-size: 13px; color: #5b6b82; word-break: break-all; }
        .link-fallback a { color: #26c6da; }
        .warning { background: #fef9c3; border: 1px solid #fde047; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #713f12; margin-bottom: 24px; }
        .footer { background: #f8fafc; padding: 24px 48px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-logo">Hirify<span>.</span></div>
    </div>
    <div class="body">
        <div class="greeting">Halo, {{ $userName }}!</div>
        <p class="text">
            Kami menerima permintaan untuk mereset password akun Hirify Anda.
            Klik tombol di bawah untuk membuat password baru.
        </p>

        <div class="warning">
            ⏰ Link ini hanya berlaku selama <strong>{{ $expiresInMinutes }} menit</strong> dan hanya dapat digunakan sekali.
        </div>

        <div class="btn-wrapper">
            <a href="{{ $resetUrl }}" class="btn">Reset Password Saya</a>
        </div>

        <hr class="divider">

        <p class="link-fallback">
            Jika tombol tidak berfungsi, salin dan tempel link berikut ke browser Anda:<br>
            <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
        </p>

        <p class="text" style="margin-top: 24px;">
            Jika Anda tidak meminta reset password, abaikan email ini.
            Password Anda tidak akan berubah.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Hirify. Semua hak dilindungi.<br>
        Platform pengembangan karier untuk mahasiswa dan pencari kerja.
    </div>
</div>
</body>
</html>
