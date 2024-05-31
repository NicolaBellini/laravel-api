<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <title>Boolpress | Admin</title>
</head>
<body>

    <header>
        @include('admin.partials.header')
    </header>

    <main class="d-flex">

        <div class="aside">
           <ul>
            <li><a href="{{route('admin.projects.index')}}">i miei progetti</a></li>

            <li><a href="{{route('admin.technology.index')}}">modifica le tecnologie</a></li>

             <li><a href="{{route('admin.type.index')}}">modifica i tipi</a></li>

             <li><a href="{{route('admin.projectsType')}}">Progetti e tipo</a></li>


           </ul>
        </div>


        <div class="p-4 w-100 my_dashboard ">
            @yield('content')
        </div>
    </main>


</body>
</html>
