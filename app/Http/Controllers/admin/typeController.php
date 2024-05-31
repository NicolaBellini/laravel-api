<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\functions\Helper;

use function PHPSTORM_META\type;

class typeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $typeList= Type::all();
        return view('admin.type.index', compact('typeList'));
    }


    // rotta custom per avere i progetti e i type
    public function projectsType(Type $type){
        $types = Type::all();

        return view('admin.projectsType', compact('types'));
    }



    public function getTypeProjects(Type $type){


        $projectsList = $type->Projects;
        $projectCount=count($projectsList);
        $direction='desc';
        // dd($projectsList);


        return view('admin.projects.index', compact('projectsList', 'projectCount', 'direction','type'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exist= Type::where('name', $request->name)->first();
        if($exist){
            return redirect()->route('admin.type.index')->with('error','esiste gia una tecnologia con lo stesso nome');
        }else{
            $formData = $request->all();
            $newType= new type();
            $newType->name = $formData['name'];
            $newType->slug = Helper::generateSlug($newType->name, type::class);
            // dd($newProject);
            $newType->save();

            return redirect()->route('admin.type.index')->with('success','Tecnologia aggiunta con successo');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
             $validData = $request->validate([
        'name' => 'required|min:2|max:30',
        ], [
            'name.required' => 'Il nome deve essere inserito',
            'name.min' => 'Il nome deve avere almeno :min caratteri',
            'name.max' => 'Il nome deve avere massimo :max caratteri',
        ]);


        $exist = Type::where('name', $request->name)->first();
        if ($exist) {
            return redirect()->route('admin.type.index')->with('error', 'Esiste già una tecnologia con questo nome');
        }

        $type->name= $validData['name'];
        $type->slug = Helper::generateSlug($validData['name'], type::class);
        $type->save();

        return redirect()->route('admin.type.index')->with('success', 'La tecnologia è stata aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route('admin.type.index')->with('deleted',"la tecnologia $type->name è stata eliminata con successo");
    }
}
