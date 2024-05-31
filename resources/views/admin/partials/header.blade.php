
<nav class="navbar bg-body-tertiary my_nav">
  <div class="container-fluid">
    <div class="d-flex">
        <a class="navbar-brand" >BOOLPRESS</a>
        <a class="navbar-brand"  href="{{route('admin.home')}}">Home</a>
        <a class="navbar-brand"  href="{{route('home')}}">visita il sito</a>
        <p class="mt-2">{{Auth::user()->name}}</p>
        <form action="{{route('logout')}}" class="ms-2" method="POST">
                    @csrf
                    @method('POST')
                    {{-- @method('DELETE') --}}
                    <button type="submit" class="btn btn-warning ">esci</button>
        </form>

    </div>

    <form class="d-flex" role="search" action="{{route('admin.projects.index')}}" method="get">
      <input class="form-control me-2" name="toSearch" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav>
