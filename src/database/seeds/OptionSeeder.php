<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DanPowell\Shop\Models\Option::class, 20)->create();
    }
}