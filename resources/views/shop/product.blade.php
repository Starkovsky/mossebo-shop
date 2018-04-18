@extends('layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')

    <div class="container my-3">
        <h1 class="title_h1">
            {{ $product->i18n->title }}
        </h1>
    </div>

    <div class="container my-2 block-ui">
        <div class="product-page">
            <div class="row">
                <div class="col-md-6 py-4 px-4">
                    <div class="slider slider-for zoom-gallery">
                        <a href="//admin.mossebo.market/uploads/1482/5ac371ee1d867158699819.jpeg"
                           title=""
                        >
                            <img data-lazy="//admin.mossebo.market/uploads/1482/5ac371ee1d867158699819.jpeg" alt="">
                        </a>
                        <a href="//admin.mossebo.market/uploads/1486/5ac371ee60b8c505625221.jpeg"
                           title=""
                        >
                            <img data-lazy="//admin.mossebo.market/uploads/1486/5ac371ee60b8c505625221.jpeg" alt="">
                        </a>
                        <a href="//admin.mossebo.market/uploads/1490/5ac371eec0845873734208.jpeg"
                           title=""
                        >
                            <img data-lazy="//admin.mossebo.market/uploads/1490/5ac371eec0845873734208.jpeg" alt="">
                        </a>
                        <a href="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg"
                           title=""
                        >
                            <img data-lazy="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg" alt="">
                        </a>
                        <a href="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg"
                           title=""
                        >
                            <img data-lazy="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg" alt="">
                        </a>
                    </div>
                    <div class="slider slider-nav">
                        <div>
                            <img data-lazy="//admin.mossebo.market/uploads/1482/5ac371ee1d867158699819.jpeg" alt="">
                        </div>
                        <div>
                            <img data-lazy="//admin.mossebo.market/uploads/1486/5ac371ee60b8c505625221.jpeg" alt="">
                        </div>
                        <div>
                            <img data-lazy="//admin.mossebo.market/uploads/1490/5ac371eec0845873734208.jpeg" alt="">
                        </div>
                        <div>
                            <img data-lazy="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg" alt="">
                        </div>
                        <div>
                            <img data-lazy="//admin.mossebo.market/uploads/1494/5ac371f13ee6f558326383.jpeg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 py-4 px-4 product-page__border-left">
                    <div class="product-page__actions text-right">
                        <a href="#"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Добавить в сравнение"
                        >
                            <i class="md-icon">playlist_add</i>
                        </a>
                        <a href="#"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Добавить в избранное"
                        >
                            <i class="md-icon">favorite</i>
                        </a>
                    </div>

                    <div class="product-page__price">144 144,14 &#8381;</div>
                    <div class="product-page__oldprice">155 155,15 &#8381;</div>
                    <div class="product-page__economy">Вы сэкономите: 8 000 &#8381;</div>

                    <div class="product-page__stars">
                        <i class="md-icon">star</i><i class="md-icon">star</i><i class="md-icon">star</i><i class="md-icon">star_border</i><i class="md-icon">star_border</i>
                        <span>324 оценки об этом продукте</span>
                    </div>

                    {{ $product->i18n->description }}

                </div>
            </div>
        </div>
    </div>


    <div class="container my-2 block-ui">
        <div class="product-page">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                       id="home-tab"
                       data-toggle="tab"
                       href="#home"
                       role="tab"
                       aria-controls="home"
                       aria-selected="true"
                    >
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       id="profile-tab"
                       data-toggle="tab"
                       href="#profile"
                       role="tab"
                       aria-controls="profile"
                       aria-selected="false"
                    >
                        Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    1
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    2
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    3
                </div>
            </div>

        </div>
    </div>



@endsection
