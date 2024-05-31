<?php

namespace App\Http\Controllers\admin;

use App\functions\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Validation\Rules\Exists;
use App\Http\Requests\projectRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;
class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(isset($_GET['toSearch'])){
            $projectsList = Project::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($_GET['toSearch']) . '%'])->get();
            $projectCount=Project::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($_GET['toSearch']) . '%'])->count();
        }else{
            $projectCount=Project::all();
            $projectsList= Project::all();
        }

        $direction='desc';


        return view('admin.projects.index', compact('projectsList', 'projectCount','direction'));
    }


    public function orderBy($direction, $column){
        $direction= $direction ==='desc'?'asc':'desc';

        $projectsList = Project::orderBy($column, $direction)->get();

        return view('admin.projects.index', compact('projectsList', 'direction'));
    }


    // funzione per avere tutti i ptogetti di un tipo

    // public function getTypeProjects(Type $type){
    //     $projectsList= $type->Projects();

    //     return view('admin.projects.index', compact('projectsList', 'type'));
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types= Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(projectRequest $request)
    {

        // dd($request->all());
        $formData = $request->all();
        // verifico se l'immagine esiste
        if(array_key_exists('image', $formData)){
            // salvo l' immagine nello storage nella cartella upload e ottengo il percorso
            $imagePath = Storage::put('uploads', $formData['image']);
            $originalName = $request->file('image')->getClientOriginalName();
            $formData['image_original_name'] = $originalName;
            $formData['image']= $imagePath;
        }

        // dd($formData);
        $exist= Project::where('name', $request->name)->first();
        if($exist){
            return redirect()->route('admin.projects.index')->with('error','esiste gia un progetto con lo stesso nome');
        }else{
            $formData['slug'] = Helper::generateSlug($formData['name'], Project::class);

            $newProject= new Project();
            $newProject->fill($formData);

            $newProject->save();
            if(array_key_exists('technologies', $formData)){
                $newProject->technologies()->attach($formData['technologies']);
            }
            // dd($newProject);
            return redirect()->route('admin.projects.index')->with('success','progetto aggiunto con successo');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        $types= Type::all();
        return view('admin.projects.edit', compact('project','types','technologies'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(projectRequest $request, Project $project)
    {
        $formData = $request->all();
        // dd($request->all());
        if(array_key_exists('image', $formData)){
            // salvo l' immagine nello storage nella cartella upload e ottengo il percorso
            $imagePath = Storage::put('uploads', $formData['image']);
            $originalName = $request->file('image')->getClientOriginalName();
            $formData['image_original_name'] = $originalName;
            $formData['image']= $imagePath;

        }

        if ($formData['name']!==$project->name) {
            $formData['slug'] = Helper::generateSlug($formData['name'], Project::class);
        }else{
            $formData['slug']= $project['slug'];
        }

        // return redirect()->route('admin.projects.edit',$project)->with('error', 'Esiste già un progetto con questo nome');

        // dd($formData);
        // $exist = Project::where('name', $request->name)->first();

        $project->update($formData);

        if(array_key_exists('technologies', $formData)){
            $project->technologies()->sync($formData['technologies']);
        }else{
            // se non sono presenti tecnologie perchè le ho tolte le elimino dalle relazioni
            $project->technologies()->detach();
        }
        // dd($project);
        return redirect()->route('admin.projects.show', $project);
    }
        // dump($project);


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // elimino anche la foreign
        $project->technologies()->detach();
        $project->delete();
        return redirect()->route('admin.projects.index')->with('deleted',"Il progetto $project->name è stato eliminato con successo");
    }
}
