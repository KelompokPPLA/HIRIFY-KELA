@extends('layouts.admin')

@section('title', 'Hirify | Manajemen Pengguna')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
            <h1 class="text-3xl font-semibold text-slate-950">Manajemen Pengguna</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">Kelola akun jobseeker, mentor, dan admin agar data akses platform tetap rapi.</p>
        </div>
        <a href="/admin/users/create" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
            Tambah Pengguna
        </a>
    </div>

    @foreach (['success' => 'emerald', 'error' => 'red'] as $key => $color)
        @if (session($key))
            <div class="rounded-2xl border border-{{ $color }}-200 bg-{{ $color }}-50 px-4 py-3 text-sm font-semibold text-{{ $color }}-700">
                {{ session($key) }}
            </div>
        @endif
    @endforeach

    <div class="grid gap-3 sm:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Total', 'value' => $users->total(), 'class' => 'bg-slate-900 text-white'],
                ['label' => 'Jobseeker', 'value' => (int) ($roleCounts['jobseeker'] ?? 0), 'class' => 'bg-cyan-50 text-cyan-700 border border-cyan-100'],
                ['label' => 'Mentor', 'value' => (int) ($roleCounts['mentor'] ?? 0), 'class' => 'bg-violet-50 text-violet-700 border border-violet-100'],
                ['label' => 'Admin', 'value' => (int) ($roleCounts['admin'] ?? 0), 'class' => 'bg-slate-100 text-slate-700 border border-slate-200'],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="rounded-2xl p-4 {{ $card['class'] }}">
                <p class="text-xs font-bold uppercase tracking-[0.18em] opacity-70">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold">{{ number_format($card['value']) }}</p>
            </div>
        @endforeach
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5">
            <form method="GET" action="/admin/users" class="grid gap-3 lg:grid-cols-[1fr_180px_auto]">
                <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                <select name="role" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                    <option value="">Semua role</option>
                    @foreach (['jobseeker' => 'Jobseeker', 'mentor' => 'Mentor', 'admin' => 'Admin'] as $value => $label)
                        <option value="{{ $value }}" @selected(($role ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        @php
                            $roleColor = match($u->role) {
                                'mentor' => 'bg-violet-100 text-violet-700',
                                'admin' => 'bg-slate-900 text-white',
                                default => 'bg-cyan-100 text-cyan-700',
                            };
                            $initial = strtoupper(substr($u->name ?? 'U', 0, 1));
                        @endphp
                        <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-9 w-9 flex-shrink-0 place-items-center rounded-2xl bg-slate-900 text-sm font-semibold text-white">{{ $initial }}</div>
                                    <span class="font-semibold text-slate-900">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-slate-600">{{ $u->email }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleColor }}">{{ ucfirst($u->role) }}</span>
                            </td>
                            <td class="px-6 py-3 text-slate-600">{{ $u->created_at?->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="/admin/users/{{ $u->id }}/edit" class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-white">Edit</a>
                                    <form method="POST" action="/admin/users/{{ $u->id }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-slate-200 p-5">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
