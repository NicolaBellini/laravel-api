@extends('layouts.admin')

@section('content')


<h1>Projects type</h1>


<table class="table">
  <thead>
    <tr>
      <th scope="col">tipo</th>
      <th scope="col">progetti</th>

    </tr>
  </thead>
  <tbody>
    @foreach ($types as $type)
        <tr>
            <td>{{ $type->name }}</td>
            <td>
                <ul>
                    @foreach ($type->projects as $project)
                        <li><a href="{{route('admin.projects.show', $project)}}">{{ $project->name }}</a></li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach

  </tbody>
</table>

@endsection
