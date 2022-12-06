<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Variant;

use Illuminate\Support\Facades\Redirect;
use DB;

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
        $variant = Variant::with("image")->where("variant_attributes", json_encode(array_values($request->selectedAttribute)))->where("product_id", $request->product_id)->first();
        if ($variant) {
            return $variant;
        }
    }
}
