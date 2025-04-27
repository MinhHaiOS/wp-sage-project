<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeagueModel extends Model
{
    public $incrementing = false;
    protected $table = 'leagues';
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'country_code', 'display_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->id = (string) Str::uuid());
    }

    public function teams()
    {
        return $this->hasMany(TeamModel::class, 'league_id');
    }

    public function matches()
    {
        return $this->hasMany(MatchModel::class, 'competition_id');
    }
}
