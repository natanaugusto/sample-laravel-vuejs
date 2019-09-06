<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class Products extends Controller
{
    const LOG_INDEX = 'PRODUCT_INDEX';
    const LOG_STORE = 'PRODUCT_STORE';
    const LOG_SHOW = 'PRODUCT_SHOW';
    const LOG_UPDATE = 'PRODUCT_UPDATE';
    const LOG_DESTROY = 'PRODUCT_DESTROY';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $hasPermission = $this->userHasPermission(self::LOG_INDEX, $request, 'list products');
            if($hasPermission !== true) {
                return $hasPermission;
            }

            $response = response()->json(
                Product::paginate((new Product())->getPerPage())
            );
            $this->registerLog(self::LOG_INDEX, 'info', $request, $response);

            return $response;
        } catch(\Exception $e) {
            $this->registerLog(self::LOG_INDEX, 'error', $request, null, $this->parseError($e));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $hasPermission = $this->userHasPermission(self::LOG_STORE, $request, 'add product');
            if($hasPermission !== true) {
                return $hasPermission;
            }
            $validate = $this->validate($request->all(), Product::$rules);
            if($validate !== true) {
                return $validate;
            }
            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->category_id = $request->input('category_id');
            $product->price = $request->input('price');
            $product->save();

            $response = response()->json(
                $product, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
            $this->registerLog(self::LOG_STORE, 'notice', $request, $response);
            return $response;
        } catch(\Exception $e) {
            $this->registerLog(self::LOG_STORE, 'error', $request, null, $this->parseError($e));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $hasPermission = $this->userHasPermission(self::LOG_SHOW, $request, 'view product');
            if($hasPermission !== true) {
                return $hasPermission;
            }

            $response = response()->json(
                Product::findOrFail($id)
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
            $this->registerLog(self::LOG_SHOW, 'info', $request, $response);

            return $response;
        } catch(\Exception $e) {
            $this->registerLog(self::LOG_SHOW, 'error', $request, null, $this->parseError($e));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $hasPermission = $this->userHasPermission(self::LOG_UPDATE, $request, 'update product');
            if($hasPermission !== true) {
                return $hasPermission;
            }
            $rules = Product::$rules;
            $rules['name'] .= ",id,{$id}";
            $validate = $this->validate($request->all(), $rules);
            if($validate !== true) {
                return $validate;
            }
            $product = Product::find($id);
            if($request->has('name')) {
                $product->name = $request->input('name');
            }
            if($request->has('description')) {
                $product->description = $request->input('description');
            }
            if($request->has('category_id')) {
                $product->category_id = $request->input('category_id');
            }
            if($request->has('price')) {
                $product->price = $request->input('price');
            }
            $product->save();

            $response = response()->json(
                $product, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
            $this->registerLog(self::LOG_UPDATE, 'notice', $request, $response);
            return $response;
        } catch(\Exception $e) {
            $this->registerLog(self::LOG_UPDATE, 'error', $request, null, $this->parseError($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $hasPermission = $this->userHasPermission(self::LOG_DESTROY, $request, 'list products');
            if($hasPermission !== true) {
                return $hasPermission;
            }

            if(Product::findOrFail($id)->delete()) {
                $response = response()->json(null, 204);
            } else {
                throw new \Exception("An error ocurred");
            }
            $this->registerLog(self::LOG_DESTROY, 'notice', $request, $response);
            return $response;
        } catch(\Exception $e) {
            $this->registerLog(self::LOG_DESTROY, 'error', $request, null, $this->parseError($e));
        }
    }
}
