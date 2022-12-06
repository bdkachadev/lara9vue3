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
        $this->middleware('can:edit_product', ['only' => ['edit', 'update']]);
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
        //
        $categories = Category::get();
        $categoriesData = $categories;

        $categoriesOption = [];
        foreach ($categories as $k => $c) {
            $categoriesOption[$k]["label"] = $c->name;
            $categoriesOption[$k]["value"] = $c->id;
        }
        $brands = Brand::get();
        $brandsData = $brands;

        $brandsOption = [];
        foreach ($brands as $k => $c) {
            $brandsOption[$k]["label"] = $c->name;
            $brandsOption[$k]["value"] = $c->id;
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];

        // $sizes = Size::get();
        // $sizesOption = [];
        // foreach ($sizes as $k => $c) {
        //     $sizesOption[$k]["label"] = $c->name;
        //     $sizesOption[$k]["value"] = $c->id;
        // }
        // $colors = Color::get();
        // $colorsOption = [];
        // foreach ($colors as $k => $c) {
        //     $colorsOption[$k]["label"] = $c->name;
        //     $colorsOption[$k]["value"] = $c->id;
        // }

        $sizesOption = [];
        $colorsOption = [];
        $attributesValueOption = [];
        $attributesOption = [];

        $attributes = Attribute::with("values")->get();
        $attributesData = $attributes;

        foreach ($attributes as $attkey => $attribute) {
            $attributesOption[$attkey]["label"] = $attribute->name;
            $attributesOption[$attkey]["value"] = $attribute->id;
            // foreach ($attribute->values as $attValkey => $attributeValue) {
            //     $attributesValueOption[$attkey][$attValkey]["attribute_id"] = $attributeValue->attribute_id;
            //     $attributesValueOption[$attkey][$attValkey]["label"] = $attribute->name . " - " . $attributeValue->value;
            //     $attributesValueOption[$attkey][$attValkey]["value"] = $attributeValue->id;
            // }
            // if ($attribute->slug == "size") {
            //     foreach ($attribute->values as $k => $a) {
            //         $sizesOption[$k]["label"] = $a->value;
            //         $sizesOption[$k]["value"] = $a->id;
            //     }
            // } elseif ($attribute->slug == "color") {
            //     foreach ($attribute->values as $k => $a) {
            //         $colorsOption[$k]["label"] = $a->value;
            //         $colorsOption[$k]["value"] = $a->id;
            //     }
            // }
        }
        // dd($attributesOption);
        // dd($attributesValueOption);

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


        // dd($categoriesOption);
        // $attributesOption = [["label" => "Size", "value" => "size"], ["label" => "Color", "value" => "color"]];
        return Inertia::render('Product/Create', [
            "categoriesData" => $categoriesData,
            "attributesOption" => $attributesOption,
            "brandsData" => $brandsData,
            "categoriesOption" => $categoriesOption,
            "brandsOption" => $brandsOption,
            "unitsOption" => $unitsOption,
            "colorsOption" => $colorsOption,
            "sizesOption" => $sizesOption,
            "attributesData" => $attributesData,
            "attributesValueData" => $attributesValueData,
            "attributesValueOption" => $attributesValueOption,
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
        // dd($request);
        // dd("l");
        // $productImageInfo = Filepond::field($request->productImage)->moveTo("uploads/products/" . $product->id . "/Image-" . $product->id);

        // dd($request);
        // dd($request);
        // $request->validate([
        //     'name' => 'required|max:100',
        //     'email' => 'required|max:100',
        //     'avatar' => [
        //         'required',
        //         Rule::filepond([
        //             'max:1024',
        //             'image:jpeg,png',
        //         ]),
        //     ],
        //     'gallery' => 'required',
        //     'gallery.*' => [
        //         'required',
        //         Rule::filepond([
        //             'max:1024',
        //             'image:jpeg,png',
        //         ]),
        //     ],
        // ]);

        // Process the files using Filepond package
        // and move them to your preferred storage
        // i.e. "./storage/app/public/avatars"
        // dd($fileInfo) or dd($galleryInfo)
        // $fileInfo = Filepond::field($request->avatar)->moveTo('avatars/avatar-' . auth()->id());






        // dd($request->image);
        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('image', 'public');
        // }

        // dd($request);
        Validator::make($request->all(), [
            'title' => ['required'],
            'taxonomy_attribute' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            // 'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            "category" => ['required'],
            "brand" => ['required'],
            "unit" => ['required'],
            'productImage' => ['required'],
            'productImage.*' => [
                'required',
                Rule::filepond([
                    'max:1024',
                    'image:jpeg,png',
                ]),
            ],


        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }


        // dd($images_arr);
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
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;

        // $product->image = url('/') . "/uploads/" . $image_name;
        $product->save();

        $productImageInfo = Filepond::field($request->productImage)->moveTo("uploads/products/" . $product->id . "/ProductImage-" . $product->id);
        if (!is_null($productImageInfo) && count($productImageInfo) > 0) {
            foreach ($productImageInfo as $Image) {
                $product_image = new  ProductImage();
                $product_image->image = "/storage/" . $Image["location"];
                $product_image->product_id = $product->id;
                $product_image->save();
            }
        }

        // $product->images()->createMany($images_arr);
        // $imageStore = url('/') . "/uploads/products/" . $product->id . "/";

        // $image_name = "";
        // if (!is_null($request->image) && count($request->image) > 0) {
        //     foreach ($request->image as $f) {
        //         if ($request->hasFile('image')) {
        //             $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
        //             $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
        //             $product_image = new  ProductImage();
        //             // $product_image->image = $image_name;
        //             $product_image->image = $imageStore . $image_name;
        //             $product_image->product_id = $product->id;
        //             $product_image->save();
        //         }
        //     }
        //     Product::where("id", $product->id)->update(array("image" => $imageStore . $image_name));
        // }

        dump($request->dynamic);

        if (count($request->dynamic) > 0) {
            foreach ($request->dynamic as $ky => $dynamic) {
                // if ($dynamic->hasFile('image')) {
                //     $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
                //     $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
                //     $product_image = new  ProductImage();
                //     // $product_image->image = $image_name;
                //     $product_image->image = $imageStore . $image_name;
                //     $product_image->product_id = $product->id;
                //     $product_image->save();
                // }
                // Variant::create([
                //     "sku" => $dynamic["sku"],
                //     "product_id" => $product->id,
                //     "size_id" => $dynamic["size"],
                //     "color_id" => $dynamic["color"],
                //     "price" => $dynamic["price"],
                //     "quantity" => $dynamic["quantity"],
                //     // "variant_image" => $dynamic["image"],

                // ]);
                if (!is_null($dynamic['image'])) {
                    $image_name = "VariantImage-" . $product->id . "." . $dynamic["image"]->getClientOriginalExtension();
                    // dd($image_name);
                    // $dynamic->move(public_path('uploads/products/' . $product->id . "/VariantImage-" . $product->id), $image_name);
                    $dynamic["image"]->storeAs('uploads/products/' . $product->id, $image_name);
                }
                $variant = new Variant;

                $variant->sku = strtolower($product->title) . "-" . $dynamic["unit"] . "-" . $dynamic["price"] . "-" . $dynamic["quantity"] . "-sku-" . $ky;
                $variant->product_id = $product->id;
                // $variant->size_id = $dynamic["size"];
                $variant->unit = $dynamic["unit"];
                // $variant->color_id = $dynamic["color"];
                $variant->price = $dynamic["price"];
                $variant->quantity = $dynamic["quantity"];
                $variant->image = "/storage/" . $image_name;
                $variant->variant_attributes = json_encode($dynamic["attribute_value"]);
                $variant->save();
                // foreach ($dynamic["attribute_value"] as $att) {
                //     $variantAtt = new VariantAttribute();
                //     $variantAtt->variant_id = $variant->id;
                //     $variantAtt->attribute_value_id = $att;
                //     $variantAtt->save();
                // }
            }
        }

        if (count($request->taxonomy_attribute) > 0) {
            foreach ($request->taxonomy_attribute as $ky => $ta) {
                $ProductTaxonomy = new ProductTaxonomy;
                $ProductTaxonomy->attribute_id = $ta;
                $ProductTaxonomy->product_id = $product->id;
                $ProductTaxonomy->save();
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
    public function edit(Product $product)
    {
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
        $selectedTaxonomyAttributesOption = [];
        foreach ($product->taxonomy_attributes as $ki => $ta) {
            $selectedTaxonomyAttributesOption[$ki]["label"] = $ta->taxonomy->taxonomy_name . " - " . $ta->attribute_name;
            $selectedTaxonomyAttributesOption[$ki]["value"] = $ta->id;
        }
        $attributesValueOption = [];
        $attributesValueData = AttributeValue::with("attribute")->get();
        foreach ($attributesValueData as $attValkey => $attributeValue) {
            $attributesValueOption[$attValkey]["attribute_id"] = $attributeValue->attribute_id;
            $attributesValueOption[$attValkey]["label"] = $attributeValue->attribute->name . " - " . $attributeValue->value;
            $attributesValueOption[$attValkey]["value"] = $attributeValue->id;
        }

        $dynamicArr = [];
        foreach ($product->variants as $ky => $variant) {
            $dynamicArr[$ky]["price"] = $variant->price;
            $dynamicArr[$ky]["unit"] = $variant->unit;
            $dynamicArr[$ky]["quantity"] = $variant->quantity;
            $dynamicArr[$ky]["variant_id"] = $variant->id;

            $dynamicArr[$ky]["attribute_value"] = json_decode($variant->variant_attributes); //$variant->variant_attributes;
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];
        return Inertia::render('Product/Edit', [
            'product' => $product,
            "categoriesData" => $categoriesData,
            "brandsData" => $brandsData,
            "categoriesOption" => $categoriesOption,
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
    public function update(Request $request, Product $product)
    {
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'digits_between:1,3', "category" => ['required'],
            "brand" => ['required'],
            "unit" => ['required']
        ])->validate();

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;
        $product->save();

        if (count($request->productImage) > 0) {
            ProductImage::where("product_id", $product->id)->delete();
        }
        $productImageInfo = Filepond::field($request->productImage)->moveTo("uploads/products/" . $product->id . "/Image-" . $product->id);
        if (!is_null($productImageInfo) && count($productImageInfo) > 0) {
            foreach ($productImageInfo as $Image) {
                $product_image = new  ProductImage();
                // $product_image->image = $Image["location"];
                $product_image->image = "/storage/" . $Image["location"];
                $product_image->product_id = $product->id;
                $product_image->save();
            }
        }

        // $imageStore = url('/') . "/uploads/products/" . $product->id . "/";

        // $image_name = "";
        // if (count($request->image) > 0) {
        //     foreach ($request->image as $f) {
        //         if ($request->hasFile('image')) {
        //             $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
        //             $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
        //             $product_image = new  ProductImage();
        //             // $product_image->image = $image_name;
        //             $product_image->image = $imageStore . $image_name;
        //             $product_image->product_id = $product->id;
        //             $product_image->save();
        //         }
        //     }
        //     Product::where("id", $product->id)->update(array("image" => $imageStore . $image_name));
        // }
        ProductTaxonomy::where("product_id", $product->id)->delete();
        foreach ($request->taxonomy_attribute as $ky => $ta) {
            $ProductTaxonomy = new ProductTaxonomy;
            $ProductTaxonomy->attribute_id = $ta;
            $ProductTaxonomy->product_id = $product->id;
            $ProductTaxonomy->save();
        }
        // Variant::where("product_id", $product->id)->delete();
        foreach ($request->dynamic as $ky => $dynamic) {
            // if ($dynamic->hasFile('image')) {
            //     $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
            //     $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
            //     $product_image = new  ProductImage();
            //     // $product_image->image = $image_name;
            //     $product_image->image = $imageStore . $image_name;
            //     $product_image->product_id = $product->id;
            //     $product_image->save();
            // }
            // Variant::create([
            //     "sku" => $dynamic["sku"],
            //     "product_id" => $product->id,
            //     "size_id" => $dynamic["size"],
            //     "color_id" => $dynamic["color"],
            //     "price" => $dynamic["price"],
            //     "quantity" => $dynamic["quantity"],
            //     // "variant_image" => $dynamic["image"],

            // ]);
            if (isset($dynamic["image"]) && !is_null($dynamic["image"])) {
                $image_name = "VariantImage-" . $product->id . "." . $dynamic["image"]->getClientOriginalExtension();
                // dd($image_name);
                // $dynamic->move(public_path('uploads/products/' . $product->id . "/VariantImage-" . $product->id), $image_name);
                $dynamic["image"]->storeAs('uploads/products/' . $product->id, $image_name);
            }

            $checkDup = Variant::where("id", $dynamic["variant_id"])->first();
            if ($checkDup) {
                $variant = $checkDup;
            } else {
                $variant = new Variant;
                $variant->image = $image_name; //$dynamic["unit"];
            }
            $variant->sku = strtolower($product->title) . "-" . $dynamic["unit"] . "-" . $dynamic["price"] . "-" . $dynamic["quantity"] . "-sku-" . $ky;
            $variant->product_id = $product->id;
            // $variant->size_id = $dynamic["size"];
            // $variant->color_id = $dynamic["color"];
            $variant->price = $dynamic["price"];
            $variant->unit = $dynamic["unit"];
            $variant->quantity = $dynamic["quantity"];
            $variant->variant_attributes = json_encode($dynamic["attribute_value"]);
            $variant->save();
            // foreach ($dynamic["attribute_value"] as $att) {
            //     $variantAtt = new VariantAttribute();
            //     $variantAtt->variant_id = $variant->id;
            //     $variantAtt->attribute_value_id = $att;
            //     $variantAtt->save();
            // }
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
            $variantAttributesIds = array_merge($variantAttributesIds, json_decode($att));
        }

        // $variant_attributes = VariantAttribute::whereIn("variant_id", $variant_ids)->get();

        // $attribute_value_ids = array_unique(array_column($variant_attributes->toArray(), "attribute_value_id"));
        // dd($attribute_value_ids);
        $attribute_values = AttributeValue::with("attribute")->whereIn("id", $variantAttributesIds)->get();
        $Arr = [];
        foreach ($attribute_values as $ky => $av) {
            // $Arr[$av->attribute->id . "-" . $av->attribute->name][$ky]["value"] = $av->id;
            // $Arr[$av->attribute->id . "-" . $av->attribute->name][$ky]["label"]  = $av->value;
            $Arr[$av->attribute_id][$ky]["value"] = $av->id;
            $Arr[$av->attribute_id][$ky]["label"]  = $av->value;
        }
        return Inertia::render('Client/Product/Detail', ['product' => $product, "Arr" => $Arr]);
    }
}
