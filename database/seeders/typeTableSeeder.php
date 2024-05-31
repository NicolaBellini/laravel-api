<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use App\functions\Helper;


class typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            'front-end','back-end'
        ];

        foreach($data as $item){
            $newType = new Type();
            $newType->name = $item;
            $newType->slug = Helper::generateSlug($newType->name, Type::class);
            $newType->save();
        }
    }
}
