use App\Models\Mentee;

class MentorController extends Controller
{
    public function dashboard()
    {
        $mentees = Mentee::with(['roadmaps', 'scores', 'histories'])->get();

        return view('mentor.dashboard', compact('mentees'));
    }

    public function recommend($id)
    {
        $mentee = Mentee::findOrFail($id);

        $recommendation = $mentee->success_score < 70
            ? "Perlu fokus latihan dan ulang materi"
            : "Siap lanjut ke level berikutnya";

        return response()->json([
            'mentee' => $mentee->name,
            'recommendation' => $recommendation
        ]);
    }
}
