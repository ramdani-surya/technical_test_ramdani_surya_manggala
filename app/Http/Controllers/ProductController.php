<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $image = ($request->hasFile('image'))
        ? $request->file('image')->store('products')
        : null;

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

        // gunakan path image sebelumnya (yang sudah diupload)
        $image = $product->image;

        // jika user input image baru
        if ($request->hasFile('image')) {
            // ganti path image dengan yang baru
            $image = $request->file('image')->store('products');

            // hapus file image lama
            Storage::delete($product->image);
        }

        $product->category_product_id = $request->category_product_id;
        $product->name                = $request->name;
        $product->price               = $request->price;
        $product->image               = $image;
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
            Storage::delete($product->image);

        $product->delete();

        return response()->json([
            "message"      => "Product succesfully deleted.",
        ]);
    }
}
