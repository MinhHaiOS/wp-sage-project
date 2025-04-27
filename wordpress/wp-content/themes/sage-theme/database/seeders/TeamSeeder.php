<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeagueModel;
use App\Models\TeamModel;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $map = [
            'Giải bóng đá nữ Algeria' => [
                'CLB nữ Akbou',
                'Afak Relizane (w)',
                'CLB nữ JF Khroub',
                'ASE Alger Centre (w)',
                'CR Belouizdad (W)',
                'ASE Bejaia (W)',
            ],
            'Liga U21 Youth Algeria' => [
                'Saoura U21',
                'Kabylie U21',
            ],
            'Siêu cúp Ấn Độ - Bảng đấu A' => [
                'Hyderabad',
                'Sreenidi Deccan',
            ],
            'Giải ngoại hạng Bangladesh - Vòng 4' => [
                'Fortis Limited',
                'Rahmatgonj MFS',
                'Sheikh Jamal',
                'Bashundhara Kings',
            ],
        ];

        foreach ($map as $leagueName => $teams) {
            $league = LeagueModel::where('name',$leagueName)->firstOrFail();
            foreach ($teams as $teamName) {
                TeamModel::create([
                    'league_id'=> $league->id,
                    'name'     => $teamName,
                    'logo_url' => null,
                ]);
            }
        }
    }
}
