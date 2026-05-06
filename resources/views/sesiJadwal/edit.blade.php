@extends('layouts.mentor')

@section('content')
<div class="max-w-4xl mx-auto">
    <header class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Edit Sesi</h1>
            <p class="text-gray-500 mt-1">Perbarui rincian sesi mentoring</p>
        </div>
        <a href="{{ route('mentor.sesi-jadwal.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">← Kembali</a>
    </header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mentor.sesi-jadwal.update', $session->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Topik Sesi</label>
                    <input type="text" name="topic" value="{{ old('topic', $session->topic) }}" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date', $session->date) }}" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Waktu (WIB)</label>
                        <input type="time" name="time" value="{{ old('time', $session->time) }}" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Durasi (Menit)</label>
                        <input type="number" name="duration" value="{{ old('duration', $session->duration) }}" required class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Platform / Tautan</label>
                        <input type="text" name="platform" value="{{ old('platform', $session->platform) }}" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                            <option value="Pending" {{ old('status', $session->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ old('status', $session->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Completed" {{ old('status', $session->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $session->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Update File Materi (PDF/Video)</label>
                        <input type="file" name="material_file" accept=".pdf,video/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition border border-gray-200 rounded-lg py-1.5 px-3">
                        @if($session->material_file)
                            <div class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span class="font-medium">File saat ini:</span>
                                <a href="{{ Storage::url($session->material_file) }}" target="_blank" class="text-sky-600 hover:underline">Lihat Materi</a>
                            </div>
                        @else
                            <p class="mt-1 text-xs text-gray-400">PDF atau Video (Maks. 50MB)</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('mentor.sesi-jadwal.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-medium hover:bg-slate-800 transition shadow-sm">Perbarui Sesi</button>
            </div>
        </form>
    </div>
</div>
@endsection
