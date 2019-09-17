<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class Categories extends Controller
{
  const LOG_INDEX = 'CATEGORY_INDEX';
  const LOG_STORE = 'CATEGORY_STORE';
  const LOG_SHOW = 'CATEGORY_SHOW';
  const LOG_UPDATE = 'CATEGORY_UPDATE';
  const LOG_DESTROY = 'CATEGORY_DESTROY';

  /**
  * Display a listing of the resource.
  *
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function index(Request $request)
  {
    try {
      $hasPermission = $this->userHasPermission(self::LOG_INDEX, $request, 'list categories');
      if($hasPermission !== true) {
        return $hasPermission;
      }

      $response = response()
      ->json(Category::all())
      ->setEncodingOptions(JSON_NUMERIC_CHECK);

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
      $hasPermission = $this->userHasPermission(self::LOG_STORE, $request, 'add category');
      if($hasPermission !== true) {
        return $hasPermission;
      }
      $validate = $this->validate($request->all(), Category::$rules);
      if($validate !== true) {
        return $validate;
      }
      $category = new Category();
      $category->name = $request->input('name');
      $category->slug = $request->input('slug');
      $category->save();

      $response = response()
      ->json($category, 201)
      ->setEncodingOptions(JSON_NUMERIC_CHECK);

      $this->registerLog(self::LOG_STORE, 'notice', $request, $response);
      return $response;
    } catch(\Exception $e) {
      $this->registerLog(self::LOG_STORE, 'error', $request, null, $this->parseError($e));
    }
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\JsonResponse
  */
  public function show(Request $request, $id)
  {
    try {
      $hasPermission = $this->userHasPermission(self::LOG_SHOW, $request, 'view category');
      if($hasPermission !== true) {
        return $hasPermission;
      }

      $response = response()
      ->json(Category::findOrFail($id))
      ->setEncodingOptions(JSON_NUMERIC_CHECK);

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
      $hasPermission = $this->userHasPermission(self::LOG_UPDATE, $request, 'update category');
      if($hasPermission !== true) {
        return $hasPermission;
      }
      $rules = Category::$rules;
      $rules['name'] .= ",id,{$id}";
      $rules['slug'] .= ",id,{$id}";
      $validate = $this->validate($request->all(), $rules);
      if($validate !== true) {
        return $validate;
      }
      $category = Category::find($id);
      if($request->has('name')) {
        $category->name = $request->input('name');
      }
      if($request->has('slug')) {
        $category->slug = $request->input('slug');
      }
      $category->save();

      $response = response()
      ->json($category, 201)
      ->setEncodingOptions(JSON_NUMERIC_CHECK);

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
      $hasPermission = $this->userHasPermission(self::LOG_DESTROY, $request, 'list categories');
      if($hasPermission !== true) {
        return $hasPermission;
      }

      if(Category::findOrFail($id)->delete()) {
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
