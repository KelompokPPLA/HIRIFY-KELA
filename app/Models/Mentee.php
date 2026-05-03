class Mentee extends Model
{
    protected $fillable = ['name', 'career_path'];

    public function roadmaps() {
        return $this->hasMany(Roadmap::class);
    }

    public function scores() {
        return $this->hasMany(Score::class);
    }

    public function histories() {
        return $this->hasMany(History::class);
    }

    public function getSuccessScoreAttribute() {
        return $this->scores()->avg('score') ?? 0;
    }
}
