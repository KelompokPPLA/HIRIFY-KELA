@extends('layouts.admin')

@section('title', 'Hirify | Modul Pelatihan')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
            <h1 class="text-3xl font-semibold text-slate-950">Modul Konten Pelatihan</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">Kelola kursus, kategori, level, dan materi pembelajaran.</p>
        </div>
        <a href="/admin/training-modules/create" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Tambah Modul</a>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5">
            <form method="GET" action="/admin/training-modules" class="grid gap-3 lg:grid-cols-[1fr_auto]">
                <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul, kategori, atau instruktur..." class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3">Modul</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Level</th>
                        <th class="px-6 py-3">Materi</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                            <td class="px-6 py-3">
                                <p class="font-semibold text-slate-900">{{ $course->title }}</p>
                                <p class="line-clamp-1 text-xs text-slate-500">{{ $course->instructor_name }} - {{ $course->estimated_hours }} jam</p>
                            </td>
                            <td class="px-6 py-3 text-slate-700">{{ $course->category }}</td>
                            <td class="px-6 py-3">
                                <span class="rounded-full bg-cyan-100 px-2.5 py-1 text-xs font-semibold text-cyan-700">{{ $course->level_label }}</span>
                            </td>
                            <td class="px-6 py-3 text-slate-600">{{ $course->lessons_count }} materi</td>
                            <td class="px-6 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="/admin/training-modules/{{ $course->id }}/edit" class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-white">Edit</a>
                                    <form method="POST" action="/admin/training-modules/{{ $course->id }}" onsubmit="return confirm('Hapus modul ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada modul pelatihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($courses->hasPages())
            <div class="border-t border-slate-200 p-5">{{ $courses->links() }}</div>
        @endif
    </div>
</div>
@endsection
