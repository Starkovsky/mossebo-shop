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
                <offer id="{{ $product->id }}" productId="{{ $product->id }}" quantity="9999">
                    <url>https://mossebo.market/ru/goods/{{ $product->id }}</url>
                    <price>{{ $product->current_price->value / 100 }}</price>
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
                                <param name="{{ $attribute->current_i18n->title }}" code="atrr{{$attribute->id}}">
                                    {{ $attribute_option->current_i18n->value }}
                                </param>
                            @endif
                        @endforeach
                    @endforeach
                    <param name="Описание" code="description">{{ $product->current_i18n->description }}</param>
                    <param name="Артикул" code="article">{{ $product->id }}</param>
                    <param name="Вес" code="weight">{{ $product->weight / 1000 }} кг</param>
                    <dimensions>{{ $product->length / 10 }}/{{ $product->width / 10 }}/{{ $product->height / 10 }}</dimensions>
                    @foreach($suppliers as $supplier)
                        @if($product->supplier_id == $supplier->id)
                            <vendor>{{ $supplier->name }}</vendor>
                        @endif
                    @endforeach
                </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>
