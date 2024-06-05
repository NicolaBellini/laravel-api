<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

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
        $types = Type::with('projects')->get();


        foreach ($types as $type) {
            $typeProjects[] = [

                'projects' => $type->projects
            ];
        }

        return response()->json(compact('types'));
    }

    public function getProjectBySlug($slug)
    {
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();
        if ($project) {
            $succes = true;
            if ($project->image) {
                // $project->image = asset('storage/' . $project->image);
                $project->image = Storage::url($project->image);
            } else {
                $project->image = Storage::url('img/placeholder.png');
                $project->image_original_name = 'no image';
            }
        } else {
            $succes = false;
        }
        return response()->json($project);
    }

    public function getProjectByType($typeId)
    {
        $type = Type::with('projects')->find($typeId);

        if (!$type) {
            return response()->json(['success' => false, 'message' => 'Type not found'], 404);
        }

        $projects = $type->projects->map(function ($project) {
            if ($project->image) {
                // Modifica l'URL dell'immagine per includere il percorso di memorizzazione pubblico
                $project->image = Storage::url($project->image);
            } else {
                // Se l'immagine non è disponibile, usa un'immagine placeholder
                $project->image = Storage::url('img/placeholder.png');
                $project->image_original_name = 'no image';
            }
            return $project;
        });

        return response()->json(['success' => true, 'projects' => $projects]);
    }
}
