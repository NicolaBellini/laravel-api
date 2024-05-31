@extends('layouts.admin')

@section('content')

<h1>index type</h1>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    @foreach ($errors->all() as $error)
        <li>
            {{$error}}
        </li>
    @endforeach
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" role="alert">
 {{session('error')}}
</div>

@endif

@if(session('success'))
 <div class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif

@if(session('deleted'))
 <div class="alert alert-success" role="alert">
    {{session('deleted')}}
</div>

@endif

<div class="container-fluid d-flex ">
<form action="{{route('admin.type.store')}}" method="post">
    @csrf
    <label for="name">Nome tipo</label>
    <input type="text" id="name" name="name" class="me-3">

    <button class="btn btn-succes" type="submit">crea</button>

</form>
</div>

<table class="table edit-table">
    <thead>
        <tr>
            <th scope="col">titolo</th>
            <th scope="col">azioni</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($typeList as $type)
        <tr>
            <form action="{{route('admin.type.update', $type)}}" id="form-edit-{{$type->id}}" method="post">
                @csrf
                @method('PUT')

                <td class="w-25">
                    <input type="text" value="{{$type->name}}" name="name">
                </td>

            </form>


            <td class="d-flex">
            <button onclick="submitForm({{$type->id}})">modifica</button>

            <form action="{{route('admin.type.destroy', $type)}}" method="post" id="form-edit-{{$type->id}}">
                @csrf
                @method('DELETE')
                <button onclick="submitForm({{$type->id}})" class="btn btn-danger">Elimina</button>
            </form>

            </td>

        </tr>
    @endforeach

  </tbody>
</table>


{{-- script --}}
<script>
function submitForm(id) {
    const form = document.getElementById(`form-edit-${id}`);
    form.submit();
    // console.log(form);
}

</script>


@endsection
