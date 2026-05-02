@extends('layouts.admin')

@section('title', 'Hirify | Manajemen Pengguna')

@section('content')
<div class="space-y-8">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
        <h1 class="text-3xl font-semibold text-slate-950">Manajemen Pengguna</h1>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">Daftar seluruh pengguna yang terdaftar di platform Hirify.</p>
    </div>

    {{-- Summary badges --}}
    <div class="flex flex-wrap gap-3">
        <span class="inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
            Total: {{ $users->total() }} pengguna
        </span>
    </div>

    {{-- Users table --}}
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-xl font-semibold text-slate-950">Semua Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500">Daftar lengkap pengguna beserta peran dan tanggal pendaftaran.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200 bg-slate-50">
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $u)
                        @php
                            $roleColor = match($u->role) {
                                'mentor' => 'bg-purple-100 text-purple-700',
                                'admin'  => 'bg-slate-900 text-white',
                                default  => 'bg-cyan-100 text-cyan-700',
                            };
                            $initial = strtoupper(substr($u->name ?? 'U', 0, 1));
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-3 px-6 text-slate-500">{{ $users->firstItem() + $i }}</td>
                            <td class="py-3 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-2xl bg-[#0F172A] text-white grid place-items-center text-sm font-semibold flex-shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-slate-600">{{ $u->email }}</td>
                            <td class="py-3 px-6">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-slate-600">{{ $u->created_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm text-slate-500">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-5 border-t border-slate-200 flex items-center justify-between gap-4">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                </p>
                <div class="flex items-center gap-2">
                    @if ($users->onFirstPage())
                        <span class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-400 cursor-default">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">‹ Sebelumnya</a>
                    @endif

                    @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                        @if ($page == $users->currentPage())
                            <span class="rounded-xl bg-[#0F172A] px-3 py-2 text-xs font-semibold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Berikutnya ›</a>
                    @else
                        <span class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-400 cursor-default">Berikutnya ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
