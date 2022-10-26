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
        // GET Product
        $products = Product::all();

        // Array Variable
        $data = array();

        // Loop Product
        foreach($products as $row){
            $data[] = $row;
        }

        // Variable Response Code, Data, Messages, Status
        $response = ['code' => 200, 'data' => $data, 'msg' => null, 'status' => true];

        // Return Response Json
        return response()->json($response);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUpdate(CreateRequestProduct $CreateRequest, UpdateRequestProduct $UpdateRequest)
    {
        // Request Create Json
        $create = $CreateRequest->json()->all();

        // Request Update Json
        $update = $UpdateRequest->json()->all();

        // Check Update Or Create
        if(isset($update['id'])){

            // Call Function Update
            $products = $this->update($update);            

            // Variable Response Code, Data, Messages, Status
            $response = ['code' => 200, 'data' => $products, 'msg' => 'update success', 'status' => true];

        }else{

            // Call Function Create
            $products = $this->create($create);

            // Variable Response Code, Data, Messages, Status
            $response = ['code' => 200, 'data' => $products, 'msg' => 'save success', 'status' => true];

        }

        // Return Response Json
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

            // Return Data
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

            // Return Data
            return $products;
        }catch (Exception $e) {
            $response = ['code' => 500, 'data' => null, 'msg' => 'error', 'status' => true];
            return $response;
        }

    }
}
