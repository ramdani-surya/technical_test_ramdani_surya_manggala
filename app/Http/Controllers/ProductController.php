<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            "data"         => Product::orderBy('name')->get(),
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
            'category_product_id' => ['required', 'integer', 'exists:category_products,id'],
            'name'                => ['required', 'string'],
            'price'               => ['required', 'integer', 'min:0'],
            'image'               => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $file  = $request->file('image');
            $image = time() . "_" . $file->getClientOriginalName();
            $dir   = public_path('images/products');

            $file->move($dir, $image);
        } else {
            $image = null;
        }

        $product = new Product;
        $product->category_product_id = $request->category_product_id;
        $product->name                = $request->name;
        $product->price               = $request->price;
        $product->image               = $image;
        $product->save();

        return response()->json([
            "message"      => "Product succesfully stored.",
            "data"         => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            "message"      => "Success.",
            "data"         => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_product_id' => ['required', 'integer', 'exists:category_products,id'],
            'name'                => ['required', 'string'],
            'price'               => ['required', 'integer', 'min:0'],
            'image'               => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {

            if (file_exists($oldImage = public_path("images/products/$product->image")))
                unlink($oldImage);

            $file  = $request->file('image');
            $image = time() . "_" . $file->getClientOriginalName();
            $dir   = public_path('images/products');

            $file->move($dir, $image);

            // perubahan value image dilakukan disini
            $product->image = $image;
        }

        $product->category_product_id = $request->category_product_id;
        $product->name                = $request->name;
        $product->price               = $request->price;
        $product->save();

        return response()->json([
            "message"      => "Product succesfully updated.",
            "data"         => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image)
            unlink(public_path("images/products/$product->image"));

        $product->delete();

        return response()->json([
            "message"      => "Product succesfully deleted.",
        ]);
    }
}
