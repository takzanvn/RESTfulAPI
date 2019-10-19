<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category) {
        // attact, sync, syncWithoutDetaching
        // $product->categories()->attact([$category->id]);
        // $product->categories()->sync([$category->id]);
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    public function destroy(Product $product, Category $category) {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('The speccified category is not a category of this product', 404);
        }
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
