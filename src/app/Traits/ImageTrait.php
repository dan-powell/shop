<?php namespace DanPowell\Shop\Traits;


trait ImageTrait
{

    private function addImageTypes($collection)
    {

        if (count($collection) > 1) {

            $collection->each(function ($m) {
                $this->groupImagesByType($m);
            });

        } else {
            $this->groupImagesByType($collection);
        }

    }

    private function groupImagesByType($collection)
    {

        if(isset($collection->images) && count($collection->images)) {
            $collection->image_types = $collection->images->groupBy('pivot.image_type');
        } else {
            //$collection->image_types = [];
        }

    }

}