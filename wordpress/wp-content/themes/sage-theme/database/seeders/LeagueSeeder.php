<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeagueModel;

class LeagueSeeder extends Seeder
{
    public function run()
    {
        $leagues = [
            ['name'=>'Giải bóng đá nữ Algeria',          'country_code'=>'DZ','display_order'=>1],
            ['name'=>'Liga U21 Youth Algeria',            'country_code'=>'DZ','display_order'=>2],
            ['name'=>'Siêu cúp Ấn Độ - Bảng đấu A',        'country_code'=>'IN','display_order'=>3],
            ['name'=>'Giải ngoại hạng Bangladesh - Vòng 4','country_code'=>'BD','display_order'=>4],
        ];

        foreach ($leagues as $data) {
            LeagueModel::create($data);
        }
    }
}
