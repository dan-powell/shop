<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (\App::environment('local', 'staging')) {
            // Clear existing data
            $this->clearData();
        }

        $this->call('ImageSeeder');
        $this->call('ProductSeeder');
        $this->call('CategorySeeder');
        $this->call('CategoryImageSeeder');
        $this->call('ProductImageSeeder');
        $this->call('ProductCategorySeeder');
        $this->call('ProductRelatedSeeder');

        Model::reguard();
    }

    private function clearData()
    {

        // Clear images
        $files = glob('public/images/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('options')->truncate();
        DB::table('option_groups')->truncate();
        DB::table('personalisations')->truncate();
        DB::table('images')->truncate();
        DB::table('images_attachments')->truncate();
        DB::table('product_related')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
