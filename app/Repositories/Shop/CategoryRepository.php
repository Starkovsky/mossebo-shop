<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\CategoryRepository as BaseCategoryRepository;
use App\Models\Shop\Category;

class CategoryRepository extends BaseCategoryRepository
{
    public function getTree()
    {
        return $this->getCollection()->toTree();
    }

    public function getCollectionRaw(): Collection
    {
        return Category::enabled()
            ->localized()
            ->with('image', 'productCounts')
            ->get();
    }
}
