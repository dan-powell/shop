<?php namespace DanPowell\Shop\Traits;


trait CartTrait
{

    /**
     * Takes a collection of CartItems and returns Collection grouped by product
     * Can optionally return only CartItems which have Options or Extras
     * @param $cartItems - Eloquent Collection
     * @param bool $onlyOptionsOrExtras
     * @return mixed
     */
    private function groupCartItemsByProduct($cartItems, $onlyOptionsOrExtras = false)
    {
        // Group items by product ID
        $itemsGrouped = $cartItems->groupBy('product.id');

        // For each product...
        $itemsGrouped->each(function ($itemGroup) use ($onlyOptionsOrExtras) {

            // Get the product info and save to collection
            $itemGroup->product = $itemGroup->first()->product;

            // Group product images
            $this->addImageTypes($itemGroup->product);

            // Calc quantity based on number of items
            $itemGroup->quantity = 0;
            foreach($itemGroup as $item) {
                $itemGroup->quantity += $item->quantity;
            }

            // Get the product line total base on items
            $price_sub_total = [];
            foreach ($itemGroup as $item) {
                array_push($price_sub_total, $item->price_sub_total);
            };
            $itemGroup->price_sub_total = array_sum($price_sub_total);

            $itemGroup->price_sub_total_string = config('shop.currency.symbol') . number_format($itemGroup->price_sub_total, 2);

            if($onlyOptionsOrExtras) {
                // Filter the items so only those with options/products are displayed
                $itemGroup->cartItems = $itemGroup->filter(function ($item) {
                    // Only return items with options
                    if (isset($item->options) && count($item->options)) {
                        return $item;
                    };
                });
            } else {
                $itemGroup->cartItems = $itemGroup;
            }

        });

        return $itemsGrouped;

    }

}