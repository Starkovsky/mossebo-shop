@extends('layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')
    {{ $product }}
@endsection