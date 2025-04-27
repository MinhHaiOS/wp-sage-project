<?php

namespace App\Repositories;

use App\Models\MatchModel;

class MatchRepository
{
    public function getAll()
    {
        return MatchModel::with(['homeTeam', 'awayTeam', 'competition'])
                         ->orderBy('competition_id')
                         ->orderBy('match_time')
                         ->get();
    }
}
