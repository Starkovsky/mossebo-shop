<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="2013-06-20 10:09:18">
    <shop>
        <name>Mossebo.Market</name>
        <company>ООО "МОССЭБО КМ"</company>
        <categories>
            @foreach($categories as $category)
                <category id="{{ $category->id }}" @if(!is_null($category->parent_id)) parentId="{{ $category->parent_id }}" @endif>{{ $category->title }}</category>
            @endforeach
        </categories>
        <offers>
            @foreach($products as $product)
                <offer id="{{ $product->id }}" productId="{{ $product->id }}" quantity="9999">
                    <url>https://mossebo.market/ru/goods/{{ $product->id }}</url>
                    @if ($product->relationNotEmpty('currentPrice'))
                        <price>{{ $product->currentPrice->value }}</price>
                    @endif
                    @if ($product->relationNotEmpty('categoryRelations'))
                        @foreach($product->categoryRelations as $categoryRelation)
                            <categoryId>{{ $categoryRelation->category_id }}</categoryId>
                        @endforeach
                    @endif
                    <picture>
                        @if($product->image)
                            {{ imagePath(json_decode($product->image->pathes)->original) }}
                        @endif
                    </picture>
                    <name>{{ $product->title }}</name>
                    <productName>{{ $product->title }}</productName>
                    @if ($product->relationNotEmpty('attributes') && $product->relationNotEmpty('attribute_options'))
                        @foreach($product->attributes as $attribute)
                            @foreach($product->attribute_options as $attribute_option)
                                @if($attribute_option->attribute_id == $attribute->id)
                                    <param name="{{ $attribute->title }}" code="attr-{{$attribute->id}}">
                                        {{ $attribute_option->value }}
                                    </param>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                    <param name="Описание" code="description">{{ $product->description }}</param>
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
