<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRequestProduct;
use App\Http\Requests\UpdateRequestProduct;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $data = array();
        foreach($products as $row){
            $data[] = $row;
        }
        $response = ['code' => 200, 'data' => $data, 'msg' => null, 'status' => true];

        return response()->json($response);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUpdate(CreateRequestProduct $CreateRequest, UpdateRequestProduct $UpdateRequest)
    {
        $create = $CreateRequest->json()->all();
        $update = $UpdateRequest->json()->all();

        if(isset($update['id'])){

            $products = $this->update($update);            
            $response = ['code' => 200, 'data' => $products, 'msg' => 'update success', 'status' => true];

        }else{

            $products = $this->create($create);
            $response = ['code' => 200, 'data' => $products, 'msg' => 'save success', 'status' => true];

        }

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {

        $products = new Product;

        $products->nama                 = $request['nama'];
        $products->sku                  = $request['sku'];
        $products->brand                = $request['brand'];
        $products->deskripisi           = $request['deskripisi'];
        $products->variasi              = $request['variasi'];
        
        try{
            $products->save();
            return $products;
        }catch (Exception $e) {
            $response = ['code' => 500, 'data' => null, 'msg' => 'error', 'status' => true];
            return $response;
        }     

    }

    public function update($request)
    {
        $products = Product::find($request['id']);

        $products->nama                 = $request['nama'];
        $products->sku                  = $request['sku'];
        $products->brand                = $request['brand'];
        $products->deskripisi           = $request['deskripisi'];
        $products->variasi              = $request['variasi'];      

        try{
            $products->save();
            return $products;
        }catch (Exception $e) {
            $response = ['code' => 500, 'data' => null, 'msg' => 'error', 'status' => true];
            return $response;
        }

    }
}
