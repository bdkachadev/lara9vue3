<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Attributes\Size;
use App\Models\Attributes\Color;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\TaxonomyAttribute;
use App\Models\CustomTaxonomy;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\ProductTaxonomy;
use App\Models\VariantAttribute;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_product', ['only' => ['index', 'show']]);
        $this->middleware('can:add_product', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_product', ['only' => ['edit', 'updateProduct']]);
        $this->middleware('can:delete_product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with("images")->latest()->paginate(10);
        $categories = Category::get();

        return Inertia::render('Product/Index', ["categories" => $categories, 'products' => $products, 'can' => [
            'show' => Auth::user()->can('show_product'),
            'add' => Auth::user()->can('add_product'),
            'delete' => Auth::user()->can('delete_product'),
            'edit' => Auth::user()->can('edit_product'),

        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();

        $categoriesOption = [];
        foreach ($categories as $k => $c) {
            $categoriesOption[$k]["label"] = $c->name;
            $categoriesOption[$k]["value"] = $c->id;
        }
        $brands = Brand::get();

        $brandsOption = [];
        foreach ($brands as $k => $c) {
            $brandsOption[$k]["label"] = $c->name;
            $brandsOption[$k]["value"] = $c->id;
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];

        $attributesValueOption = [];
        $attributesOption = [];

        $attributes = Attribute::with("values")->get();

        foreach ($attributes as $attkey => $attribute) {
            $attributesOption[$attkey]["label"] = $attribute->name;
            $attributesOption[$attkey]["value"] = $attribute->id;
        }

        $attributesValueData = AttributeValue::with("attribute")->get();
        foreach ($attributesValueData as $attValkey => $attributeValue) {
            $attributesValueOption[$attValkey]["attribute_id"] = $attributeValue->attribute_id;
            $attributesValueOption[$attValkey]["label"] = $attributeValue->attribute->name . " - " . $attributeValue->value;
            $attributesValueOption[$attValkey]["value"] = $attributeValue->id;
        }

        $taxonomyAttributesOption = [];
        $taxonomy_attributes = TaxonomyAttribute::get();
        foreach ($taxonomy_attributes as $ki => $ta) {
            $taxonomyAttributesOption[$ki]["label"] = $ta->taxonomy->taxonomy_name . " - " . $ta->attribute_name;
            $taxonomyAttributesOption[$ki]["value"] = $ta->id;
        }

        $tagsOption = [];
        $tags = Tag::get();
        foreach ($tags as $ki => $tag) {
            $tagsOption[$ki]["label"] = $tag->name;
            $tagsOption[$ki]["value"] = $tag->id;
        }


        // dd($categoriesOption);
        // $attributesOption = [["label" => "Size", "value" => "size"], ["label" => "Color", "value" => "color"]];
        return Inertia::render('Product/Create', [
            "attributesOption" => $attributesOption,
            "categoriesOption" => $categoriesOption,
            "brandsOption" => $brandsOption,
            "unitsOption" => $unitsOption,
            "attributesValueData" => $attributesValueData,
            "attributesValueOption" => $attributesValueOption,
            "tagsOption" => $tagsOption,
            "taxonomyAttributesOption" => $taxonomyAttributesOption
        ]);
        // return Inertia::render('Product/Create', ["categoriesData" => $categoriesData, "brandsData" => $brandsData, "categoriesOption" => $categoriesOption, "brandsOption" => $brandsOption, "unitsOption" => $unitsOption, "colorsOption" => $colorsOption, "sizesOption" => $sizesOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            "categories" => ['required'],
            "tags" => ['required'],
            "taxonomy_attributes" => ["required"],
            "brands" => ['required'],
            "unit" => ['required'],
            'productImage' => ['required'],
            'productImage.*' => [
                'required',
                Rule::filepond([
                    // 'max:1024',
                    'image:jpeg,png',
                ]),
            ],
        ])->validate();

        $product = Product::where("title", $request->title)->first();
        if ($product) {
            return Redirect::back()->with('error', 'Product Already Exist !!!');
        }

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->unit = $request->unit;
        $product->save();

        $product->categories()->attach($request->categories);
        $product->brands()->attach($request->brands);
        $product->tags()->attach($request->tags);
        $product->taxonomy_attributes()->attach($request->taxonomy_attributes);

        $productImageInfo = Filepond::field($request->productImage)->moveTo("uploads/products/" . $product->id . "/ProductImage-" . $product->id);
        if (!is_null($productImageInfo) && count($productImageInfo) > 0) {
            foreach ($productImageInfo as $Image) {
                $product_image = new  ProductImage();
                $product_image->image = "/storage/" . $Image["location"];
                $product_image->product_id = $product->id;
                $product_image->save();
            }
        }

        if (count($request->dynamic) > 0 && !is_null($request->dynamic[0]["unit"])) {
            foreach ($request->dynamic as $ky => $dynamic) {
                if (isset($dynamic['image']) && !is_null($dynamic['image'])) {
                    $vimage_name = "VariantImage-" . Str::random(4) . "-" . $product->id . "." . $dynamic["image"]->getClientOriginalExtension();
                    $vimage_path = "/storage/uploads/products/" . $product->id . "/" . $vimage_name;
                    $dynamic["image"]->move('storage/uploads/products/' . $product->id, $vimage_name);

                    // $request->file('photo')->move($destinationPath, $fileName);

                } else {
                    $vimage_path = null;
                }
                foreach ($dynamic["attribute_value"] as $k => $c) {
                    $dynamic["attribute_value"][$k] = (int) $c;
                }

                $variant = new Variant;
                $variant->sku = strtolower($product->title) . "-" . $dynamic["unit"] . "-" . $dynamic["price"] . "-" . $dynamic["quantity"] . "-sku-" . $ky;
                $variant->product_id = $product->id;
                $variant->unit = $dynamic["unit"];
                $variant->price = $dynamic["price"];
                $variant->quantity = $dynamic["quantity"];
                $variant->image = $vimage_path;
                $variant->variant_attributes = json_encode($dynamic["attribute_value"]);
                $variant->save();
            }
        }

        return Redirect::route('manage.products.index')->with('success', 'Product Created Successfully!!!');
    }

    // public function store(Request $request)
    // {
    //     // if ($request->hasFile('image')) {
    //     //     $image_path = $request->file('image')->store('image', 'public');
    //     // }

    //     $validator =  Validator::make($request->all(), [
    //         'title' => ['required'],
    //         'description' => ['required'],
    //         'price' => ['required'],
    //         'quantity' => ['required'],
    //         'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'

    //     ])->validate();

    //     // if ($validator->fails()) {
    //     //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
    //     // }

    //     $image_name = "";
    //     if ($request->hasFile('image')) {
    //         $image_name = time() . '_' . str_replace(" ", "_", $request->image->getClientOriginalName());
    //         $request->file('image')->move(public_path('uploads'), $image_name);
    //     }
    //     $product = Product::where("title", $request->title)->first();
    //     if ($product) {
    //         return Redirect::back()->with('error', 'Product Already Exist !!!');
    //     }
    //     $product = new Product;
    //     $product->title = $request->title;
    //     $product->description = $request->description;
    //     $product->price = $request->price;
    //     $product->quantity = $request->quantity;
    //     $product->description = $request->description;
    //     $product->image = url('/') . "/uploads/" . $image_name;
    //     $product->save();
    //     return Redirect::route('manage.products.index')->with('success', 'Product Created Successfully!!!');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Product::with(["brands", "categories", "tags", "taxonomy_attributes"])->find($id);
        $categories = Category::get();
        $categoriesData = Category::latest()->paginate(5);

        $categoriesOption = [];
        foreach ($categories as $k => $c) {
            $categoriesOption[$k]["label"] = $c->name;
            $categoriesOption[$k]["value"] = $c->id;
        }
        $brands = Brand::get();
        $brandsData = Brand::latest()->paginate(5);

        $brandsOption = [];
        foreach ($brands as $k => $c) {
            $brandsOption[$k]["label"] = $c->name;
            $brandsOption[$k]["value"] = $c->id;
        }
        $taxonomyAttributesOption = [];
        $taxonomy_attributes = TaxonomyAttribute::get();
        foreach ($taxonomy_attributes as $ki => $ta) {
            $taxonomyAttributesOption[$ki]["label"] = $ta->taxonomy->taxonomy_name . " - " . $ta->attribute_name;
            $taxonomyAttributesOption[$ki]["value"] = $ta->id;
        }

        $attributesValueOption = [];
        $attributesValueData = AttributeValue::with("attribute")->get();
        foreach ($attributesValueData as $attValkey => $attributeValue) {
            $attributesValueOption[$attValkey]["attribute_id"] = $attributeValue->attribute_id;
            $attributesValueOption[$attValkey]["label"] = $attributeValue->attribute->name . " - " . $attributeValue->value;
            $attributesValueOption[$attValkey]["value"] = $attributeValue->id;
        }
        $tagsOption = [];
        $tags = Tag::get();
        foreach ($tags as $ki => $tag) {
            $tagsOption[$ki]["label"] = $tag->name;
            $tagsOption[$ki]["value"] = $tag->id;
        }
        $dynamicArr = [];
        foreach ($product->variants as $ky => $variant) {
            $dynamicArr[$ky]["price"] = $variant->price;
            $dynamicArr[$ky]["unit"] = $variant->unit;
            $dynamicArr[$ky]["quantity"] = $variant->quantity;
            $dynamicArr[$ky]["variant_id"] = $variant->id;
            $dynamicArr[$ky]["attribute_value"] = json_decode($variant->variant_attributes); //$variant->variant_attributes;
            $dynamicArr[$ky]["variantImage"] = "";
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];
        return Inertia::render('Product/Edit', [
            'product' => $product,
            "categoriesData" => $categoriesData,
            "brandsData" => $brandsData,
            "categoriesOption" => $categoriesOption,
            "tagsOption" => $tagsOption,
            "brandsOption" => $brandsOption,
            "unitsOption" => $unitsOption,
            "taxonomyAttributesOption" => $taxonomyAttributesOption,
            "attributesValueOption" => $attributesValueOption,
            "dynamicArr" => $dynamicArr
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, Product $product)
    {
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required', "numeric"],
            'quantity' => ['required'],
            "categories" => ['required'],
            "tags" => ['required'],
            "taxonomy_attributes" => ["required"],
            "brands" => ['required'],
            "unit" => ['required'],
            // 'productImage' => ['required'],
            // 'productImage.*' => [
            //     'required',
            //     Rule::filepond([
            //         'max:1024',
            //         'image:jpeg,png',
            //     ]),
            // ],
        ])->validate();
        $product = Product::with("categories", "brands", "tags", "taxonomy_attributes")->where("id", $request->id)->first();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->unit = $request->unit;
        $product->save();

        $product->categories()->sync($request->categories);
        $product->brands()->sync($request->brands);
        $product->tags()->sync($request->tags);
        $product->taxonomy_attributes()->sync($request->taxonomy_attributes);

        if ($request->productImage && count($request->productImage) > 0) {
            ProductImage::where("product_id", $product->id)->delete();
        }
        $productImageInfo = Filepond::field($request->productImage)->moveTo("uploads/products/" . $product->id . "/Image-" . $product->id);
        if (!is_null($productImageInfo) && count($productImageInfo) > 0) {
            foreach ($productImageInfo as $Image) {
                $product_image = new  ProductImage();
                $product_image->image = "/storage/" . $Image["location"];
                $product_image->product_id = $product->id;
                $product_image->save();
            }
        }


        // Variant::where("product_id", $product->id)->delete();
        Variant::whereNotIn("id", array_column($request->dynamic, "variant_id"))->where("product_id", $product->id)->delete();
        // if (count($request->dynamic) > 0 && !is_null($request->dynamic[0]["unit"])) {

        //     foreach ($request->dynamic as $ky => $dynamic) {

        //         if (Variant::where("id", $dynamic["variant_id"])->first()) {
        //             $variant = Variant::where("id", $dynamic["variant_id"])->first();
        //         } else {
        //             $variant = new Variant;
        //         }
        //         if (!is_null($dynamic['image'])) {
        //             $image_name = "/storage/VariantImage-" . $product->id . "." . $dynamic["image"]->getClientOriginalExtension();
        //             $dynamic["image"]->storeAs('uploads/products/' . $product->id, $image_name);
        //             $variant->image = $image_name;
        //         }
        //         $variant->sku = strtolower($product->title) . "-" . $dynamic["unit"] . "-" . $dynamic["price"] . "-" . $dynamic["quantity"] . "-sku-" . $ky;
        //         $variant->product_id = $product->id;
        //         $variant->unit = $dynamic["unit"];
        //         $variant->price = $dynamic["price"];
        //         $variant->quantity = $dynamic["quantity"];
        //         $variant->variant_attributes = json_encode($dynamic["attribute_value"]);
        //         $variant->save();
        //     }
        // }

        if (count($request->dynamic) > 0 && !is_null($request->dynamic[0]["unit"])) {
            foreach ($request->dynamic as $ky => $dynamic) {
                if (isset($dynamic["variant_id"]) && Variant::where("id", $dynamic["variant_id"])->where("product_id", $product->id)->first()) {
                    $variant = Variant::where("id", $dynamic["variant_id"])->first();
                } else {
                    $variant = new Variant;
                }
                if (isset($dynamic['image']) && !is_null($dynamic['image'])) {
                    $vimage_name = "VariantImage-" . Str::random(4) . "-" . $product->id . "." . $dynamic["image"]->getClientOriginalExtension();
                    $vimage_path = "/storage/uploads/products/" . $product->id . "/" . $vimage_name;
                    $dynamic["image"]->move('storage/uploads/products/' . $product->id, $vimage_name);
                    $variant->image = $vimage_path;

                    // $request->file('photo')->move($destinationPath, $fileName);

                }
                $variant->sku = strtolower($product->title) . "-" . $dynamic["unit"] . "-" . $dynamic["price"] . "-" . $dynamic["quantity"] . "-sku-" . $ky;
                $variant->product_id = $product->id;
                $variant->unit = $dynamic["unit"];
                $variant->price = $dynamic["price"];
                $variant->quantity = $dynamic["quantity"];
                $variant->variant_attributes = json_encode($dynamic["attribute_value"]);
                $variant->save();
            }
        }

        return Redirect::route('manage.products.index')->with('success', 'Product Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return Redirect::back()->with("success", "Product Deleted Successfully");
    }

    public function detail($id)
    {
        $product = Product::with("images", "variants")->find($id);

        // foreach ($product->variants as $variant) {
        //     // dd($variant);
        //     $attribureIds[] = $variant->attribute_id;
        // }
        // // dd($attribureIds);
        // $sizesOption = [];
        // $colorsOption = [];
        // $attributesOption = [];
        // $attributesValue = AttributeValue::with("values")->whereIn("id", $attribureIds)->get();
        // $attributesData = $attributes;

        // // foreach ($attributes as $k => $attribute) {
        // // $attributesOption[$k]["label"] = $attribute->name;
        // // $attributesOption[$k]["value"] = $attribute->id;
        // // if ($attribute->slug == "size") {
        // foreach ($attributesValue as $k => $v) {
        //     $sizesOption[$k]["label"] = $a->value;
        //     $sizesOption[$k]["value"] = $a->id;
        //     // }
        //     // } elseif ($attribute->slug == "color") {
        //     foreach ($attributesValue as $k => $v) {
        //         $colorsOption[$k]["label"] = $a->value;
        //         $colorsOption[$k]["value"] = $a->id;
        //     }
        //     // }
        //     // }
        //     $attributesValueData = AttributeValue::get();
        // }

        $variant_attributes = array_column($product->variants->toArray(), "variant_attributes");
        $variantAttributesIds = [];
        foreach ($variant_attributes as  $ki => $att) {
            $variantAttributesIds = array_unique(array_merge($variantAttributesIds, json_decode($att)));
        }

        // $variant_attributes = VariantAttribute::whereIn("variant_id", $variant_ids)->get();

        // $attribute_value_ids = array_unique(array_column($variant_attributes->toArray(), "attribute_value_id"));
        // dd($attribute_value_ids);
        // dd($variantAttributesIds);
        $attribute_values = AttributeValue::with("attribute")->whereIn("id", $variantAttributesIds)->get();

        $Arr = [];
        // dd($attribute_values);
        foreach ($attribute_values as $ky => $av) {
            // $Arr[$av->attribute->id . "-" . $av->attribute->name][$ky]["value"] = $av->id;
            // $Arr[$av->attribute->id . "-" . $av->attribute->name][$ky]["label"]  = $av->value;
            $Arr[$av->attribute_id . "-" . $av->attribute->name][$ky]["value"] = $av->id;
            $Arr[$av->attribute_id . "-" . $av->attribute->name][$ky]["label"]  = $av->value;
        }
        return Inertia::render('Client/Product/Detail', ['product' => $product, "availVariant" => $Arr, "availVariantCount" => count($Arr)]);
    }
}
