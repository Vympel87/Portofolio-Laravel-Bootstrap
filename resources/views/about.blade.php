@extends('layouts.main')

@section('container')
    <h1> Halaman About </h1>
    <h3>{{ $name; }}</h3>
    <p>{{  $email; }}</p>
    <img src="img/{{  $image; }}" alt="{{ $name; }}" width="200px" class="img-thumbnail">

    <div class="mt-3">
        <a class="btn btn-outline-dark" href="/send-mail" role="button">Contact Me</a>
    </div>
@endsection
