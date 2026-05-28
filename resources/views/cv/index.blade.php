<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | Manajemen CV</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f4f8fd;--card:#fff;--ink:#0d1b3d;--muted:#6c7a93;--line:#e5edf6;--brand:#06cbe5;--brand-dark:#06b0c6;--deep:#08152f;--shadow:0 20px 45px rgba(9,20,51,.08)}
        *{box-sizing:border-box;margin:0}
        body{font-family:'Manrope',sans-serif;color:var(--ink);background:radial-gradient(circle at 5% 15%,rgba(6,203,229,.16),transparent 24%),radial-gradient(circle at 95% 5%,rgba(6,203,229,.12),transparent 20%),var(--bg)}
        .layout{min-height:100vh;display:grid;grid-template-columns:250px 1fr}
        .sidebar{background:#fff;border-right:1px solid var(--line);padding:22px 16px;display:flex;flex-direction:column;gap:18px}
        .brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:30px;letter-spacing:-.02em}
        .brand-mark{width:34px;height:34px;border-radius:12px;background:linear-gradient(145deg,#0399b7,#06d8ee);display:grid;place-items:center;color:#fff;font-size:17px;font-weight:800}
        .menu{display:grid;gap:8px}
        .menu a,.menu button{border:0;background:transparent;color:#1a2a4c;font:inherit;text-align:left;border-radius:12px;padding:11px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:600;text-decoration:none}
        .menu a:hover,.menu button:hover{background:#f2f8ff}
        .menu .active{background:linear-gradient(145deg,#0a1632,#111f45);color:#f2fbff;box-shadow:0 10px 20px rgba(11,24,54,.22)}
        .profile-mini{margin-top:auto;background:#f8fbff;border:1px solid var(--line);border-radius:14px;padding:12px;display:flex;align-items:center;gap:10px}
        .avatar-mini{width:34px;height:34px;border-radius:50%;background:linear-gradient(140deg,#0499b3,#05d5ef);color:#fff;display:grid;place-items:center;font-weight:800}
        .profile-mini strong{display:block;font-size:.92rem}
        .profile-mini span{color:var(--muted);font-size:.82rem}
        .content{padding:24px 32px;display:grid;gap:20px;align-content:start}
        .title-wrap h1{font-size:clamp(28px,4vw,40px);letter-spacing:-.03em}
        .title-wrap p{margin:6px 0 0;color:var(--muted);font-weight:500}
        .top-bar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px}
        .btn{border:0;border-radius:12px;padding:11px 18px;font:inherit;font-weight:700;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:transform .15s,box-shadow .2s}
        .btn:hover{transform:translateY(-1px)}
        .btn-brand{background:linear-gradient(140deg,#08cde6,#00b2cb);color:#fff}
        .btn-ghost{background:#f3f8fe;color:#17315f;border:1px solid #dbe8f6}
        .btn-danger{background:rgba(180,35,24,.08);color:#b42318;border:1px solid rgba(180,35,24,.24)}
        .cv-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:16px}
        .cv-card{background:var(--card);border:1px solid var(--line);border-radius:18px;box-shadow:var(--shadow);padding:20px;display:grid;gap:12px;transition:transform .2s,box-shadow .2s}
        .cv-card:hover{transform:translateY(-2px);box-shadow:0 24px 50px rgba(9,20,51,.12)}
        .cv-card h3{font-size:1.2rem;letter-spacing:-.01em}
        .cv-card .meta{color:var(--muted);font-size:.88rem;display:flex;flex-direction:column;gap:4px}
        .cv-card .actions{display:flex;gap:8px;margin-top:4px}
        .tag-list{display:flex;flex-wrap:wrap;gap:6px}
        .tag{padding:3px 9px;border-radius:999px;font-size:.76rem;background:#edfcff;color:#0494ab;font-weight:700}
        .empty{padding:40px;text-align:center;color:var(--muted);background:#fff;border-radius:18px;border:1px dashed #cfdded;grid-column:1/-1}
        .empty h3{color:var(--ink);margin-bottom:6px}
        .toast{position:fixed;top:20px;right:20px;background:#0f2147;color:#fff;padding:14px 20px;border-radius:14px;font-weight:600;z-index:50;animation:fadeIn .3s ease}
        @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
        @media(max-width:980px){.layout{grid-template-columns:1fr}.sidebar{border-right:0;border-bottom:1px solid var(--line)}}
        @media(max-width:640px){.content{padding:14px}.cv-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @if(session('success'))
    <div class="toast" id="toast">{{ session('success') }}</div>
    <script>setTimeout(()=>document.getElementById('toast')?.remove(),3000)</script>
    @endif

    <div class="layout">
        <aside class="sidebar">
            <div class="brand"><span class="brand-mark">H</span><span>Hirify!</span></div>
            <div class="menu">
                <a href="/dashboard">Dashboard</a>
                <a href="/profile">Profil</a>
                <a href="/manajemen-cv" class="active">Manajemen CV</a>
                <a href="/cv/create" style="background:linear-gradient(140deg,#08cde6,#00b2cb);color:#fff;box-shadow:0 4px 12px rgba(6,203,229,.3)">✦ Buat CV ATS</a>
                <a href="/roadmap-karier">Roadmap Karier</a>
                <a href="/self-assessment">Self Assessment</a>
                <a href="/skill-training">Pelatihan</a>
                <a href="/forum">Forum Diskusi</a>
                <a href="/mentorship">Mentorship</a>
                <a href="/notifikasi">Notifikasi</a>
            </div>
            <div class="profile-mini">
                <div class="avatar-mini">U</div>
                <div><strong>User Name</strong><span>user@email.com</span></div>
            </div>
        </aside>

        <main class="content">
            <div class="top-bar">
                <div class="title-wrap">
                    <h1>Manajemen CV</h1>
                    <p>Kelola semua CV ATS Anda di satu tempat.</p>
                </div>
                <a href="{{ route('cv.create') }}" class="btn btn-brand">+ Buat CV Baru</a>
            </div>

            <div class="cv-grid">
                @forelse($cvs as $cv)
                <div class="cv-card">
                    <h3>{{ $cv->nama_lengkap }}</h3>
                    <div class="meta">
                        <span>{{ $cv->email }} • {{ $cv->telepon }}</span>
                        <span>Dibuat: {{ $cv->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($cv->skills->isNotEmpty())
                    <div class="tag-list">
                        @foreach($cv->skills->take(5) as $skill)
                        <span class="tag">{{ $skill->nama_skill }}</span>
                        @endforeach
                        @if($cv->skills->count() > 5)
                        <span class="tag" style="background:#f0f4fa;color:var(--muted)">+{{ $cv->skills->count() - 5 }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="actions">
                        <a href="{{ route('cv.show', $cv->id) }}" class="btn btn-ghost" style="padding:8px 14px;font-size:.88rem">Lihat CV</a>
                        <a href="{{ route('cv.edit', $cv->id) }}" class="btn btn-ghost" style="padding:8px 14px;font-size:.88rem">Edit</a>
                        <form action="{{ route('cv.destroy', $cv->id) }}" method="POST" onsubmit="return confirm('Hapus CV ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:8px 14px;font-size:.88rem">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <h3>Belum ada CV</h3>
                    <p>Mulai buat CV ATS pertama Anda sekarang!</p>
                    <a href="{{ route('cv.create') }}" class="btn btn-brand" style="margin-top:14px">+ Buat CV ATS</a>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>
