<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class pageController extends Controller
{
    // rotte api
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(10);

        return response()->json($projects);
    }

    public function technologies()
    {
        $technologies = Technology::all();
        return response()->json($technologies);
    }
    public function types()
    {
        $types = Type::all();
        return response()->json($types);
    }
    public function getProjectBySlug($slug)
    {
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();
        if ($project) {
            $succes = true;
            if ($project->image) {
                $project->image = asset('storage/' . $project->image);
            } else {
                $project->image = asset('img/placeholder.png');
                $project->image_original_name = 'no image';
            }
        } else {
            $succes = false;
        }
        return response()->json($project);
    }
}
