<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="2013-06-20 10:09:18">
    <shop>
        <name>Mossebo.Market</name>
        <company>ООО "МОССЭБО КМ"</company>
        <categories>
            @foreach($categorys as $category)
                <category id="{{ $category->id }}"
                          @if(!is_null($category->parent_id)) parentId="{{ $category->parent_id }}" @endif >
                    {{{ $category->current_i18n->title }}}
                </category>
            @endforeach
        </categories>
        <offers>
            @foreach($products as $product)
                <offer id="{{ $product->id }}" productId="{{ $product->id }}">
                    <url>https://mossebo.market/ru/goods/{{ $product->id }}</url>
                    <purchasePrice>{{ $product->current_price->value / 100 }}</purchasePrice>
                    @foreach($product->categories as $product_cat)
                        <categoryId>{{ $product_cat->id }}</categoryId>
                    @endforeach
                    <picture>
                        @if($product->image)
                            https://admin.mossebo.market{{ json_decode($product->image->pathes)->original }}
                        @endif
                    </picture>
                    <name>{{ $product->current_i18n->title }}</name>
                    <productName>{{ $product->current_i18n->title }}</productName>
                    @foreach($product->attributes as $attribute)
                        @foreach($product->attribute_options as $attribute_option)
                            @if($attribute_option->attribute_id == $attribute->id)
                                <param name="{{ $attribute->current_i18n->title }}" code="size">
                                    {{ $attribute_option->current_i18n->value }}
                                </param>
                            @endif
                        @endforeach
                    @endforeach
                    <param name="Артикул" code="article">{{ $product->id }}</param>
                </offer>
            @endforeach
            <offer id="115" productId="43" quantity="16">
                <url>http://testbitrix.test/catalog/shelves/rack_2_sectional/</url>
                <price>14000.00</price>
                <purchasePrice>13200.00</purchasePrice>
                <categoryId>3</categoryId>
                <picture>http://testbitrix.test/upload/iblock/d2b/d2b25cbdc1f76b8b1672f5e8d1ec6589.JPG</picture>
                <name>Стеллаж 2-х секционный</name>
                <xmlId>82</xmlId>
                <productName>Стеллаж 2-х секционный</productName>
                <param name="Артикул" code="article">789789</param>
                <param name="Размер" code="size">двухъярусный</param>
                <param name="Цвет" code="color">белый</param>
                <vendor>Abagure</vendor>
                <param name="Вес" code="weight">50 кг</param>
                <unit code="pcs" name="Штука" sym="шт." />
                <vatRate>18</vatRate>
                <dimensions>100/50.8/150</dimensions>
                <barcode>012485ab</barcode>
            </offer>
        </offers>
    </shop>
</yml_catalog>
