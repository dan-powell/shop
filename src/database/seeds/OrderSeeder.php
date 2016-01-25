<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(DanPowell\Shop\Models\Order::class, 20)->create();
        
    }
}