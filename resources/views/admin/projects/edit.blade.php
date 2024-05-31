@php
function isSelected($oldValue, $currentValue) {
    return $oldValue == $currentValue ? 'selected' : '';
}
@endphp

@extends('layouts.admin')

@section('content')


<h1>

   edit form
</h1>

@if (session('error'))
    <div class="alert alert-danger">
        <ul>
             <li>{{ session('error') }}</li>
        </ul>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <form action="{{route('admin.projects.update', $project)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">nome Progetto</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="formGroupExampleInput"  name="name" value="{{old('name', $project->name)}}">
        </div>
        <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">argomento progetto</label>
            <input type="text" class="form-control @error('topic') is-invalid @enderror" id="formGroupExampleInput2" placeholder="Another input placeholder" name="topic" value="{{old('topic', $project->topic)}}">
        </div>
        <div class="mb-3">
            <label for="formGroupExampleInput3" class="form-label">difficoltà progetto</label>
            <input type="text" class="form-control @error('difficulty') is-invalid @enderror" id="formGroupExampleInput3" placeholder="Another input placeholder" name="difficulty" value="{{old('difficulty', $project->difficulty)}}">
        </div>

        {{-- qui metto le checkbox per le tecnologie  --}}

        <div class="btn-group mb-3" role="group" aria-label="Basic checkbox toggle button group">
            @foreach ( $technologies as $technology )

                    <input type="checkbox" value="{{ $technology->id }}" name="technologies[]"
                        @if ( $errors->any() && in_array($technology->id, old('technologies', [])) || !$errors->any() && $project->technologies->contains($technology)) checked @endif
                        class="btn-check" id="technology{{ $technology->id }}" autocomplete="off">
                    <label class="btn btn-outline-primary" for="technology{{$technology->id}}">{{ $technology->name }}</label>
            @endforeach
        </div><br>

        <label for="type_id" class="form-label">categoria</label>
        <select  name="type_id" class="form-select" id="type_id" aria-label="Default select example">
            <option value="">Seleziona una categoria</option>
            @foreach ($types as $type)
            <option value="{{ $type->id }}" @if (old('type_id', $project->type?->id)== $type->id) selected @endif>{{$type->name}}</option>

            @endforeach

        </select>

        <div class="mb-3">
            <label for="image" class="form-label">immagine</label>
            <input type="file" class="form-control" id="image" placeholder="Another input placeholder" name="image" onchange="showimage(event)">
        </div>
        <img class="thumb w-25" style="height: 350px" id="thumb" alt="" src="/img/placeholder.png">



        <div class="d-flex justify-content-end w100">


        </div>



        <div class="d-flex justify-content-end w-100 ">

            <button type="submit" class="btn btn-warning me-3">modifica</button>

        </div>


    </form>
    <form class="mt-3" action="{{route('admin.projects.destroy', $project)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger ">elimina</button>

    </form>

</div>

@endsection

<script>
function showimage(event){

    const thumb = document.getElementById('thumb');
    thumb.src = URL.createObjectURL(event.target.files[0]);
    // console.log(thumb);
}

</script>

