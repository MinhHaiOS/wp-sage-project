<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MatchModel;
use App\Models\LeagueModel;
use App\Models\TeamModel;
use Carbon\Carbon;

class MatchSeeder extends Seeder
{
    public function run()
    {
        $matches = [
            [
                'competition'   => 'Giải bóng đá nữ Algeria',
                'home'          => 'CLB nữ Akbou',
                'away'          => 'Afak Relizane (w)',
                'status'        => MatchModel::STATUS_SECOND_HALF,
                'start'         => '2025-04-27 16:00:00',
                'elapsed'       => 56,
                'home_scores'   => '1,1,0,0,-1,0,0',
                'away_scores'   => '0,0,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Giải bóng đá nữ Algeria',
                'home'          => 'CLB nữ JF Khroub',
                'away'          => 'ASE Alger Centre (w)',
                'status'        => MatchModel::STATUS_HALF_TIME,
                'start'         => '2025-04-27 16:10:00',
                'elapsed'       => 45,
                'home_scores'   => '2,2,0,0,-1,0,0',
                'away_scores'   => '0,0,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Giải bóng đá nữ Algeria',
                'home'          => 'CR Belouizdad (W)',
                'away'          => 'ASE Bejaia (W)',
                'status'        => MatchModel::STATUS_HALF_TIME,
                'start'         => '2025-04-27 16:20:00',
                'elapsed'       => 45,
                'home_scores'   => '1,1,0,0,-1,0,0',
                'away_scores'   => '2,2,0,0,-1,0,0',
            ],

            [
                'competition'   => 'Liga U21 Youth Algeria',
                'home'          => 'Saoura U21',
                'away'          => 'Kabylie U21',
                'status'        => MatchModel::STATUS_SECOND_HALF,
                'start'         => '2025-04-27 16:00:00',
                'elapsed'       => 59,
                'home_scores'   => '0,0,0,0,-1,0,0',
                'away_scores'   => '4,2,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Giải ngoại hạng Bangladesh - Vòng 4',
                'home'          => 'Fortis Limited',
                'away'          => 'Rahmatgonj MFS',
                'status'        => MatchModel::STATUS_SECOND_HALF,
                'start'         => '2025-04-27 15:45:00',
                'elapsed'       => 73,
                'home_scores'   => '1,1,0,0,-1,0,0',
                'away_scores'   => '2,1,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Giải ngoại hạng Bangladesh - Vòng 4',
                'home'          => 'Sheikh Jamal',
                'away'          => 'Bashundhara Kings',
                'status'        => MatchModel::STATUS_SECOND_HALF,
                'start'         => '2025-04-27 15:45:00',
                'elapsed'       => 74,
                'home_scores'   => '0,0,0,0,-1,0,0',
                'away_scores'   => '0,0,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Siêu cúp Ấn Độ - Bảng đấu A',
                'home'          => 'Hyderabad',
                'away'          => 'Sreenidi Deccan',
                'status'        => MatchModel::STATUS_END,
                'start'         => '2025-04-27 15:30:00',
                'elapsed'       => 90,
                'home_scores'   => '1,0,0,0,-1,0,0',
                'away_scores'   => '4,4,0,0,-1,0,0',
            ],
            [
                'competition'   => 'Giải ngoại hạng Bangladesh - Vòng 4',
                'home'          => 'Hyderabad',
                'away'          => 'Sreenidi Deccan',
                'status'        => MatchModel::STATUS_NOT_STARTED,
                'start'         => '2025-04-30 15:45:00',
                'elapsed'       => 0,
                'home_scores'   => '0,0,0,0,-1,0,0',
                'away_scores'   => '0,0,0,0,-1,0,0',
            ],
        ];

        foreach ($matches as $row) {
            $league = LeagueModel::where('name', $row['competition'])->firstOrFail();
            $home   = TeamModel::where('name', $row['home'])->firstOrFail();
            $away   = TeamModel::where('name', $row['away'])->firstOrFail();

            MatchModel::create([
                'competition_id'   => $league->id,
                'home_team_id'     => $home->id,
                'away_team_id'     => $away->id,
                'status_id'        => $row['status'],
                'match_start_time' => Carbon::parse($row['start'])->timestamp,
                'match_time'       => $row['elapsed'],
                'home_scores'      => $row['home_scores'],
                'away_scores'      => $row['away_scores'],
            ]);
        }
    }
}
