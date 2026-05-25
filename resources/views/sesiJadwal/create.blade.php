@extends('layouts.mentor')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Sesi Baru</h1>
            <p class="text-slate-500 mt-1.5 font-medium">Tambahkan jadwal sesi mentoring baru untuk mentee Anda</p>
        </div>
        <a href="{{ route('mentor.sesi-jadwal.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-extrabold uppercase tracking-wider text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition duration-200 self-start sm:self-center">
            ← Kembali ke Jadwal
        </a>
    </header>

    <!-- Main Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        @if($errors->any())
            <div class="mb-8 p-5 bg-rose-50 text-rose-700 border border-rose-100/80 rounded-2xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="font-extrabold text-sm uppercase tracking-wide">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-xs font-bold text-rose-600/90">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mentor.sesi-jadwal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Topic -->
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Topik Sesi</label>
                    <input type="text" name="topic" value="{{ old('topic') }}" required 
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50" 
                        placeholder="Misal: CV Review & Interview Preparation">
                </div>

                <!-- Date & Time Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date') }}" required 
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Waktu (WIB)</label>
                        <input type="time" name="time" value="{{ old('time') }}" required 
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                </div>

                <!-- Duration & Platform Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Durasi (Menit)</label>
                        <input type="number" name="duration" value="{{ old('duration', 60) }}" required 
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Platform / Tautan</label>
                        <input type="text" name="platform" value="{{ old('platform') }}" 
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50" 
                            placeholder="Misal: Google Meet link atau Zoom">
                    </div>
                </div>

                <!-- Status & Material Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Status Sesi</label>
                        <div class="relative">
                            <select name="status" 
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-100/50 appearance-none">
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">File Materi (PDF/Video)</label>
                        <input type="file" name="material_file" accept=".pdf,video/*" 
                            class="w-full text-xs font-extrabold text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-extrabold file:uppercase file:tracking-wide file:bg-cyan-50 file:text-[#00bee4] hover:file:bg-cyan-100/80 file:transition file:duration-200 border border-slate-200 rounded-2xl py-1.5 px-3 bg-white shadow-sm shadow-slate-100/50 focus:ring-4 focus:ring-cyan-500/10 focus:border-[#00bee4] outline-none transition duration-200">
                        <p class="mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-wider">PDF atau Video (Maks. 50MB)</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                <a href="{{ route('mentor.sesi-jadwal.index') }}" 
                    class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-extrabold uppercase tracking-wider transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                    class="px-8 py-3 rounded-full bg-[#00bee4] hover:bg-[#00a3c4] text-white text-xs font-extrabold uppercase tracking-wider shadow-lg shadow-cyan-500/15 transition duration-200 hover:scale-[1.02] active:scale-[0.98]">
                    Simpan Sesi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
