<?php

namespace App\Http\Controllers;

use App\Models\SkillCourse;
use App\Models\SkillLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminTrainingModuleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $courses = SkillCourse::withCount('lessons')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('instructor_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.training-modules.index', compact('courses', 'search'));
    }

    public function create()
    {
        return view('admin.training-modules.form', [
            'course' => new SkillCourse(['level' => 'beginner', 'is_free' => true]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data) {
            $course = SkillCourse::create($this->coursePayload($data));
            $this->syncLessons($course, $data);
        });

        return redirect('/admin/training-modules')->with('success', 'Modul pelatihan berhasil ditambahkan.');
    }

    public function edit(SkillCourse $trainingModule)
    {
        return view('admin.training-modules.form', [
            'course' => $trainingModule->load('lessons'),
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, SkillCourse $trainingModule)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data, $trainingModule) {
            $trainingModule->update($this->coursePayload($data));
            $this->syncLessons($trainingModule, $data);
        });

        return redirect('/admin/training-modules')->with('success', 'Modul pelatihan berhasil diperbarui.');
    }

    public function destroy(SkillCourse $trainingModule)
    {
        $trainingModule->delete();

        return redirect('/admin/training-modules')->with('success', 'Modul pelatihan berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'thumbnail_emoji' => ['nullable', 'string', 'max:10'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'estimated_hours' => ['required', 'integer', 'min:1', 'max:500'],
            'is_free' => ['nullable', 'boolean'],
            'lesson_title' => ['nullable', 'array'],
            'lesson_title.*' => ['nullable', 'string', 'max:255'],
            'lesson_duration_minutes' => ['nullable', 'array'],
            'lesson_duration_minutes.*' => ['nullable', 'integer', 'min:1', 'max:600'],
            'lesson_content' => ['nullable', 'array'],
            'lesson_content.*' => ['nullable', 'string'],
        ]);
    }

    private function coursePayload(array $data): array
    {
        return [
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'level' => $data['level'],
            'thumbnail_emoji' => $data['thumbnail_emoji'] ?: 'MD',
            'instructor_name' => $data['instructor_name'],
            'estimated_hours' => $data['estimated_hours'],
            'is_free' => (bool) ($data['is_free'] ?? false),
        ];
    }

    private function syncLessons(SkillCourse $course, array $data): void
    {
        $titles = $data['lesson_title'] ?? [];
        $durations = $data['lesson_duration_minutes'] ?? [];
        $contents = $data['lesson_content'] ?? [];

        $course->lessons()->delete();

        foreach ($titles as $index => $title) {
            $title = trim((string) $title);
            $content = trim((string) ($contents[$index] ?? ''));

            if ($title === '' && $content === '') {
                continue;
            }

            SkillLesson::create([
                'skill_course_id' => $course->id,
                'title' => $title !== '' ? $title : 'Materi ' . ($index + 1),
                'content' => $content !== '' ? $content : '-',
                'duration_minutes' => (int) ($durations[$index] ?? 10),
                'order_number' => $index + 1,
            ]);
        }
    }
}
