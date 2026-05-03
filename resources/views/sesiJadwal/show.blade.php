@extends('layouts.mentor')

@section('content')
<div class="max-w-4xl mx-auto">
    <header class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Detail Sesi</h1>
            <p class="text-gray-500 mt-1">Rincian dan catatan sesi mentoring</p>
        </div>
        <a href="{{ route('mentor.sesi-jadwal.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">← Kembali</a>
    </header>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-100">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-gray-100">
            <div class="flex justify-between items-start gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $session->topic }}</h2>
                    <div class="mt-2 text-gray-500 flex items-center gap-3">
                        <span class="flex items-center gap-1.5"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>{{ date('d M Y', strtotime($session->date)) }}</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>{{ date('H:i', strtotime($session->time)) }} WIB</span>
                        <span>•</span>
                        <span>Durasi: {{ $session->duration }} menit</span>
                    </div>
                    <div class="mt-3 text-gray-700">
                        <span class="font-medium">Platform:</span> 
                        @if($session->platform)
                            <a href="{{ $session->platform }}" target="_blank" class="text-sky-600 hover:underline">{{ $session->platform }}</a>
                        @else
                            <span class="text-gray-400 italic">Belum ditentukan</span>
                        @endif
                    </div>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'Pending' => 'bg-amber-100 text-amber-700',
                            'Confirmed' => 'bg-emerald-100 text-emerald-700',
                            'Completed' => 'bg-blue-100 text-blue-700',
                            'Cancelled' => 'bg-slate-100 text-slate-700'
                        ];
                        $color = $statusColors[$session->status] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-sm font-semibold {{ $color }}">{{ $session->status }}</span>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('mentor.sesi-jadwal.edit', $session->id) }}" class="px-5 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium transition">Edit Sesi</a>
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Catatan Hasil Sesi</h3>
            
            @if($session->notes)
                <div class="p-5 bg-white rounded-lg border border-gray-200 text-gray-700 shadow-sm leading-relaxed whitespace-pre-wrap">{{ $session->notes }}</div>
            @else
                <div class="text-gray-500 italic mb-4">Belum ada catatan.</div>
            @endif

            @if($session->status === 'Completed' && !$session->notes)
                <div class="mt-4 bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <form action="{{ route('mentor.sesi-jadwal.notes', $session->id) }}" method="POST">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tambahkan Catatan</label>
                        <textarea name="notes" rows="4" class="block w-full rounded-lg border border-gray-200 px-4 py-3 focus:ring-sky-200 focus:border-sky-500 transition" placeholder="Tuliskan hasil sesi, kesimpulan, area yang perlu ditingkatkan, atau rekomendasi..."></textarea>
                        <div class="mt-4 flex justify-end">
                            <button class="px-5 py-2 rounded-lg bg-slate-900 text-white font-medium hover:bg-slate-800 transition">Simpan Catatan</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
