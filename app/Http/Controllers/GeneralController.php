<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Variant;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Category;
use Spatie\Permission\Models\Role;



use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    //

    public function onChangeAttribute(Request $request)
    {
        $attributesValueOption = [];
        $attributesValue = AttributeValue::where("attribute_id", $request->attribute_id)->get();

        foreach ($attributesValue as $attkey => $attribute) {
            $attributesValueOption[$attkey]["label"] = $attribute->value;
            $attributesValueOption[$attkey]["value"] = $attribute->id;
        }
        return $attributesValueOption;
    }

    // public function onChangeAttributeValue(Request $request)
    // {
    //     $attributesValueOption = [];
    //     $attributesValue = AttributeValue::where("id", $request->attribute_value_id)->first();

    //     $attribute = DB::table("variant_attributes")->insert(["attribute_id"=>]);
    // }

    public function checkAttributeValue(Request $request)
    {

        $attributesValue = AttributeValue::whereIn("id", $request->attribute_values_id)->get();
        // dump($request->attribute_values_id);
        $attribute_value_ids = array_unique(array_column($attributesValue->toArray(), "attribute_id"));
        // dd($attribute_value_ids);
        if (count($request->attribute_values_id) !== count($attribute_value_ids)) {
            return "not_match";
        }
    }

    public function onChangeVariant(Request $request)
    {
        $variant = null;
        $selectedAttribute = array_values($request->selectedAttribute);
        $variants = Variant::where("product_id", $request->product_id)->get();
        foreach ($variants as $ky => $variant) {
            $variant_attributes = array_diff(json_decode($variant->variant_attributes, true));
            if (array_diff($variant_attributes, $selectedAttribute) == array_diff($selectedAttribute, $variant_attributes)) {
                return $variant;
            }
        }
    }

    public function getAttributeName(Request $request)
    {
        return Attribute::find($request->attribute_id);
    }

    public function getSubCatObject(Request $request)
    {
        return Category::with("parent_category", "sub_categories")->where("id", $request->category_id)->first();
    }
    public function getSubBrandObject(Request $request)
    {
        return Brand::with("parent_brand", "sub_brands")->where("id", $request->brand_id)->first();
    }
    public function getPermissionsList(Request $request)
    {
        $f = Role::with("permissions")->where("name", auth()->user()->roles[0]->name)->first();
        // dd($f->permissions->toArray());
        return  $f->permissions->toArray();

        // return  array_column($f->permissions->toArray(), "name");
    }
}
