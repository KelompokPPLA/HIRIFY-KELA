@props(['session'])
@php
    $statusColors = [
        'Pending' => 'bg-amber-100 text-amber-700',
        'Confirmed' => 'bg-emerald-100 text-emerald-700',
        'Completed' => 'bg-blue-100 text-blue-700',
        'Cancelled' => 'bg-slate-100 text-slate-700'
    ];
    $color = $statusColors[$session->status] ?? 'bg-slate-100 text-slate-700';
@endphp

<div class="rounded-xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col h-full">
    <div class="flex justify-between items-start mb-3 gap-2">
        <h3 class="font-bold text-slate-800 text-lg leading-tight">{{ $session->topic }}</h3>
        <span class="px-2.5 py-1 text-xs font-semibold rounded-full shrink-0 {{ $color }}">
            {{ $session->status }}
        </span>
    </div>
    
    <div class="space-y-2 mb-4 flex-1">
        <div class="flex items-center text-sm text-slate-500 gap-2">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            {{ date('d M Y', strtotime($session->date)) }}
        </div>
        <div class="flex items-center text-sm text-slate-500 gap-2">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            {{ date('H:i', strtotime($session->time)) }} WIB ({{ $session->duration }} menit)
        </div>
        <div class="flex items-center text-sm text-slate-500 gap-2">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4z"></path><rect x="3" y="6" width="12" height="12" rx="2" ry="2"></rect></svg>
            {{ $session->platform ?: 'Belum ditentukan' }}
        </div>
    </div>
    
    <div class="pt-4 border-t border-slate-100 flex gap-2 mt-auto">
        <a href="{{ route('mentor.sesi-jadwal.show', $session->id) }}" class="flex-1 text-center py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 transition">Detail Sesi</a>
    </div>
</div>
