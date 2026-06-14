<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the portfolio items.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $query = Portofolio::where('user_id', Auth::id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('skills', 'like', '%' . $search . '%');
            });
        }

        if ($type && in_array($type, ['project', 'certificate'])) {
            $query->where('type', $type);
        }

        $portofolios = $query->orderBy('created_at', 'desc')->get();

        return view('jobseeker.portofolio.index', compact('portofolios', 'search', 'type'));
    }

    /**
     * Show the form for creating a new portfolio item.
     */
    public function create()
    {
        return view('jobseeker.portofolio.create');
    }

    /**
     * Store a newly created portfolio item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:150',
            'type' => 'required|in:project,certificate',
            'description' => 'required|string|min:30|max:2000',
            'link' => 'nullable|url|max:255',
            'skills' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'start_date' => 'required|date',
            'end_date' => 'nullable|required_without:is_ongoing|date|after_or_equal:start_date',
            'is_ongoing' => 'nullable',
        ]);

        $data = $request->only([
            'title', 'type', 'description', 'link', 'skills', 'start_date', 'end_date'
        ]);
        $data['user_id'] = Auth::id();
        $data['is_ongoing'] = $request->has('is_ongoing') ? true : false;

        // Reset end date if ongoing
        if ($data['is_ongoing']) {
            $data['end_date'] = null;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('portfolios', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            
            $sizeInBytes = $file->getSize();
            if ($sizeInBytes >= 1048576) {
                $data['file_size'] = round($sizeInBytes / 1048576, 2) . ' MB';
            } else {
                $data['file_size'] = round($sizeInBytes / 1024, 2) . ' KB';
            }
        }

        Portofolio::create($data);

        return redirect()
            ->route('portofolio.index')
            ->with('success', 'Portofolio baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified portfolio item.
     */
    public function edit(string $id)
    {
        $portofolio = Portofolio::where('user_id', Auth::id())->findOrFail($id);

        return view('jobseeker.portofolio.create', compact('portofolio'));
    }

    /**
     * Update the specified portfolio item in storage.
     */
    public function update(Request $request, string $id)
    {
        $portofolio = Portofolio::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:150',
            'type' => 'required|in:project,certificate',
            'description' => 'required|string|min:30|max:2000',
            'link' => 'nullable|url|max:255',
            'skills' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'start_date' => 'required|date',
            'end_date' => 'nullable|required_without:is_ongoing|date|after_or_equal:start_date',
            'is_ongoing' => 'nullable',
        ]);

        $data = $request->only([
            'title', 'type', 'description', 'link', 'skills', 'start_date', 'end_date'
        ]);
        $data['is_ongoing'] = $request->has('is_ongoing') ? true : false;

        // Reset end date if ongoing
        if ($data['is_ongoing']) {
            $data['end_date'] = null;
        }

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($portofolio->file_path) {
                Storage::disk('public')->delete($portofolio->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('portfolios', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            
            $sizeInBytes = $file->getSize();
            if ($sizeInBytes >= 1048576) {
                $data['file_size'] = round($sizeInBytes / 1048576, 2) . ' MB';
            } else {
                $data['file_size'] = round($sizeInBytes / 1024, 2) . ' KB';
            }
        }

        $portofolio->update($data);

        return redirect()
            ->route('portofolio.index')
            ->with('success', 'Portofolio berhasil diperbarui!');
    }

    /**
     * Remove the specified portfolio item from storage.
     */
    public function destroy(string $id)
    {
        $portofolio = Portofolio::where('user_id', Auth::id())->findOrFail($id);

        if ($portofolio->file_path) {
            Storage::disk('public')->delete($portofolio->file_path);
        }

        $portofolio->delete();

        return redirect()
            ->route('portofolio.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}
