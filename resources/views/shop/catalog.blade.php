@extends('layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

    <div class="container my-4">
        <h1 class="title_h1">
            Каталог
        </h1>
    </div>

    <div class="container">
        <div class="row align-content-stretch py-4">
            <div class="col-md-3">
                <catalog-filter-list></catalog-filter-list>
            </div>
            <div class="col-md-9">
                <div class="catalog-list-property">
                    Сортировка
                </div>
                <catalog-product-list></catalog-product-list>
            </div>
        </div>
    </div>
@endsection
