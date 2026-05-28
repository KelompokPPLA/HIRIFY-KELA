@extends('layouts.app')

@section('title', 'Manajemen Portofolio')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">Manajemen Portofolio</h1>
            <p class="text-slate-500 text-sm mt-1">Unggah, kelola, dan tunjukkan hasil proyek serta sertifikat profesional Anda kepada perekrut.</p>
        </div>
        <div>
            <a href="{{ route('portofolio.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-navy text-white hover:bg-slate-800 font-semibold rounded-xl shadow-sm transition-all hover:shadow-md transform active:scale-95">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Portofolio
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-navy text-xl font-bold">
                💼
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Portofolio</p>
                <p class="text-2xl font-extrabold text-navy-900 mt-0.5">{{ $portofolios->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl font-bold">
                🚀
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Proyek Mandiri</p>
                <p class="text-2xl font-extrabold text-navy-900 mt-0.5">{{ $portofolios->where('type', 'project')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl font-bold">
                📜
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sertifikat</p>
                <p class="text-2xl font-extrabold text-navy-900 mt-0.5">{{ $portofolios->where('type', 'certificate')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Tabs Filter -->
        <div class="flex items-center bg-slate-100 p-1.5 rounded-xl self-start">
            <a href="{{ route('portofolio.index', array_merge(request()->query(), ['type' => ''])) }}" 
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ !$type ? 'bg-white text-navy shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                Semua
            </a>
            <a href="{{ route('portofolio.index', array_merge(request()->query(), ['type' => 'project'])) }}" 
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $type === 'project' ? 'bg-white text-navy shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                Proyek
            </a>
            <a href="{{ route('portofolio.index', array_merge(request()->query(), ['type' => 'certificate'])) }}" 
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $type === 'certificate' ? 'bg-white text-navy shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                Sertifikat
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('portofolio.index') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-md w-full ml-auto">
            @if($type)
                <input type="hidden" name="type" value="{{ $type }}">
            @endif
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan judul atau keahlian..." 
                       class="block w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent transition-all">
            </div>
            @if($search)
                <a href="{{ route('portofolio.index', ['type' => $type]) }}" class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-navy border border-slate-200 rounded-xl transition-all">
                    Reset
                </a>
            @endif
            <button type="submit" class="px-4 py-2 bg-slate-950 text-white font-semibold text-xs rounded-xl shadow-sm hover:bg-slate-800 transition-all">
                Cari
            </button>
        </form>
    </div>

    <!-- Feedback Message -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-xl shadow-sm" id="success-alert">
            <span class="text-xl">✨</span>
            <div class="text-sm font-semibold flex-1">{{ session('success') }}</div>
            <button onclick="document.getElementById('success-alert').remove()" class="text-emerald-500 hover:text-emerald-800">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif

    <!-- Portfolio Grid -->
    @if($portofolios->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-slate-50 text-4xl rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-inner">
                📂
            </div>
            <h3 class="text-lg font-bold text-navy-900">Belum Ada Portofolio</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto mt-2 leading-relaxed">
                Tunjukkan kemampuan terbaik Anda! Unggah hasil proyek orisinal atau sertifikat kelulusan kursus Anda di sini.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('portofolio.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-navy text-white hover:bg-slate-800 font-semibold rounded-xl text-sm transition-all shadow-sm">
                    Mulai Unggah
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portofolios as $portfolio)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-all group duration-300 relative">
                    
                    <!-- File Preview Section -->
                    <div class="aspect-video w-full bg-slate-50 border-b border-slate-100 flex items-center justify-center overflow-hidden relative group">
                        @if($portfolio->file_path && in_array(pathinfo($portfolio->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                            <img src="{{ asset('storage/' . $portfolio->file_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($portfolio->file_path && pathinfo($portfolio->file_name, PATHINFO_EXTENSION) === 'pdf')
                            <div class="flex flex-col items-center justify-center p-6 text-center">
                                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl font-bold mb-2 shadow-sm border border-red-100">
                                    PDF
                                </div>
                                <p class="text-xs font-semibold text-slate-700 max-w-[180px] truncate" title="{{ $portfolio->file_name }}">
                                    {{ $portfolio->file_name }}
                                </p>
                                <span class="text-[10px] text-slate-400 mt-0.5">Dokumen PDF ({{ $portfolio->file_size }})</span>
                            </div>
                        @else
                            <!-- Placeholder based on type -->
                            <div class="flex flex-col items-center justify-center p-6 text-center text-slate-400">
                                <span class="text-3xl mb-2">
                                    {{ $portfolio->type === 'project' ? '💻' : '📜' }}
                                </span>
                                <span class="text-xs font-semibold text-slate-500">
                                    {{ $portfolio->type === 'project' ? 'Portofolio Proyek' : 'Sertifikat Prestasi' }}
                                </span>
                            </div>
                        @endif

                        <!-- Type Badge -->
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-extrabold tracking-wider uppercase shadow-sm border {{ $portfolio->type === 'project' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-purple-50 text-purple-600 border-purple-100' }}">
                            {{ $portfolio->type === 'project' ? 'Proyek' : 'Sertifikat' }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <!-- Title & Date -->
                            <div>
                                <h3 class="font-bold text-slate-800 text-[15px] group-hover:text-navy transition-colors line-clamp-1" title="{{ $portfolio->title }}">
                                    {{ $portfolio->title }}
                                </h3>
                                <p class="text-[11px] text-slate-400 font-semibold mt-0.5 flex items-center gap-1.5">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    @if($portfolio->start_date)
                                        {{ $portfolio->start_date->translatedFormat('M Y') }}
                                    @endif
                                    @if($portfolio->is_ongoing)
                                        - <span class="text-emerald-600 font-bold">Sekarang</span>
                                    @elseif($portfolio->end_date)
                                        - {{ $portfolio->end_date->translatedFormat('M Y') }}
                                    @endif
                                </p>
                            </div>

                            <!-- Description -->
                            @if($portfolio->description)
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                    {{ $portfolio->description }}
                                </p>
                            @endif

                            <!-- Skills Tag list -->
                            @if($portfolio->skills)
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    @foreach(array_filter(array_map('trim', explode(',', $portfolio->skills))) as $skill)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-semibold border border-slate-200">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer actions -->
                        <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-4">
                            <!-- Link or download file -->
                            <div class="flex gap-2">
                                @if($portfolio->link)
                                    <a href="{{ $portfolio->link }}" target="_blank" rel="noopener noreferrer" class="p-2 text-slate-500 hover:text-navy hover:bg-slate-50 rounded-lg transition-colors border border-slate-200" title="Kunjungi Link">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                        </svg>
                                    </a>
                                @endif
                                
                                @if($portfolio->file_path)
                                    <a href="{{ asset('storage/' . $portfolio->file_path) }}" download class="p-2 text-slate-500 hover:text-navy hover:bg-slate-50 rounded-lg transition-colors border border-slate-200" title="Unduh File">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            <!-- Edit & Delete -->
                            <div class="flex items-center gap-1">
                                <a href="{{ route('portofolio.edit', $portfolio->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-navy hover:bg-slate-50 border border-slate-200 rounded-lg transition-all">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('portofolio.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Hapus Portofolio">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
