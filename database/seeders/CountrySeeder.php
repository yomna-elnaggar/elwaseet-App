<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $names =[
        json_encode([
            'en'=>' Egypt',
            'ar'=>' مصر',
        ]),
        json_encode([
            'en'=>'Saudi Arabia ',
            'ar'=>'السعودية ',
        ])
    
        ];
        
        foreach($names as $name){
            Country::create(['name'=> $name]);
        
        }
    }
}
