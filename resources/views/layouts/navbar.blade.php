<ul class="nav">
  @if (auth()->check())
    @php
        $user = auth()->user(); // Obtener el usuario autenticado
    @endphp

    <!-- Menú para Client -->
    @if ($user->role === 'Client')
    
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('clients.mainClient') }}">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('clients.likes') }}">FAVORITES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('clients.chart') }}">CHART</a>
      </li>
    @endif

    <!-- Menú para Photographer -->
    @if ($user->role ==='Photographer')
      
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('photos.mainPhoto') }}">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('layouts.stats') }}">STATS</a>
    @endif
 
    @endif
</ul>

<div class="d-flex flex-column align-items-end ml-auto">
  @if (auth()->check())
    <span class="badge bg-light text-dark mb-2">{{$user->role}}</span>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-light mb-3">Log Out</button>
    </form>
  @endif
</div>

        
