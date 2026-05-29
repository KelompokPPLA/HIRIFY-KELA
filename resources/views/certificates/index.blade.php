@extends('layouts.app')

@section('title', 'Sertifikat Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Sertifikat Saya</h1>
            <p class="text-gray-500 mt-1">Koleksi sertifikat pelatihan yang telah Anda selesaikan di Hirify.</p>
        </div>
        @if($totalCertificates > 0)
        <div class="bg-cyan-50 border border-cyan-200 rounded-2xl px-5 py-3 text-center flex-shrink-0">
            <p class="text-2xl font-black text-cyan-600">{{ $totalCertificates }}</p>
            <p class="text-xs text-cyan-500 font-semibold">Sertifikat Diraih</p>
        </div>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($certificates->isEmpty())
        <div class="text-center py-24 bg-white rounded-2xl border border-gray-200">
            <div class="text-6xl mb-4">🎓</div>
            <p class="text-xl font-bold text-gray-700">Belum ada sertifikat</p>
            <p class="text-gray-400 text-sm mt-2">Selesaikan pelatihan untuk mendapatkan sertifikat digital.</p>
            <a href="{{ route('pelatihan.index') }}" class="inline-block mt-6 bg-cyan-500 hover:bg-cyan-600 text-white font-bold px-6 py-3 rounded-xl transition">
                Mulai Pelatihan →
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($certificates as $cert)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-400">{{ $cert->issued_at->format('d M Y') }}</span>
                    </div>

                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $cert->course_title }}</h3>
                    @if($cert->instructor_name)
                        <p class="text-sm text-gray-500 mb-3">Instruktur: {{ $cert->instructor_name }}</p>
                    @endif

                    <div class="bg-gray-50 rounded-xl px-3 py-2 mb-4">
                        <p class="text-xs text-gray-400">Kode Verifikasi</p>
                        <p class="font-mono font-bold text-cyan-600 text-sm tracking-widest">{{ $cert->verification_code }}</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('certificates.download', $cert->id) }}"
                           class="flex-1 text-center bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold py-2 rounded-xl transition">
                            ↓ Unduh PDF
                        </a>
                        <a href="{{ route('certificates.verify', ['code' => $cert->verification_code]) }}"
                           target="_blank"
                           class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2 rounded-xl transition">
                            Verifikasi
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
