<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Image;

class ImageRepository
{

    /**
     * @param $product
     * @return mixed
     */
    public function groupImagesByType($collectionItem)
    {
        return $collectionItem->images->groupBy('pivot.image_type');
    }

}