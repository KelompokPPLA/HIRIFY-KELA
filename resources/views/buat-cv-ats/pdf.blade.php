<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV ATS - {{ $cv->nama_lengkap }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
        }

        .cv-wrapper {
            max-width: 700px;
            margin: 0 auto;
            padding: 32px 40px;
        }

        /* Header */
        .cv-name {
            font-size: 20pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4px;
        }
        .cv-contact {
            text-align: center;
            font-size: 9pt;
            color: #444;
            margin-bottom: 2px;
        }
        .cv-address {
            text-align: center;
            font-size: 9pt;
            color: #444;
            margin-bottom: 10px;
        }

        /* Divider */
        .cv-divider {
            border: none;
            border-top: 2px solid #000;
            margin: 10px 0 14px;
        }

        /* Sections */
        .cv-section {
            margin-bottom: 14px;
        }
        .cv-section-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        /* Summary */
        .cv-summary {
            font-size: 10pt;
            color: #333;
        }

        /* Education / Experience rows */
        .cv-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        .cv-row-left { flex: 1; }
        .cv-row-right {
            font-size: 9pt;
            color: #555;
            white-space: nowrap;
            margin-left: 12px;
        }
        .cv-bold { font-weight: bold; font-size: 10pt; }
        .cv-sub  { font-size: 9pt; color: #555; }
        .cv-italic { font-style: italic; font-size: 9pt; color: #555; }
        .cv-desc  { font-size: 9pt; color: #333; margin-top: 3px; }

        /* Skills */
        .skills-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .skills-label {
            font-weight: bold;
            font-size: 9pt;
            margin-bottom: 4px;
        }
        .skills-list {
            list-style: none;
        }
        .skills-list li {
            font-size: 9pt;
            color: #333;
            margin-bottom: 2px;
        }
        .skills-list li::before {
            content: "• ";
            color: #777;
        }
    </style>
</head>
<body>
<div class="cv-wrapper">

    {{-- Name --}}
    <div class="cv-name">{{ $cv->nama_lengkap }}</div>

    {{-- Contact --}}
    @php
        $contacts = array_filter([$cv->email, $cv->telepon, $cv->linkedin]);
    @endphp
    <div class="cv-contact">{{ implode(' | ', $contacts) }}</div>
    @if($cv->alamat)
        <div class="cv-address">{{ $cv->alamat }}</div>
    @endif

    <hr class="cv-divider">

    {{-- Professional Summary --}}
    @if($cv->ringkasan)
        <div class="cv-section">
            <div class="cv-section-title">Professional Summary</div>
            <p class="cv-summary">{{ $cv->ringkasan }}</p>
        </div>
    @endif

    {{-- Education --}}
    @if($cv->educations->isNotEmpty())
        <div class="cv-section">
            <div class="cv-section-title">Education</div>
            @foreach($cv->educations as $edu)
                <div class="cv-row">
                    <div class="cv-row-left">
                        <div class="cv-bold">{{ $edu->institusi }}</div>
                        @if($edu->gelar)
                            <div class="cv-sub">{{ $edu->gelar }}</div>
                        @endif
                    </div>
                    @if($edu->tahun)
                        <div class="cv-row-right">{{ $edu->tahun }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Experience --}}
    @if($cv->experiences->isNotEmpty())
        <div class="cv-section">
            <div class="cv-section-title">Experience</div>
            @foreach($cv->experiences as $exp)
                <div style="margin-bottom: 10px;">
                    <div class="cv-row">
                        <div class="cv-bold">{{ $exp->posisi }}</div>
                        @if($exp->periode)
                            <div class="cv-row-right">{{ $exp->periode }}</div>
                        @endif
                    </div>
                    @if($exp->perusahaan)
                        <div class="cv-italic">{{ $exp->perusahaan }}</div>
                    @endif
                    @if($exp->deskripsi)
                        <div class="cv-desc">{{ $exp->deskripsi }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Key Skills --}}
    @php
        $techSkills = $cv->skills->where('tipe', 'technical');
        $softSkills = $cv->skills->where('tipe', 'soft');
    @endphp
    @if($techSkills->isNotEmpty() || $softSkills->isNotEmpty())
        <div class="cv-section">
            <div class="cv-section-title">Key Skills</div>
            <div class="skills-grid">
                @if($techSkills->isNotEmpty())
                    <div>
                        <div class="skills-label">Technical Skills</div>
                        <ul class="skills-list">
                            @foreach($techSkills as $skill)
                                <li>{{ $skill->nama_skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($softSkills->isNotEmpty())
                    <div>
                        <div class="skills-label">Soft Skills</div>
                        <ul class="skills-list">
                            @foreach($softSkills as $skill)
                                <li>{{ $skill->nama_skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
</body>
</html>
