<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('viewProducts', 'showProduct');
    }

    /**
     * create product
     * 
     * @return Illuminate\Http\Response
     */
    public function createProduct(ProductFormRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::user()->id;
        $product = Product::create($validated);

        return $this->sendResponse($product, 'product successfully created.');
    }

    /**
     * update product.
     * 
     * @return Illuminate\Http\Response
     */
    public function updateProduct(ProductFormRequest $request, Product $product)
    {
        if ($request->user()->cannot('update', $product)) {
            return $this->sendError('Unauthorized', ['error' => 'You do not own this product'], Status::BAD_REQUEST);
        }

        
    }
}
