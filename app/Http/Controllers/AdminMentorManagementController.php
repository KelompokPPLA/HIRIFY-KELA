<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminMentorManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $mentors = Mentor::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('expertise', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.mentors.index', compact('mentors', 'search'));
    }

    public function create()
    {
        return view('admin.mentors.form', [
            'mentor' => new Mentor(),
            'mentorUser' => new User(['role' => 'mentor']),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'mentor',
            ]);

            Mentor::create($this->mentorPayload($data, $user->id));
        });

        return redirect('/admin/mentors')->with('success', 'Profil mentor berhasil ditambahkan.');
    }

    public function edit(Mentor $mentor)
    {
        return view('admin.mentors.form', [
            'mentor' => $mentor->load('user'),
            'mentorUser' => $mentor->user,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Mentor $mentor)
    {
        $data = $this->validatedData($request, $mentor);

        DB::transaction(function () use ($data, $mentor) {
            $mentor->load('user');
            $mentor->user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => 'mentor',
            ]);

            if (! empty($data['password'])) {
                $mentor->user->password = Hash::make($data['password']);
            }

            $mentor->user->save();
            $mentor->update($this->mentorPayload($data, $mentor->user_id));
        });

        return redirect('/admin/mentors')->with('success', 'Profil mentor berhasil diperbarui.');
    }

    public function destroy(Mentor $mentor)
    {
        $user = $mentor->user;

        DB::transaction(function () use ($mentor, $user) {
            $mentor->delete();
            $user?->delete();
        });

        return redirect('/admin/mentors')->with('success', 'Profil mentor berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Mentor $mentor = null): array
    {
        $userId = $mentor?->user_id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => [$mentor ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'expertise' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'education' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'availability' => ['nullable', 'string', 'max:255'],
            'price_per_session' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
            'phone_number' => ['nullable', 'string', 'max:30'],
        ]);
    }

    private function mentorPayload(array $data, string $userId): array
    {
        return [
            'user_id' => $userId,
            'phone_number' => $data['phone_number'] ?? null,
            'expertise' => $data['expertise'],
            'experience_years' => $data['experience_years'],
            'bio' => $data['bio'] ?? null,
            'education' => $data['education'] ?? null,
            'skills' => $this->skillsArray($data['skills'] ?? ''),
            'availability' => $data['availability'] ?? null,
            'price_per_session' => $data['price_per_session'] ?? null,
        ];
    }

    private function skillsArray(?string $skills): array
    {
        return collect(explode(',', (string) $skills))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->values()
            ->all();
    }
}
