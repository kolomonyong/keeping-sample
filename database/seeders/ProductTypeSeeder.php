<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB Facade

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Hapus data lama untuk menghindari duplikasi
        // DB::table('product_types')->delete();

        $productTypes = [
            // ['name' => 'Sachet BKM Champion 34g'],
            // ['name' => 'Sachet CHO Champion 34g'],
            // ['name' => 'Sachet Alaska Condensada 34g'],
            // ['name' => 'Sachet DutchLady Gold 34g'],
            // ['name' => 'BKM Big Bag 5000gr'],
            // ['name' => 'OMELA Big Bag 5000gr'],
            // ['name' => 'Can BKM Champion 370g'],
            // ['name' => 'Pouch BKM Champion 535g'],
            // ['name' => 'Pouch BKM Champion 240g'],
            // ['name' => 'Pouch CHO Champion 535g'],
            // ['name' => 'Pouch CHO Champion 240g'],
            // ['name' => 'Pouch Dutch Lady 545g'],
            // ['name' => 'Pouch Dutch Lady 280g'],
            // ['name' => 'Pouch Alaska Condensada 545g'],
            // ['name' => 'Pouch CHO Ekonomis 545g'],
            // ['name' => 'Pouch CHO Ekonomis Rp9900 260g'],
            // ['name' => 'Pouch BKM Ekonomis 545g'],
            // ['name' => 'Pouch BKM Ekonomis Rp9900 260g'],
            // ['name' => 'Pouch CHO FFI 280g'],
            // ['name' => 'Pouch BKM FFI 280g'],
            // ['name' => 'Can BKM 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Can CHO 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Can COWBELL 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Can ALASKA CONDENSADA 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Can ALASKA CLASSIC 370g', 'shelf_life_days' => '334'],
            // ['name' => 'Can LIBERTY 370g', 'shelf_life_days' => '334'],
            // ['name' => 'Can CHO 490g', 'shelf_life_days' => '365'],
            // ['name' => 'Can BKM 490g', 'shelf_life_days' => '365'],
            // ['name' => 'Can OMELA 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Can OMELA 490g', 'shelf_life_days' => '365'],
            // ['name' => 'Sachet Gold 34g', 'shelf_life_days' => '274'],
            // ['name' => 'Can Gold 370g', 'shelf_life_days' => '365'],
            // ['name' => 'Pouch GOLD 280g', 'shelf_life_days' => '274'],
            // ['name' => 'Pouch CHEESE 280g', 'shelf_life_days' => '274'],
            // ['name' => 'Sachet CHEESE 34g', 'shelf_life_days' => '274'],
            // ['name' => 'Can Falcon 370g', 'shelf_life_days' => '365'],
            // ['name' => 'POUCH Falcon 545g', 'shelf_life_days' => '274'],
            ['name' => 'POUCH KOREAN STRAWBERRY 240g', 'shelf_life_days' => '274'],
            ['name' => 'SACHET KOREAN STRAWBERRY 37g', 'shelf_life_days' => '274'],
        ];

        // Tambahkan timestamp secara manual
        foreach ($productTypes as &$type) {
            $type['created_at'] = now();
            $type['updated_at'] = now();
        }

        DB::table('product_types')->insert($productTypes);
    }
}
// This seeder populates the product_types table with initial data for product types.