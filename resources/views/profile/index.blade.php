@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <div class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">

            <h1 class="text-3xl font-bold mb-6">Profil Saya</h1>

            <div class="grid lg:grid-cols-3 gap-8">

                <!-- FORM -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- DATA DIRI -->
                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="bg-white p-6 rounded-xl shadow">
                            <h2 class="text-xl font-semibold mb-4">Data Diri</h2>

                            <input type="text" name="first_name"
                                placeholder="Nama Depan"
                                value="{{ $profile->first_name ?? '' }}"
                                class="w-full border p-2 mb-3 rounded">

                            <input type="text" name="last_name"
                                placeholder="Nama Belakang"
                                value="{{ $profile->last_name ?? '' }}"
                                class="w-full border p-2 mb-3 rounded">

                            <input type="text" name="phone"
                                placeholder="Nomor Telepon"
                                value="{{ $profile->phone ?? '' }}"
                                class="w-full border p-2 mb-3 rounded">

                            <textarea name="bio"
                                placeholder="Bio"
                                class="w-full border p-2 rounded">{{ $profile->bio ?? '' }}</textarea>
                        </div>

                        <!-- SKILLS -->
                        <div class="bg-white p-6 rounded-xl shadow">
                            <h2 class="text-xl font-semibold mb-4">Skills</h2>

                            <div class="flex gap-2">
                                <input type="text" name="skill"
                                    placeholder="Tambah skill"
                                    class="flex-1 border p-2 rounded">

                                <button class="bg-blue-500 text-white px-4 rounded">
                                    Tambah
                                </button>
                            </div>

                            @if($profile && $profile->skills)
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($profile->skills as $skill)
                                        <span class="px-3 py-1 bg-blue-100 rounded">
                                            {{ $skill->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- FOTO -->
                        <div class="bg-white p-6 rounded-xl shadow">
                            <h2 class="text-xl font-semibold mb-4">Foto Profil</h2>

                            <input type="file" name="photo">
                        </div>

                        <button class="w-full bg-blue-600 text-white py-3 rounded mt-4">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- PREVIEW -->
                <div>
                    <div class="bg-white p-6 rounded-xl shadow sticky top-8">

                        <h2 class="text-xl font-semibold mb-4">Preview</h2>

                        <div class="text-center mb-4">
                            @if($profile && $profile->photo)
                                <img src="{{ asset('storage/'.$profile->photo) }}"
                                    class="w-24 h-24 rounded-full mx-auto">
                            @else
                                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto"></div>
                            @endif

                            <p class="mt-2 font-bold">
                                {{ $profile->first_name ?? 'Nama' }}
                            </p>
                        </div>

                        <div>
                            <p><strong>Bio:</strong> {{ $profile->bio ?? '-' }}</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection