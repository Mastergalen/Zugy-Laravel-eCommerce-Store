<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Language;
use App\Product;
use App\Services\CreateOrUpdateProduct;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::with('translations')->paginate(30);
        return view('admin.pages.catalogue.index')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(Gate::denies('create', new Product())) {
            abort(403);
        }

        $languages = Language::all();
        $attributes = Attribute::all();

        return view('admin.pages.catalogue.create')->with([
            'product' => new Product(),
            'languages' => $languages,
            'attributes' => $attributes,
            'translations' => null,
            'category' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, CreateOrUpdateProduct $service)
    {
        if(Gate::denies('create', new Product())) {
            return redirect()->back()->withErrors('You do not have permission to create new products');
        }

        return $service->handler($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = \App\Product::with(['translations', 'categories', 'attributes', 'images'])->find($id);
        $languages = Language::all();
        $attributes = Attribute::all();
        $category = $product->categories()->first();

        $translations = $product->translations->keyBy('locale');

        $productAttributes = $product->attributes()->get()->keyBy('id');

        //dd($productAttributes->toArray());

        return view('admin.pages.catalogue.edit')->with([
            'product' => $product,
            'languages' => $languages,
            'attributes' => $attributes,
            'productAttributes' => $productAttributes,
            'translations' => $translations,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, CreateOrUpdateProduct $service, $productId)
    {
        return $service->handler($request, $productId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
