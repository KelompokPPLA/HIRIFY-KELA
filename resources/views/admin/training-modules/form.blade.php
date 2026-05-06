@extends('layouts.admin')

@section('title', $mode === 'create' ? 'Hirify | Tambah Modul' : 'Hirify | Edit Modul')

@section('content')
<div class="max-w-6xl space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Admin Panel</p>
            <h1 class="text-3xl font-semibold text-slate-950">{{ $mode === 'create' ? 'Tambah Modul Pelatihan' : 'Edit Modul Pelatihan' }}</h1>
            <p class="mt-2 text-sm text-slate-600">Isi informasi kursus dan daftar materi yang akan dipelajari jobseeker.</p>
        </div>
        <a href="/admin/training-modules" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali</a>
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

    @php
        $oldTitles = old('lesson_title');
        $lessonRows = $oldTitles !== null
            ? collect($oldTitles)->map(fn ($title, $i) => [
                'title' => $title,
                'duration_minutes' => old("lesson_duration_minutes.{$i}", 10),
                'content' => old("lesson_content.{$i}", ''),
            ])
            : ($mode === 'edit'
                ? $course->lessons->map(fn ($lesson) => [
                    'title' => $lesson->title,
                    'duration_minutes' => $lesson->duration_minutes,
                    'content' => $lesson->content,
                ])
                : collect([['title' => '', 'duration_minutes' => 10, 'content' => '']]));
    @endphp

    <form method="POST" action="{{ $mode === 'create' ? '/admin/training-modules' : '/admin/training-modules/' . $course->id }}" class="space-y-6">
        @csrf
        @if ($mode === 'edit')
            @method('PATCH')
        @endif

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 lg:grid-cols-2">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Judul Modul</span>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Kategori</span>
                    <input type="text" name="category" value="{{ old('category', $course->category) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Level</span>
                    <select name="level" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                        @foreach (['beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Lanjutan'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('level', $course->level ?: 'beginner') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Instruktur</span>
                    <input type="text" name="instructor_name" value="{{ old('instructor_name', $course->instructor_name) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Kode Ikon Pendek</span>
                    <input type="text" name="thumbnail_emoji" maxlength="10" value="{{ old('thumbnail_emoji', $course->thumbnail_emoji ?: 'MD') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Estimasi Jam</span>
                    <input type="number" name="estimated_hours" min="1" value="{{ old('estimated_hours', $course->estimated_hours ?: 1) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                </label>
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <input type="hidden" name="is_free" value="0">
                    <input type="checkbox" name="is_free" value="1" @checked(old('is_free', $course->is_free ?? true)) class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                    <span class="text-sm font-semibold text-slate-700">Gratis</span>
                </label>
                <label class="space-y-2 lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-700">Deskripsi</span>
                    <textarea name="description" rows="4" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">{{ old('description', $course->description) }}</textarea>
                </label>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-semibold text-slate-950">Materi Pembelajaran</h2>
                    <p class="text-sm text-slate-500">Baris kosong akan dilewati saat disimpan.</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($lessonRows as $index => $lesson)
                    <div class="grid gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 lg:grid-cols-[1fr_150px]">
                        <label class="space-y-2">
                            <span class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Judul Materi {{ $index + 1 }}</span>
                            <input type="text" name="lesson_title[]" value="{{ $lesson['title'] }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                        </label>
                        <label class="space-y-2">
                            <span class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Durasi</span>
                            <input type="number" name="lesson_duration_minutes[]" min="1" value="{{ $lesson['duration_minutes'] }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                        </label>
                        <label class="space-y-2 lg:col-span-2">
                            <span class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Konten</span>
                            <textarea name="lesson_content[]" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">{{ $lesson['content'] }}</textarea>
                        </label>
                    </div>
                @endforeach

                @for ($i = $lessonRows->count(); $i < max($lessonRows->count() + 2, 3); $i++)
                    <div class="grid gap-3 rounded-2xl border border-dashed border-slate-300 p-4 lg:grid-cols-[1fr_150px]">
                        <input type="text" name="lesson_title[]" placeholder="Judul materi tambahan" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                        <input type="number" name="lesson_duration_minutes[]" min="1" value="10" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
                        <textarea name="lesson_content[]" rows="3" placeholder="Konten materi tambahan" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 lg:col-span-2"></textarea>
                    </div>
                @endfor
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="/admin/training-modules" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-white">Batal</a>
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">{{ $mode === 'create' ? 'Simpan Modul' : 'Simpan Perubahan' }}</button>
        </div>
    </form>
</div>
@endsection
