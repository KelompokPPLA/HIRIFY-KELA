<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hirify | CV - {{ $cv->nama_lengkap }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f4f8fd;--card:#fff;--ink:#0d1b3d;--muted:#6c7a93;--line:#e5edf6;--brand:#06cbe5;--deep:#08152f;--shadow:0 20px 45px rgba(9,20,51,.08)}
        *{box-sizing:border-box;margin:0}
        body{font-family:'Manrope',sans-serif;color:var(--ink);background:radial-gradient(circle at 5% 15%,rgba(6,203,229,.16),transparent 24%),radial-gradient(circle at 95% 5%,rgba(6,203,229,.12),transparent 20%),var(--bg)}
        .layout{min-height:100vh;display:grid;grid-template-columns:250px 1fr}
        .sidebar{background:#fff;border-right:1px solid var(--line);padding:22px 16px;display:flex;flex-direction:column;gap:18px}
        .brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:30px;letter-spacing:-.02em}
        .brand-mark{width:34px;height:34px;border-radius:12px;background:linear-gradient(145deg,#0399b7,#06d8ee);display:grid;place-items:center;color:#fff;font-size:17px;font-weight:800}
        .menu{display:grid;gap:8px}
        .menu a{border:0;background:transparent;color:#1a2a4c;font:inherit;text-align:left;border-radius:12px;padding:11px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:600;text-decoration:none}
        .menu a:hover{background:#f2f8ff}
        .menu .active{background:linear-gradient(145deg,#0a1632,#111f45);color:#f2fbff;box-shadow:0 10px 20px rgba(11,24,54,.22)}
        .profile-mini{margin-top:auto;background:#f8fbff;border:1px solid var(--line);border-radius:14px;padding:12px;display:flex;align-items:center;gap:10px}
        .avatar-mini{width:34px;height:34px;border-radius:50%;background:linear-gradient(140deg,#0499b3,#05d5ef);color:#fff;display:grid;place-items:center;font-weight:800}
        .profile-mini strong{display:block;font-size:.92rem}
        .profile-mini span{color:var(--muted);font-size:.82rem}
        .content{padding:24px 32px;display:grid;gap:20px;align-content:start}
        .top-bar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px}
        .title-wrap h1{font-size:clamp(26px,3.5vw,36px);letter-spacing:-.03em}
        .title-wrap p{margin:6px 0 0;color:var(--muted);font-weight:500}
        .btn{border:0;border-radius:12px;padding:11px 18px;font:inherit;font-weight:700;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:transform .15s}
        .btn:hover{transform:translateY(-1px)}
        .btn-brand{background:linear-gradient(140deg,#08cde6,#00b2cb);color:#fff}
        .btn-ghost{background:#f3f8fe;color:#17315f;border:1px solid #dbe8f6}
        .btn-danger{background:rgba(180,35,24,.08);color:#b42318;border:1px solid rgba(180,35,24,.24)}
        /* ATS Document — A4 paper feel */
        .cv-doc{background:#fff;padding:40px 48px;max-width:680px;min-height:800px;font-family:'Manrope',Arial,Helvetica,sans-serif;border:1px solid #d0d0d0;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden;word-break:break-word;overflow-wrap:break-word;white-space:normal}
        .cv-name{text-align:center;font-size:1.4rem;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#111;margin-bottom:6px;word-break:break-word}
        .cv-contact{text-align:center;color:#555;font-size:.85rem;line-height:1.6;word-break:break-word;overflow-wrap:break-word}
        .cv-section-title{font-size:.82rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#111;margin:24px 0 8px;padding-bottom:4px;border-bottom:1px solid #333}
        .cv-summary{color:#333;font-size:.88rem;line-height:1.7;text-align:justify;word-break:break-word;overflow-wrap:break-word}
        .cv-edu-item{margin-bottom:12px}
        .cv-edu-row{display:flex;justify-content:space-between;align-items:baseline;gap:16px}
        .cv-edu-left{flex:1;min-width:0}
        .cv-edu-inst{font-weight:700;font-size:.9rem;color:#111;word-break:break-word}
        .cv-edu-degree{color:#444;font-size:.86rem}
        .cv-edu-year{color:#666;font-size:.84rem;white-space:nowrap;flex-shrink:0}
        .cv-exp-item{margin-bottom:14px}
        .cv-exp-header{display:flex;justify-content:space-between;align-items:baseline;flex-wrap:wrap;gap:4px}
        .cv-exp-title{font-weight:700;font-size:.9rem;color:#111;word-break:break-word;overflow-wrap:break-word}
        .cv-exp-period{color:#666;font-size:.84rem;white-space:nowrap}
        .cv-exp-desc{margin:4px 0 0;padding:0;list-style:none}
        .cv-exp-desc li{color:#333;font-size:.86rem;line-height:1.65;padding-left:16px;position:relative;word-break:break-word;overflow-wrap:break-word}
        .cv-exp-desc li::before{content:'\2022';position:absolute;left:0;color:#333}
        .cv-skills-sub{font-weight:600;font-size:.88rem;color:#111;margin:12px 0 4px}
        .cv-skills-sub:first-child{margin-top:0}
        .cv-skills-list{margin:0 0 0 20px;padding:0;list-style:disc;color:#333;font-size:.86rem;line-height:1.7}
        .cv-skills-list li{word-break:break-word}
        .actions-row{display:flex;gap:10px;flex-wrap:wrap}
        .ats-badge{background:#edfcff;color:#0494ab;font-size:.75rem;font-weight:800;padding:4px 10px;border-radius:999px;border:1px solid #b0e8f0}
        .toast{position:fixed;top:20px;right:20px;background:#0f2147;color:#fff;padding:14px 20px;border-radius:14px;font-weight:600;z-index:50;animation:fadeIn .3s}
        @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
        @media print{.sidebar,.top-bar,.actions-row,.toast{display:none!important}.layout{grid-template-columns:1fr}.content{padding:0}.cv-doc{border:none;padding:20px}}
        @media(max-width:980px){.layout{grid-template-columns:1fr}.sidebar{border-right:0;border-bottom:1px solid var(--line)}}
        @media(max-width:640px){.content{padding:14px}.cv-doc{padding:20px 18px}}
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
                <a href="#">Profil</a>
                <a href="{{ route('cv.index') }}" class="active">Manajemen CV</a>
                <a href="{{ route('cv.create') }}">✦ Buat CV ATS</a>
                <a href="#">Roadmap Karier</a>
                <a href="#">Self Assessment</a>
                <a href="#">Pelatihan</a>
                <a href="/mentorship">Mentorship</a>
                <a href="#">Notifikasi</a>
            </div>
            <div class="profile-mini">
                <div class="avatar-mini">U</div>
                <div><strong>User Name</strong><span>user@email.com</span></div>
            </div>
        </aside>

        <main class="content">
            <div class="top-bar">
                <div class="title-wrap">
                    <h1>Detail CV ATS</h1>
                    <p>Preview CV ATS-friendly Anda</p>
                </div>
                <div class="actions-row">
                    <span class="ats-badge">ATS-Friendly Format</span>
                    <button class="btn btn-ghost" onclick="window.print()">🖨️ Print / PDF</button>
                    <a href="{{ route('cv.index') }}" class="btn btn-ghost">← Kembali</a>
                    <form action="{{ route('cv.destroy', $cv->id) }}" method="POST" onsubmit="return confirm('Hapus CV ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus CV</button>
                    </form>
                </div>
            </div>

            <div class="cv-doc" id="cvPage">
                <div class="cv-name">{{ strtoupper($cv->nama_lengkap) }}</div>
                <div class="cv-contact">
                    @php
                        $contactParts = array_filter([
                            $cv->alamat,
                            $cv->telepon,
                            $cv->email,
                            $cv->linkedin,
                        ]);
                    @endphp
                    {{ implode(' | ', $contactParts) }}
                </div>

                @if($cv->ringkasan)
                <div class="cv-section-title">PROFESSIONAL SUMMARY</div>
                <div class="cv-summary">{{ $cv->ringkasan }}</div>
                @endif

                @if($cv->educations->count())
                <div class="cv-section-title">EDUCATION</div>
                @foreach($cv->educations as $edu)
                <div class="cv-edu-item">
                    <div class="cv-edu-row">
                        <div class="cv-edu-left">
                            <div class="cv-edu-inst">{{ $edu->institusi }}</div>
                            <div class="cv-edu-degree">{{ $edu->gelar }}</div>
                        </div>
                        <div class="cv-edu-year">{{ $edu->tahun }}</div>
                    </div>
                </div>
                @endforeach
                @endif

                @if($cv->experiences->count())
                <div class="cv-section-title">EXPERIENCE</div>
                @foreach($cv->experiences as $exp)
                <div class="cv-exp-item">
                    <div class="cv-exp-header">
                        <span class="cv-exp-title">{{ $exp->posisi }} &ndash; {{ $exp->perusahaan }}</span>
                        <span class="cv-exp-period">{{ $exp->periode }}</span>
                    </div>
                    @if($exp->deskripsi)
                    <ul class="cv-exp-desc">
                        @foreach(array_filter(array_map('trim', explode("\n", $exp->deskripsi))) as $line)
                        <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
                @endif

                @if($cv->skills)
                <div class="cv-section-title">KEY SKILLS</div>
                @php
                    $skillsData = json_decode($cv->skills, true);
                    $isJson = is_array($skillsData) && (isset($skillsData['technical']) || isset($skillsData['soft']));
                @endphp
                @if($isJson)
                    @if(!empty($skillsData['technical']))
                    <div class="cv-skills-sub">Technical Skills</div>
                    <ul class="cv-skills-list">
                        @foreach($skillsData['technical'] as $skill)
                        <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @if(!empty($skillsData['soft']))
                    <div class="cv-skills-sub">Soft Skills</div>
                    <ul class="cv-skills-list">
                        @foreach($skillsData['soft'] as $skill)
                        <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                    @endif
                @else
                    {{-- Fallback: legacy comma-separated format --}}
                    <ul class="cv-skills-list">
                        @foreach(array_map('trim', explode(',', $cv->skills)) as $skill)
                        <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                @endif
                @endif
            </div>
        </main>
    </div>
</body>
</html>
