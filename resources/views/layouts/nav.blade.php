<nav class="header-navigation d-none d-lg-block d-xl-block">
    <div class="container">
        <ul class="header-navigation-list">
            <li class="header-navigation-list__item header-navigation-catalog">
                <a href="/ru/catalog" class="">
                    <svg class="symbol-icon symbol-menu">
                        <use xlink:href="/assets/images/icons.svg#symbol-menu"></use>
                    </svg>
                    Каталог товаров</a>
                @php
                    $categorys = App\Models\Shop\Category::with('i18n')->get()->toTree();
                    echo "<ul style='display:none'>";
                    foreach ($categorys as $category) {
                        echo "<li>";
                        echo '<a href="/catalog/' . $category->slug . '">';
                        echo $category->i18n->title;
                        echo "</a></li>";
                        echo "<ul>";
                        foreach ($category->children as $children) {
                            //echo $children;
                            echo "<li>";
                            echo '<a href="/catalog/' . $children->slug . '">';
                            echo $children->i18n->title;
                            echo "</a></li>";
                        }
                        echo "</ul>";
                    }
                    echo "</ul>";
                @endphp
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Стили</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Комплекты</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Новинки</a>
            </li>
            <li class="header-navigation-list__item header-navigation-list-discount">
                <a href="#" class="">Скидки</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Оплата</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Получение</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="#" class="">Гарантия и возврат</a>
            </li>
        </ul>
    </div>
</nav>
