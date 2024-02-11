<?php

namespace Database\Seeders;

use App\Models\SuperCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $names =[
        json_encode([
            'en'=>'Purchasing department',
            'ar'=>'قسم الشراء',
        ]),
        json_encode([
            'en'=>'Services Department',
            'ar'=>'قسم الخدمات',
        ])
    
        ];
        
        foreach($names as $name){
            SuperCategory::create(['name'=> $name]);
        
        }
    }
}
