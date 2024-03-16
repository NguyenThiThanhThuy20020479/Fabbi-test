<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = file_get_contents('./resources/data/data.json');
        $data = json_decode($jsonData, true);
        $res = [];
        
       foreach($data as $item) {
        $res[] = $item['restaurant'];
       }
       foreach ($res as $r) {
            Restaurant::query()->updateOrCreate([
                'name'=>$r
            ]);
        }
    }
}
