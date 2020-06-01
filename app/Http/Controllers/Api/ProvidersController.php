<?php

namespace App\Http\Controllers\Api;

use App\Providers;
use App\Products;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use Illuminate\Http\Request;
class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProviderResource::collection(Providers::with('createByUser')->paginate(5));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Providers $provider)
    {
        return new ProviderResource($provider->load('createByUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, Providers $provider)
    {
        $request->validate([
            'name'=>'required|max:255',
        ]);

        $provider->update($request->all());

        return new ProviderResource($provider->load('createByUser'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Providers $provider)
    {
        $provider->delete();
        $id = $provider->id;
        Products::where('provider_id', $id)->update(['provider_company'=>'null']);
        return response(['message'=>'It has been deleted']);
    }
}
