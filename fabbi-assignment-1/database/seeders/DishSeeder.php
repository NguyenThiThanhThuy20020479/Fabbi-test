<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
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
       
       foreach ($data as $item) {
            $restaurant = Restaurant::where('name', $item['restaurant'])->first()->id ?? null;
            Dish::query()->updateOrCreate([
                'name'=>$item['name'],
                'res_id' => $restaurant,
                'meal' => json_encode($item['availableMeals'], true)
            ]);
        }
    }
}
