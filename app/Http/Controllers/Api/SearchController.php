<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use App\Providers;
class SearchController extends Controller
{
    public function search(Request $request){

        if($request->city){
            $city = $request->city;
            $products =Products::whereHas('relateByProvider', function($q) use($city) {
                $q->where('city','like', $city);
            })->get();
            return $products;
        }elseif($request->type){
            $type = $request->type;
            $products =Products::where('type','like', $type)->get();
            return $products;
        }else{
            return response(['message'=>'Search method do not exist']);
        }
    }
}
