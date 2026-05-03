<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        return MentorResource::collection(Mentor::paginate(15));
    }

    public function store(StoreMentorRequest $request)
    {
        $mentor = Mentor::create($request->validated());
        return new MentorResource($mentor);
    }

    public function show(Mentor $mentor)
    {
        return new MentorResource($mentor);
    }

    public function update(UpdateMentorRequest $request, Mentor $mentor)
    {
        $mentor->update($request->validated());
        return new MentorResource($mentor);
    }

    public function destroy(Mentor $mentor)
    {
        $mentor->delete();
        return response()->noContent();
    }
}
