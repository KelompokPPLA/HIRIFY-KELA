@extends('layouts.mentor')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Selamat Datang, Mentor!</h2>
            <p class="text-gray-600">Ringkasan aktivitas dan pengelolaan jadwal.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold text-gray-700">Total Sesi</h3>
                <div class="text-3xl font-bold">{{ $sessions->count() }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold text-gray-700">Pending Booking</h3>
                <div class="text-3xl font-bold">{{ $pendingBookings->count() }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold text-gray-700">Accepted</h3>
                <div class="text-3xl font-bold">{{ $acceptedBookings->count() }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <section id="jadwal" class="bg-white p-6 rounded shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Sesi Mentor</h3>
                    <a href="{{ route('mentor.sesi-jadwal.create') }}" class="text-sm px-3 py-1 bg-sky-600 text-white rounded">Buat Sesi</a>
                </div>

                <div class="space-y-3">
                    @forelse($sessions as $session)
                        <div class="flex items-center justify-between p-3 border rounded hover:bg-gray-50 transition">
                            <div>
                                <div class="font-medium text-gray-900">{{ $session->topic }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ date('d M Y', strtotime($session->date)) }} • {{ date('H:i', strtotime($session->time)) }} WIB • {{ $session->duration }} menit
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-1 rounded-full {{ $session->status === 'Confirmed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $session->status }}
                                </span>
                                <a href="{{ route('mentor.sesi-jadwal.show', $session->id) }}" class="text-sm text-sky-600 font-medium">Detail</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 italic">Belum ada sesi yang dibuat.</div>
                    @endforelse
                </div>
            </section>

            <section id="booking" class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Permintaan Booking</h3>

                <div class="space-y-4">
                    @forelse($pendingBookings as $booking)
                        <div class="border rounded p-3 flex items-start justify-between">
                            <div>
                                <div class="font-medium">{{ $booking->jobseeker->name ?? 'Mentee' }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->booking_notes }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ optional($booking->scheduled_start)->format('d M Y H:i') }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('mentor.bookings.accept', $booking->id) }}" method="post">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded">Terima</button>
                                </form>

                                <button onclick="document.getElementById('reject-{{ $booking->id }}').classList.toggle('hidden')" class="px-3 py-1 bg-red-100 text-red-700 rounded">Tolak</button>

                                <form id="reject-{{ $booking->id }}" action="{{ route('mentor.bookings.reject', $booking->id) }}" method="post" class="hidden">
                                    @csrf
                                    <div class="mt-2">
                                        <input name="rejection_reason" placeholder="Alasan penolakan (opsional)" class="border p-2 rounded w-full">
                                        <div class="mt-2 text-right">
                                            <button class="px-3 py-1 bg-red-600 text-white rounded">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500">Tidak ada permintaan booking.</div>
                    @endforelse
                </div>

                <hr class="my-4">

                <h4 class="font-semibold mb-3">Booking Diterima</h4>
                <div class="space-y-3">
                    @forelse($acceptedBookings as $b)
                        <div class="p-3 border rounded">
                            <div class="font-medium">{{ $b->jobseeker->name ?? 'Mentee' }}</div>
                            <div class="text-sm text-gray-600">{{ optional($b->scheduled_start)->format('d M Y H:i') }} - {{ optional($b->scheduled_end)->format('H:i') }}</div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada sesi yang diterima.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
