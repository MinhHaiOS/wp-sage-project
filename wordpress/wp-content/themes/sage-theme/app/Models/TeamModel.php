<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamModel extends Model
{
    public $incrementing = false;
    protected $table = 'teams';
    protected $keyType = 'string';
    protected $fillable = ['id', 'league_id', 'name', 'logo_url'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->id = (string) Str::uuid());
    }

    public function league()
    {
        return $this->belongsTo(LeagueModel::class, 'league_id');
    }
}
