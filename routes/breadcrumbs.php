<?php


Breadcrumbs::for('home', function ($trail) {
    $trail->push(Lang::get('content.home'), route('home'));
});

/*
 * Каталог
 */
Breadcrumbs::for('catalog', function ($trail) {
    $trail->parent('home');
    $trail->push(Lang::get('content.catalog'), route('catalog'));
});

Breadcrumbs::for('catalog-category', function ($trail, $category) {
    $trail->parent('catalog');
    $trail->parent('category-tree', $category);
});

/*
 * Комнаты
 */
Breadcrumbs::for('rooms', function ($trail) {
    $trail->parent('home');
    $trail->push(Lang::get('content.rooms'), route('rooms'));
});

Breadcrumbs::for('room-catalog', function ($trail, $room, $category) {
    $trail->parent('rooms', $room);
    $trail->push($room->currentI18n->title, route('room-catalog', $room->slug));

    if ($category) {
        $trail->parent('category-tree', $category, 'room-category', ['roomSlug' => $room->slug]);
    }
});

Breadcrumbs::for('room-category', function ($trail, $room, $category) {
    $trail->parent('room-catalog', $room, $category);
});

/*
 * Стили
 */
Breadcrumbs::for('styles', function ($trail) {
    $trail->parent('home');
    $trail->push(Lang::get('content.styles'), route('styles'));
});

Breadcrumbs::for('style-catalog', function ($trail, $style, $category) {
    $trail->parent('styles', $style);
    $trail->push($style->currentI18n->title, route('style-catalog', $style->slug));

    if ($category) {
        $trail->parent('category-tree', $category, 'style-category', ['styleSlug' => $style->slug]);
    }
});

Breadcrumbs::for('style-category', function ($trail, $style, $category) {
    $trail->parent('style-catalog', $style, $category);
});


Breadcrumbs::for('category-tree', function ($trail, $category, $routeName = 'catalog-category', $routeData = []) {
    $parent = Categories::getCollection('currentI18n')->where('id', $category->parent_id)->first();

    if ($parent) {
        $trail->parent('category-tree', $parent, $routeName, $routeData);
    }

    $routeData['categorySlug'] = $category->slug;

    $trail->push($category->currentI18n->title, route($routeName, $routeData));
});

Breadcrumbs::for('help', function ($trail) {
    $trail->parent('home');

    $trail->push(Lang::get('content.help'), route('help'));
});


Breadcrumbs::for('help-article', function ($trail, $article) {
    $trail->parent('help');

    $trail->push($article->title, route('help-article', ['slug' => $article->slug]));
});


Breadcrumbs::for('good-category', function ($trail, $good) {
    $category = $good->categories()->first();

    if ($category) {
        $trail->parent('catalog-category', $category);
    }
    else {
        $trail->parent('catalog');
    }
});


Breadcrumbs::for('good-referer', function ($trail, $good) {
    $referer = request()->server('HTTP_REFERER');

    if ($referer) {
        $route = app('router')->getRoutes()->match(
            app('request')->create(
                request()->server('HTTP_REFERER')
            )
        );

        if (isset($route->parameters['slug'])) {
            $routeName = $route->getName();

            if ($routeName === 'catalog-category') {
                $category = Categories::enabled('currentI18n')->where('slug', $route->parameters['slug'])->first();

                if ($category) {
                    $trail->parent('catalog-category', $category);
                    return;
                }
            }


            if (isset($route->parameters['categorySlug'])) {
                $category = Categories::enabled('currentI18n')->where('slug', $route->parameters['categorySlug'])->first();
            }

            if ($routeName === 'style-category') {
                $style = Styles::enabled('currentI18n')->where('slug', $route->parameters['slug'])->first();

                if ($style) {
                    if (isset($category)) {
                        $trail->parent('style-category', $style, $category);
                    }
                    else {
                        $trail->parent('style', $style);
                    }

                    return;
                }
            }

            if ($routeName === 'room-category') {
                $room = Rooms::enabled('currentI18n')->where('slug', $route->parameters['slug'])->first();

                if ($room) {
                    if (isset($category)) {
                        $trail->parent('room-category', $room, $category);
                    }
                    else {
                        $trail->parent('room', $room);
                    }

                    return;
                }
            }
        }
    }

    $trail->parent('good-category', $good);
});

Breadcrumbs::for('good', function ($trail, $good) {
    $trail->parent('good-referer', $good);

    $trail->push($good->currentI18n->title, route('good', $good->id));
});
