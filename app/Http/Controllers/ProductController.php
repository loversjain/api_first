<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;   
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\ProductRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ProductNotMatchToUserException;
use Auth;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return  ProductCollection::collection(Product::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;   
        $product->deatil = $request->deatil;   
        $product->discount = $request->discount;   
        $product->stock = $request->stock;   
        $product->save();

        return response([
            'data'=> new ProductResource($product)
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new  ProductResource($product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->productNotBelongsTo($product);
        $request['deatil'] = $request->description;
        unset($request['deatil']);
        $product->update($request->all());
         return response([
            'data'=> new ProductResource($product)
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productNotBelongsTo($product);
        $product->delete();
         return response([
            'data'=> new ProductResource($product)
        ], Response::HTTP_CREATED);
        
    }

    public function productNotBelongsTo($product){
        if (Auth::id() !== $product->user_id){
            throw new ProductNotMatchToUserException;
            
        }
        
    }
}
