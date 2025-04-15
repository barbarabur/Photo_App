@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    @php
        $name = auth()->user()->name; // Obtener el name del $user
    @endphp  
    {{$name}} stats

</div>
  <div class="card-body">
    <h5 class="card-title">Profile Likes</h5>
    <p class="card-text">Likes al usuario</p>
    
  </div>
  <div class="card-body">
    <h5 class="card-title">Photo Likes</h5>
    <p class="card-text">Fotos con likes</p>
    
    
  </div>
  
</div>

@endsection