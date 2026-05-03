@extends('layouts.admin')

@section('title', $mode === 'create' ? 'Hirify | Tambah Pengguna' : 'Hirify | Edit Pengguna')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
            <h1 class="text-3xl font-semibold text-slate-950">{{ $mode === 'create' ? 'Tambah Pengguna' : 'Edit Pengguna' }}</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola identitas, email, password, dan role akun.</p>
        </div>
        <a href="/admin/users" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Kembali
        </a>
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

    <form method="POST" action="{{ $mode === 'create' ? '/admin/users' : '/admin/users/' . $userModel->id }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($mode === 'edit')
            @method('PATCH')
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Nama</span>
                <input type="text" name="name" value="{{ old('name', $userModel->name) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>

            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Email</span>
                <input type="email" name="email" value="{{ old('email', $userModel->email) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>

            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Role</span>
                <select name="role" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                    @foreach (['jobseeker' => 'Jobseeker', 'mentor' => 'Mentor', 'admin' => 'Admin'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $userModel->role ?: 'jobseeker') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                <p class="font-semibold text-slate-800">Catatan password</p>
                <p class="mt-1">{{ $mode === 'create' ? 'Password wajib diisi untuk akun baru.' : 'Kosongkan password jika tidak ingin mengubahnya.' }}</p>
            </div>

            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Password</span>
                <input type="password" name="password" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>

            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Konfirmasi Password</span>
                <input type="password" name="password_confirmation" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </label>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <a href="/admin/users" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                {{ $mode === 'create' ? 'Simpan Pengguna' : 'Simpan Perubahan' }}
            </button>
        </div>
    </form>
</div>
@endsection
