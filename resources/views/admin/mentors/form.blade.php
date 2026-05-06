@extends('layouts.admin')

@section('title', $mode === 'create' ? 'Hirify | Tambah Mentor' : 'Hirify | Edit Mentor')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
            <h1 class="text-3xl font-semibold text-slate-950">{{ $mode === 'create' ? 'Tambah Mentor' : 'Edit Mentor' }}</h1>
            <p class="mt-2 text-sm text-slate-600">Akun mentor dan profil profesional dikelola dari satu form.</p>
        </div>
        <a href="/admin/mentors" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Periksa kembali input berikut:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $mode === 'create' ? '/admin/mentors' : '/admin/mentors/' . $mentor->id }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($mode === 'edit')
            @method('PATCH')
        @endif

        <div class="grid gap-5 lg:grid-cols-2">
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Nama Mentor</span>
                <input type="text" name="name" value="{{ old('name', $mentorUser->name) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Email</span>
                <input type="email" name="email" value="{{ old('email', $mentorUser->email) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Password</span>
                <input type="password" name="password" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Konfirmasi Password</span>
                <input type="password" name="password_confirmation" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Keahlian Utama</span>
                <input type="text" name="expertise" value="{{ old('expertise', $mentor->expertise) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Pengalaman (tahun)</span>
                <input type="number" name="experience_years" min="0" value="{{ old('experience_years', $mentor->experience_years) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Pendidikan</span>
                <input type="text" name="education" value="{{ old('education', $mentor->education) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Nomor Telepon</span>
                <input type="text" name="phone_number" value="{{ old('phone_number', $mentor->phone_number) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Skills (pisahkan koma)</span>
                <input type="text" name="skills" value="{{ old('skills', implode(',', $mentor->skills ?? [])) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Ketersediaan</span>
                <input type="text" name="availability" value="{{ old('availability', $mentor->availability) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Tarif per Sesi</span>
                <input type="number" name="price_per_session" min="0" value="{{ old('price_per_session', $mentor->price_per_session) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
            <label class="space-y-2 lg:col-span-2">
                <span class="text-sm font-semibold text-slate-700">Bio</span>
                <textarea name="bio" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">{{ old('bio', $mentor->bio) }}</textarea>
            </label>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="/admin/mentors" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">{{ $mode === 'create' ? 'Simpan Mentor' : 'Simpan Perubahan' }}</button>
        </div>
    </form>
</div>
@endsection
