<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">BOOLPRESS | guest</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('admin.home')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('home')}}" target="_blank">visita il sito</a>
        </li>
        <li class="nav-item ">

        </li>
        <li>
            <form action="{{route('logout')}}" method="POST">
                @csrf
                @method('POST')
                {{-- @method('DELETE') --}}
                <button type="submit" class="btn btn-warning ">esci</button>
            </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
