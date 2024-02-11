<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' =>  [
                    'en'=>'mobile',
                    'ar'=>'الموبايل'
                ],
                'image' => 'value2_row1',
                'column3' => 'value3_row1',
            ],
            [
                'column1' => 'value1_row2',
                'column2' => 'value2_row2',
                'column3' => 'value3_row2',
            ],
            // Add more rows as needed
        ];

        // Insert the data into the database
        DB::table('brands')->insert($data);
    }
}
