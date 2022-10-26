<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AjaxController extends Controller
{
    public function selectItemId(Request $request){
        if($request->params == 'product_list'){
            $data = Product::where('id',$request->id)->delete();
            if($data){
                $response = ['code' => 200, 'data' => null, 'msg' => 'delete success', 'status' => true]; 
                return response()->json($response);           
            }
        }
    }
}
