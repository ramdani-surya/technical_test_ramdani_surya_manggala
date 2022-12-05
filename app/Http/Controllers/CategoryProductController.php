<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "message"      => "Success.",
            "data"         => CategoryProduct::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:category_products,name']
        ]);

        $categoryProduct = new CategoryProduct;
        $categoryProduct->name = $request->name;
        $categoryProduct->save();

        return response()->json([
            "message"      => "Category product succesfully stored.",
            "data"         => $categoryProduct,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            "message"      => "Success.",
            "data"         => CategoryProduct::find($id) ?: null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryProduct $categoryProduct)
    {
        $request->validate([
            'name' => ['required', 'string', "unique:category_products,name,$categoryProduct->id"]
        ]);

        $categoryProduct->name = $request->name;
        $categoryProduct->save();

        return response()->json([
            "message"      => "Category product succesfully updated.",
            "data"         => $categoryProduct,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();

        return response()->json([
            "message"      => "Category product succesfully deleted.",
        ]);
    }
}
