<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use App\functions\Helper;


class technologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
        'HTML5',
        'CSS3',
        'JavaScript',
        'React.js',
        'Angular',
        'Vue.js',
        'Node.js',
        'Express.js',
        'Django',
        'Laravel'
    ];

    foreach($technologies as $item){
        $newTechnology = new Technology();
        $newTechnology->name = $item;
        $newTechnology->slug = Helper::generateSlug($newTechnology->name, Technology::class);
        $newTechnology->save();
    }
    }
}
