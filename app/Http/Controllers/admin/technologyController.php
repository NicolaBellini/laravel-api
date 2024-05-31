<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\functions\Helper;

class technologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $technoList= Technology::all();
        return view('admin.techno.index', compact('technoList'));
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
        $exist= Technology::where('name', $request->name)->first();
        if($exist){
            return redirect()->route('admin.technology.index')->with('error','esiste gia una tecnologia con lo stesso nome');
        }else{
            $formData = $request->all();
            $newTechno= new Technology();
            $newTechno->name = $formData['name'];
            $newTechno->slug = Helper::generateSlug($newTechno->name, Technology::class);
            // dd($newProject);
            $newTechno->save();

            return redirect()->route('admin.technology.index')->with('success','Tecnologia aggiunta con successo');
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
      public function update(Request $request, Technology $technology)
    {

        // dd($technology);
       $validData = $request->validate([
        'name' => 'required|min:2|max:30',
        ], [
            'name.required' => 'Il nome deve essere inserito',
            'name.min' => 'Il nome deve avere almeno :min caratteri',
            'name.max' => 'Il nome deve avere massimo :max caratteri',
        ]);


        $exist = Technology::where('name', $request->name)->first();
        if ($exist) {
            return redirect()->route('admin.technology.index')->with('error', 'Esiste già una tecnologia con questo nome');
        }

        $technology->name= $validData['name'];
        $technology->slug = Helper::generateSlug($validData['name'], Technology::class);
        $technology->save();

        return redirect()->route('admin.technology.index')->with('success', 'La tecnologia è stata aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technology.index')->with('deleted',"la tecnologia $technology->name è stata eliminata con successo");
    }
}
