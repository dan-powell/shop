<?php namespace DanPowell\Shop\Traits;


trait CartTrait
{

    private function getCartItemTotal($cartItems) {

        $arr = [];
        foreach($cartItems as $item) {
            array_push($arr, $item->sub_total);
        };

        return array_sum($arr);

    }


    private function groupCartItemsByProduct($cartItems)
    {
        // Group items by product ID
        $itemsGrouped = $cartItems->groupBy('product.id');

        // For each product...
        $itemsGrouped->each(function ($itemGroup) {

            // Get the product info and save to collection
            $itemGroup->product = $itemGroup->first()->product;

            // Group product images
            $this->addImageTypes($itemGroup->product);

            // Calc quantity based on number of items
            $itemGroup->quantity = count($itemGroup);

            // Get the product line total base on items
            $sub_total = [];
            foreach ($itemGroup as $item) {
                array_push($sub_total, $item->sub_total);
            };
            $itemGroup->sub_total = array_sum($sub_total);

            // Filter the items so only those with option/products are displayed
            $itemGroup->cartItems = $itemGroup->filter(function ($item) {

                // Only return items with options OR personalisations
                if (
                    (isset($item->options) && count($item->options)) ||
                    (isset($item->personalisations) && count($item->personalisations))
                ) {
                    return $item;
                };

            });

        });

        return $itemsGrouped;

    }

}



