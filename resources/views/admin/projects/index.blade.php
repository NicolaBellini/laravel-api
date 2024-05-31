@extends('layouts.admin')

@section('content')

@if (isset($_GET['toSearch']))

<div class="alert alert-dark" role="alert">
  La ricerca per "{{$_GET['toSearch']}}" ha prodotto {{$projectCount}} risultati
</div>

@endif

<a href="{{route('admin.projects.create')}}" class="btn btn-success ">crea nuovo progetto</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col"><a href="{{route('admin.orderBy', ['direction'=> $direction, 'column'=>'id'])}}">titolo</a></th>
      <th scope="col">argomento</th>
      <th scope="col">difficolta</th>
      <th scope="col">tipo</th>
      <th scope="col">tecnologia</th>
      <th scope="col">Pre View</th>


      <th scope="col">azioni</th>


    </tr>
  </thead>
  <tbody>
@foreach ($projectsList as $project)
    <tr>
        <th scope="row">{{$project->name}}</th>
        <td>{{$project->topic}}</td>
        <td>{{$project->difficulty}}</td>
        <td>
            @if ($project->type)

                <a href="{{ route('admin.projects_by_type', $project->type) }}">{{$project->type->name}}</a>
            @endif
        </td>

        {{-- qui stampo le tecnologie --}}
        <td>
            @forelse ($project->technologies as $technology )
                <span class="badge text-bg-secondary">{{ $technology->name }}</span>
            @empty

            @endforelse
        </td>


        <td><img src="{{asset('storage/'. $project->image)}}" style="height: 100px" onerror="this.src='/img/placeholder.png'" alt=""></td>
        <td class="d-flex align-item-center" >
            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-warning h-25">modifica</a>
            <a href="{{route('admin.projects.show', $project)}}" class="btn btn-primary h-25">vedi</a>



            <form action="{{route('admin.projects.destroy', $project)}}" method="post" style="height: 100px">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger ">elimina</button>

            </form>
        </td>


    </tr>

@endforeach

  </tbody>
</table>


@endsection
