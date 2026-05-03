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

        <form action="{{ route('mentor.sesi-jadwal.update', $session->id) }}" method="POST">
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

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded-lg border border-gray-200 px-3 py-2.5 focus:ring-sky-200 focus:border-sky-500 transition">
                        <option value="Pending" {{ old('status', $session->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status', $session->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ old('status', $session->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status', $session->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
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
