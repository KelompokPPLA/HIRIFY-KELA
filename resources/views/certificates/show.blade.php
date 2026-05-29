@extends('layouts.app')

@section('title', 'Sertifikat - ' . $certificate->course_title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('certificates.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-cyan-600 mb-6 transition">
        ← Kembali ke daftar sertifikat
    </a>

    {{-- Preview Sertifikat --}}
    <div class="bg-gradient-to-br from-slate-900 to-slate-700 rounded-3xl p-8 mb-6 text-center text-white shadow-xl">
        <div class="text-3xl font-black text-cyan-400 mb-1">Hirify<span class="text-white">.</span></div>
        <p class="text-xs tracking-widest text-slate-300 uppercase mb-6">Platform Pengembangan Karier</p>

        <div class="w-16 h-16 bg-cyan-500/20 border-2 border-cyan-400 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>

        <p class="text-slate-300 text-sm uppercase tracking-widest mb-2">Certificate of Completion</p>
        <h2 class="text-2xl font-black mb-1">{{ $certificate->user_name }}</h2>
        <p class="text-slate-300 text-sm mb-4">telah berhasil menyelesaikan</p>
        <h3 class="text-xl font-bold text-cyan-400 mb-6">{{ $certificate->course_title }}</h3>

        <div class="flex justify-center gap-8 text-sm">
            @if($certificate->instructor_name)
            <div>
                <p class="text-slate-400 text-xs uppercase tracking-wide">Instruktur</p>
                <p class="font-semibold">{{ $certificate->instructor_name }}</p>
            </div>
            @endif
            <div>
                <p class="text-slate-400 text-xs uppercase tracking-wide">Tanggal</p>
                <p class="font-semibold">{{ $certificate->issued_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Info & Actions --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Nomor Sertifikat</p>
                <p class="font-mono font-bold text-gray-800 text-sm">{{ $certificate->certificate_number }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Kode Verifikasi</p>
                <p class="font-mono font-bold text-cyan-600 text-sm tracking-widest">{{ $certificate->verification_code }}</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('certificates.download', $certificate->id) }}"
               class="flex-1 text-center bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 rounded-xl transition">
                ↓ Unduh Sertifikat PDF
            </a>
            <a href="{{ route('certificates.verify', ['code' => $certificate->verification_code]) }}"
               target="_blank"
               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
                Verifikasi Keaslian
            </a>
        </div>
    </div>
</div>
@endsection
