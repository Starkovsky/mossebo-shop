<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\CategoryRepository as BaseCategoryRepository;
use App\Models\Shop\Category\Category;

class CategoryRepository extends BaseCategoryRepository
{
    public function getTree()
    {
        return $this->getCollection()->toTree();
    }

    public function getCollectionRaw(): Collection
    {
        return Category::enabled()
            ->withProductCount()
            ->with('image')
            ->get();
    }
}
