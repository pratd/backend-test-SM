<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Products::with('createByUser')->paginate(5));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
        ]);
        if($request->hasFile('image')){
            $cover = $request->file('image');
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename().'.'.$extension, File::get($cover));

            $product = auth()->user()->Products()->create([
                $request->all(),
                'mime'=> $cover->getClientMimeType(),
                'original_filename' => $cover->getClientOriginalName(),
                'filename' => $cover->getFilename().'.'.$extension,
            ]);
        }else{
            $product = auth()->user()->Products()->create($request->all());
        }


        return new ProductResource($product->load('createByUser'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        return new ProductResource($product->load('createByUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Products $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Products $product)
    {
        $request->validate([
            'name'=>'required|max:255',
        ]);

        if ($request->hasFile('image')){
            $cover = $request->file('image');
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename().'.'.$extension, File::get($cover));
            $product->update([
                $request->all(),
                'mime'=> $cover->getClientMimeType(),
                'original_filename' => $cover->getClientOriginalName(),
                'filename' => $cover->getFilename().'.'.$extension,
            ]);
        }else{
            $product->update($request->all());
        }




        return new ProductResource($product->load('createByUser'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $product->delete();

        return response(['message'=>'It has been deleted']);
    }
}
