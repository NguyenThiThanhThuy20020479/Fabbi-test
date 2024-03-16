<?php

namespace App\Http\Controllers;

use App\Enum\MealEnum;
use App\Models\Restaurant;
use App\Rules\DuplicateDish;
use App\Rules\GreaterThanCustomer;
use App\Rules\MaximumOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;

class DishesController extends Controller
{
    public function step_1(Request $request) {
        $meals = [
            MealEnum::BREAKFAST,
            MealEnum::LUNCH,
            MealEnum::DINNER
        ];
        $selected_meal = Session::get('selected_meal') ?? '';
        $quantity_customers = Session::get('quantity_customers') ?? '';
        return view('index', [
            'meals' => $meals,
            'selected_meal' => $selected_meal,
            'quantity_customers' => $quantity_customers
        ]);
    }

    public function step_2(Request $request) {
        // save meal and quatity into session
        $selected_meal = $request->input('selected_meal');
        $quantity_customers = $request->input('quantity_customers');
        Session::put('selected_meal', $selected_meal);
        Session::put('quantity_customers', $quantity_customers);
        // validate for meal and quantity selector
        $vadilator = Validator::make($request->all(), 
            [
                'selected_meal'=>'required',
                'quantity_customers' => ['required', new MaximumOrder]
            ],
            [                  
                'selected_meal.required' => 'Please choose meal',
            ],
        );
        // Check validation fails
        if ($vadilator->fails()) {
            return redirect()->back()->withErrors($vadilator)->withInput();
        }    
        // get all restaurant
        $all_res = DB::table('restaurants')
        ->join('dishes', 'dishes.res_id', '=', 'restaurants.id')
        ->select('restaurants.id','restaurants.name', 'dishes.meal', 'dishes.name as dish')
        ->get();  
        $restaurants = [];
        $dishes[] = [];
        $res_no = [];
        foreach ($all_res as $res) {
            if (in_array($selected_meal, json_decode($res->meal, true)) && !in_array($res->id, $res_no)) {
                $res_no[] = $res->id;
                $restaurants[] = $res;
            } 
        }
        $dish_arr[] = [];
        foreach ($all_res as $arr) {
            if (in_array($selected_meal, json_decode($arr->meal, true))){
                if (!isset($dish_arr[$arr->id])) {
                    $dish_arr[$arr->id] = array();
                }
                $dish_arr[$arr->id][] = $arr->dish;
            }       
        }
        return view('step_2', [
            'selected_meal'=>$selected_meal,
            'quantity_customers'=> $quantity_customers,
            'restaurants' => $restaurants,
            'dishes' => $dish_arr
        ]);
    }
    
    public function step_3(Request $request) {
        $meal = Session::get('selected_meal');
        $quantity_customers = Session::get('quantity_customers');
        $selected_res_id = $request->input('selected_res');
        $selected_res = Restaurant::find($selected_res_id)->name;
        $selected_dish = $request->input('addMoreInputFields');
        $servings = $request->input('servings');
        // validate
        $vadilator = Validator::make($request->all(), 
            [
                'selected_res'=>'required',
                'addMoreInputFields' => new DuplicateDish,
                'servings' => new GreaterThanCustomer($quantity_customers)
            ],
        );
        // Check validation fails, retunrn to first page
        if ($vadilator->fails()) {
            $request->session()->flush();
            return redirect('step_1');
        }    
        return view('step_3', [
            'meal'=> $meal,
            'quantity_customers' => $quantity_customers,
            'selected_res' => $selected_res,
            'selected_dish' => $selected_dish,
            'servings' => $servings
        ]);
    }
}
