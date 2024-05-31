<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\functions\Helper;
use App\Models\Type;


class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
       $data=[
         [
                'name' => 'Project A',
                'topic' => 'Artificial Intelligence',
                'difficulty' => 3,

            ],
            [
                'name' => 'Project B',
                'topic' => 'Web Development',
                'difficulty' => 2,

            ],
            [
                'name' => 'Project C',
                'topic' => 'Data Science',
                'difficulty' => 4,

            ],

        ];

        foreach($data as $item){
            $project= new Project();
            $project->type_id = Type::inRandomOrder()->first()->id;
            $project->name= $item['name'];
            $project->topic= $item['topic'];
            $project->difficulty= $item['difficulty'];
            $project->slug= Helper::generateSlug($project->name, new Project());
            $project->save();
        }
    }
}
