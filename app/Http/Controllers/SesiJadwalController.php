<?php

namespace App\Http\Controllers;

use App\Models\SesiJadwal;
use Illuminate\Http\Request;

class SesiJadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'mentor') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $sessions = auth()->user()->sesiJadwal()->orderBy('date', 'desc')->paginate(12);
        return view('sesiJadwal.index', compact('sessions'));
    }

    public function create()
    {
        return view('sesiJadwal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|min:1',
            'platform' => 'nullable|string|max:255',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        $data['mentor_id'] = auth()->id();

        SesiJadwal::create($data);

        return redirect()->route('mentor.sesi-jadwal.index')->with('success', 'Sesi berhasil dibuat.');
    }

    public function show($id)
    {
        $session = SesiJadwal::findOrFail($id);
        if ($session->mentor_id !== auth()->id()) abort(403);
        return view('sesiJadwal.show', compact('session'));
    }

    public function edit($id)
    {
        $session = SesiJadwal::findOrFail($id);
        if ($session->mentor_id !== auth()->id()) abort(403);
        return view('sesiJadwal.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $session = SesiJadwal::findOrFail($id);
        if ($session->mentor_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|min:1',
            'platform' => 'nullable|string|max:255',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        $session->update($data);

        return redirect()->route('mentor.sesi-jadwal.show', $session->id)->with('success', 'Sesi diperbarui.');
    }

    public function destroy($id)
    {
        $session = SesiJadwal::findOrFail($id);
        if ($session->mentor_id !== auth()->id()) abort(403);
        $session->delete();
        return redirect()->route('mentor.sesi-jadwal.index')->with('success', 'Sesi dihapus.');
    }

    public function addNotes(Request $request, $id)
    {
        $session = SesiJadwal::findOrFail($id);
        if ($session->mentor_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'notes' => 'required|string',
        ]);

        if ($session->status !== 'Completed') {
            return back()->with('error', 'Catatan hanya dapat ditambahkan jika status Completed.');
        }

        $session->notes = $data['notes'];
        $session->save();

        return redirect()->route('mentor.sesi-jadwal.show', $session->id)->with('success', 'Catatan berhasil disimpan.');
    }
}
