@extends('layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('description', 'description main page')

@section('content')
    <div class="container">
        <main class="py-4">
            <div class="body">
                Content Text
                <product-list></product-list>
            </div>
        </main>
    </div>
@endsection
