<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        //You can use anyway to filter the results! Am Just using this way for Demo!!
        
        $productQuery = $product->newQuery();

        $products = !empty( $request->input('searchText') ) ? $productQuery->where('name', $request->input('searchText'))
                                                                           ->orWhere('category', $request->input('searchText')) : $productQuery;

        $products = !empty( $request->input('limit') ) ? $products->paginate( $request->input('limit') ) : $products->paginate(5);

        if( $request->wantsJson() )
        {
            return response()->json( $products );
        }

        return view ( 'welcome' );
    }

}
