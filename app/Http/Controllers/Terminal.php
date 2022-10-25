<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Promotion;

class Terminal extends Controller
{
    //
    public function setPricing()
    {
        # code...
        $tmpV = 'Pricing and Promo Controller';
        return $tmpV;
    }

    public function scan($sku)
    {
        # code...
        $product = Product::where('code',$sku);
		$product = $product->get()->first();

        if ( $product ) {
            return $product;
        } else {
            return false;
        }
        
    }

    public function promo($pid)
    {
        # code...
        $promo = Promotion::where('product_id',$pid);
		$promo = $promo->get()->first();

        if ( $promo ) {
            return $promo;
        } else {
            return false;
        }
    }
}
