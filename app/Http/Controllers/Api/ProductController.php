<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'search'    => 'nullable|string',
            'category'  => 'nullable|integer',
            'page'      => 'nullable|integer',
        ]);


        $builder = Product::select('*', 'category_id AS id_cat');

        /**
         *  Filters
         */
        if ($request->search) $builder->where('name', 'LIKE', "%{$request->search}%");
        if ($request->category) $builder->where('category_id', $request->category);


        $products = $builder->get();
        $total = $products->count();
        $perPage = 2;
        $page = $request->page ?? 1;
        $offsetPages = $page - 1;
        $pages = ceil($total / $perPage);

        $products = array_slice(
            $products->toArray(),
            $perPage * $offsetPages,
            $perPage
        );

        return response()->json([
            "error"     => "",
            "result"    => [
                "data"  => $products,
                "page"  => $page,
                "pages" => $pages,
                "total" => $total,
            ]
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product)
        {
            return response()->json([
                'error'     => '',
                'result'    => $product
            ]);
        }

        return response()->json([
            'error'     => 'nenhum produto encontrado com id: ' . $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
