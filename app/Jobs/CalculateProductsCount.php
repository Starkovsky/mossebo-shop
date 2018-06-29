<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Shop\Product;
use App\Models\Shop\ProductCount;

use Categories;
use Rooms;
use Styles;


class CalculateProductsCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $this->calculateCatalog();
//        $this->calculateRoomCatalogCounts();
    }

    protected function calculateCatalogCounts()
    {
        Categories::getCollection()->each(function ($category) {
            (new ProductCount([
                'category_id' => $category->id,
                'count' => Product::enabled()->whereCategory($category->id)->count(),
            ]))->save();
        });
    }

    protected function calculateStyleCounts()
    {
        Styles::getCollection()->each(function ($style) {
            (new ProductCount([
                'style_id' => $style->id,
                'count' => Product::enabled()->whereStyle($style->id)->count(),
            ]))->save();
        });
    }

    protected function calculateStyleCatalogCounts()
    {
        Styles::getCollection()->each(function ($style) {
            Categories::getCollection()->each(function ($category) use($style) {
                (new ProductCount([
                    'category_id' => $category->id,
                    'style_id' => $style->id,
                    'count' => Product::enabled()->whereCategory($category->id)->whereStyle($style->id)->count(),
                ]))->save();
            });
        });
    }

    protected function calculateRoomCounts()
    {
        Rooms::getCollection()->each(function ($room) {
            (new ProductCount([
                'room_id' => $room->id,
                'count' => Product::enabled()->whereRoom($room->id)->count(),
            ]))->save();
        });
    }

    protected function calculateRoomCatalogCounts()
    {
        Rooms::getCollection()->each(function ($room) {
            Categories::getCollection()->each(function ($category) use($room) {
                (new ProductCount([
                    'category_id' => $category->id,
                    'room_id' => $room->id,
                    'count' => Product::enabled()->whereCategory($category->id)->whereRoom($room->id)->count(),
                ]))->save();
            });
        });
    }
}
