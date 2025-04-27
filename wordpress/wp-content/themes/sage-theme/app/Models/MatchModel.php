<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MatchModel extends Model
{
    const STATUS_NOT_STARTED = 1;
    const STATUS_FIRST_HALF = 2;
    const STATUS_HALF_TIME = 3;
    const STATUS_SECOND_HALF = 4;
    const STATUS_OVERTIME = 5;
    const STATUS_OVERTIME_DEPRECATED = 6;

    // Status constants…
    const STATUS_PENALTY_SHOOTOUT = 7;
    const STATUS_END = 8;
    const STATUS_DELAY = 9;
    public $incrementing = false;
    protected $table = 'matches';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'competition_id',
        'home_team_id',
        'away_team_id',
        'status_id',
        'match_start_time',
        'match_time',
        'home_scores',
        'away_scores',
    ];
    protected $casts = [
        'status_id'        => 'integer',
        'match_start_time' => 'integer',
        'match_time'       => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->id = (string) Str::uuid());
    }

    public function competition()
    {
        return $this->belongsTo(LeagueModel::class, 'competition_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(TeamModel::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(TeamModel::class, 'away_team_id');
    }
}
