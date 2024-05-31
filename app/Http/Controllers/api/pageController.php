<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class pageController extends Controller
{
    // rotte api
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(10);

        return response()->json($projects);
    }
}
