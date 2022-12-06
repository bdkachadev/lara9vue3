<template>
  <Head title="products" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">products</h2>
    </template>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-5 text-center">
            <div v-if="$page.props.flash.success">
              <FlashMessage
                type="success"
                :message="$page.props.flash.success"
                :show="true"
              ></FlashMessage>
            </div>
            <div v-if="$page.props.flash.error">
              <FlashMessage
                type="error"
                :show="true"
                :message="$page.props.flash.error"
              ></FlashMessage>
            </div>
            <div v-if="$page.props.flash.warning">
              <FlashMessage
                :show="true"
                type="warning"
                :message="$page.props.flash.warning"
              ></FlashMessage>
            </div>
          </div>
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Edit pro</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formproduct"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
              @submit.prevent="updateProduct"
            >
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <input v-model="productForm.id" type="hidden" value="" />
                  <div className="mb-4">
                    <BreezeLabel for="title" value="Title" />
                    <BreezeInput
                      id="title"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.title"
                      autofocus
                    />

                    <span className="text-red-600" v-if="productForm.errors.title">
                      {{ productForm.errors.title }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.description"
                      autofocus
                    />

                    <span className="text-red-600" v-if="productForm.errors.description">
                      {{ productForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="price" value="Price" />
                    <BreezeInput
                      id="price"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.price"
                      autofocus
                    />

                    <span className="text-red-600" v-if="productForm.errors.price">
                      {{ productForm.errors.price }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="quantity" value="Quantity" />
                    <BreezeInput
                      id="quantity"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.quantity"
                      autofocus
                    />

                    <span className="text-red-600" v-if="productForm.errors.quantity">
                      {{ productForm.errors.quantity }}
                    </span>
                  </div>
                </div>
                <div>
                  <div className="mb-4">
                    <BreezeLabel for="category" value="Category" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.category"
                      :options="categoriesOption"
                    />

                    <span className="text-red-600" v-if="productForm.errors.category">
                      {{ productForm.errors.category }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="brand" value="Brand" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.brand"
                      :options="brandsOption"
                    />

                    <span className="text-red-600" v-if="productForm.errors.brand">
                      {{ productForm.errors.brand }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="unit" value="Unit" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.unit"
                      :options="unitsOption"
                    />

                    <span className="text-red-600" v-if="productForm.errors.unit">
                      {{ productForm.errors.unit }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="image" value="Image" />
                    <!-- <BreezeInput
                      id="image"
                      type="file"
                      @input="productForm.image = $event.target.files"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.image"
                      autofocus
                      multiple
                    /> -->
                    <FilePond
                      name="productImage"
                      ref="filepondProductImageInput"
                      class-name="my-pond"
                      allow-multiple="true"
                      accepted-file-types="image/jpeg, image/png"
                      @init="handleFilePondInit"
                      @processfile="handleFilePondProductImageProcess"
                      @removefile="handleFilePondProductImageRemoveFile"
                    />
                    <!-- <span className="text-red-600" v-if="productForm.errors.image">
                      {{ productForm.errors.image }}
                    </span> -->
                  </div>
                </div>
              </div>
              <div className="mb-4">
                <BreezeLabel for="taxonomy_attribute" value="Taxonomy Attribute" />
                <Multiselect
                  id="taxonomy_attribute"
                  v-model="productForm.taxonomy_attribute"
                  :close-on-select="false"
                  :searchable="true"
                  :create-option="true"
                  :options="taxonomyAttributesOption"
                  mode="tags"
                />

                <span
                  className="text-red-600"
                  v-if="productForm.errors.taxonomy_attribute"
                >
                  {{ productForm.errors.taxonomy_attribute }}
                </span>
              </div>
              <div
                class="grid grid-cols-10 gap-1"
                v-for="(item, index) in productForm.dynamic"
                :key="item"
              >
                <!-- <input v-model="item.attrArr" type="hidden" value="" /> -->

                <!-- <div class="col-span-2">
                  <div className="">
                    <BreezeLabel for="sku" value="Sku" />
                    <BreezeInput id="sku" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="item.sku" autofocus />
                  </div>
                </div> -->
                <!-- <div>
                  <div className="">
                    <BreezeLabel for="attribute" value="Attribute" />
                     <Multiselect v-model="item.attribute" :close-on-select="false" :searchable="true" :create-option="true" :options="attributesOption" @change="onChangeAttribute($event)" mode="tags" /> 
                  </div>
                </div>  -->
                <div className="col-span-4">
                  <div className="">
                    <BreezeLabel for="attribute_value" value="Attribute Value" />
                    <Multiselect
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.dynamic[index].attribute_value"
                      :options="attributesValueOption"
                      @click="
                        checkAttributeValue(
                          index,
                          productForm.dynamic[index].attribute_value
                        )
                      "
                      mode="tags"
                    />
                  </div>
                </div>
                <!-- <div>
                  <div className="mb-4">
                    <BreezeLabel for="size" value="Size" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="item.size"
                      :options="sizesOption"
                    />
                  </div>
                </div> -->
                <!-- <div>
                  <div className="mb-4">
                    <BreezeLabel for="color" value="Color" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="item.color"
                      :options="colorsOption"
                    />
                  </div>
                </div> -->
                <div>
                  <div className="">
                    <BreezeLabel for="price" value="Price" />
                    <BreezeInput
                      id="price"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.dynamic[index].price"
                      autofocus
                    />
                  </div>
                </div>
                <div className="">
                  <BreezeLabel for="unit" value="unit" />
                  <Multiselect
                    :close-on-select="true"
                    :searchable="true"
                    :create-option="true"
                    v-model="productForm.dynamic[index].unit"
                    :options="unitsOption"
                  />

                  <span className="text-red-600" v-if="productForm.errors.category">
                    {{ productForm.errors.category }}
                  </span>
                </div>
                <div className="">
                  <BreezeLabel for="quantity" value="quantity" />
                  <BreezeInput
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="quantity"
                    type="text"
                    v-model="productForm.dynamic[index].quantity"
                    :options="quantitysOption"
                  />

                  <span className="text-red-600" v-if="productForm.errors.quantity">
                    {{ productForm.errors.quantity }}
                  </span>
                </div>
                <!-- <div>
                  <div className="">
                    <BreezeLabel for="image" value="Image" />
                    <BreezeInput
                      id="image"
                      type="file"
                      @change="imageChanged(index, $event)"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      autofocus
                    />
                  </div>
                </div> -->
                <!--     <div class="col-span-2">
                  <div className="mb-4">
                    <BreezeLabel for="image" value="Image" />
                    <BreezeInput
                      id="image"
                      type="file"
                      @input="item.image = $event.target.files[0]"
                      className="shadow appearance-none border rounded w-full px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline w-full cursor-pointer rounded-lg border  text-gray-600 file:mr-5 file:rounded-lg file:border-none file:bg-indigo-600 file:p-2 file:text-white hover:file:cursor-pointer hover:file:bg-indigo-500"
                      autofocus
                    /> 
                    <FilePond
                      name="variantImage"
                      ref="filepondProductVariantImageInput"
                      class-name="my-pond"
                      allow-multiple="false"
                      accepted-file-types="image/jpeg, image/png"
                      @init="handleFilePondInit"
                      @processfile="handleFilePondProductVariantImageProcess"
                      @removefile="handleFilePondProductVariantImageRemoveFile"
                    />
                  </div>
                </div> --->
                <div>
                  <div className="">
                    <a
                      @click="addDynamic(index)"
                      className="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded"
                    >
                      Add
                    </a>
                    <a
                      @click="removeDynamic(index)"
                      className="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-500 text-white rounded"
                    >
                      Remove
                    </a>
                  </div>
                </div>
                <div class="col-span-6">
                  <div class="p-2">
                    <!-- <span
                      v-if="item.attrArr.length > 0"
                      v-for="at in item.attrArr"
                      className="p-1 bg-indigo-500 rounded ml-1 text-white"
                      >{{ at.value }} <span className="text-red-700"> X </span></span
                    > -->
                  </div>
                </div>
              </div>
              <div className="flex items-center justify-between">
                <button
                  className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                  type="submit"
                >
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head, Inertia } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { reactive, ref, onMounted } from "vue";

// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";

// Import filepond plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import filepond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const filepondProductImageInput = ref(null); // Reference the input to clear the files later

const props = defineProps({
  product: Object,
  categoriesData: Object,
  categoriesOption: Object,
  brandsData: Object,
  brandsOption: Object,
  unitsOption: Object,
  taxonomyAttributesOption: Object,
  attributesValueOption: Object,
  csrf_token: String,
  dynamicArr: Object,
});
// dynamic

const addDynamic = (index) => {
  if (
    productForm.dynamic[index].attribute_value != "" &&
    productForm.dynamic[index].price != "" &&
    productForm.dynamic[index].quantity != ""
  ) {
    productForm.dynamic.push({
      // sku: "",
      attribute_value: [],
      price: "",
      quantity: "",
      image: "",
      // size: "",
      // color: "",
    });
  } else {
    Swal.fire({
      title: "Warning!",
      text: "Please Select Attribute Value, Price and Quantity",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ok",
    });
  }
};

const removeDynamic = (index) => {
  // if (productForm.dynamic.length > 1) {
  productForm.dynamic.splice(index, 1);
  // }
};
const productForm = useForm({
  description: props.product.description,
  id: props.product.id,
  price: props.product.price,
  quantity: props.product.quantity,
  title: props.product.title,
  productImage: [],
  category: props.product.category_id,
  brand: props.product.brand_id,
  unit: props.product.unit,
  taxonomy_attribute: props.product.taxonomy_attributes.map((i) => i.id),

  // dynamic: reactive([
  //   {
  //     // sku: "",
  //     price: "",
  //     quantity: "",
  //     // size: "",
  //     // color: "",
  //     attribute_value: [],
  //     // attribute: [],
  //     // attrArr: [],
  //     // variantImage: null,
  //   },
  // ]),
  dynamic: props.dynamicArr,
});

const updateProduct = (event) => {
  // productForm.put(route("manage.products.update", productForm.id), {
  //   onFinish: () => event.target.reset(),
  // });

  productForm
    .transform((data) => {
      // console.log(data.productImage.map((item) => item.serverId));
      // alert(data.productImage.map((item) => item.serverId));
      return {
        ...data,
        productImage: data.productImage.map((item) => item.serverId), // Pluck only the serverIds
      };
    })
    .put(
      route("manage.products.update", productForm.id, { preserveState: true }),

      {
        onSuccess: () => {
          filepondProductImageInput.value.removeFiles(), event.target.reset();
        },
      }
    );
};

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

// Set global options on filepond init
const handleFilePondInit = () => {
  setOptions({
    credits: false,
    server: {
      url: "/filepond",
      headers: {
        "X-CSRF-TOKEN": props.csrf_token,
      },
    },
  });
};
// Set the server id from response
const handleFilePondProductImageProcess = (error, file) => {
  console.log(file.id);
  console.warn(file.serverId);
  productForm.productImage.push({
    id: file.id,
    serverId: file.serverId,
  });
};
// Remove the server id on file remove
const handleFilePondProductImageRemoveFile = (error, file) => {
  productForm.productImage = productForm.productImage.filter(
    (item) => item.id !== file.id
  );
};

const checkAttributeValue = (index, event) => {
  var attribute_values_id = JSON.parse(JSON.stringify(event));
  console.log(attribute_values_id);
  if (attribute_values_id.length > 1) {
    console.log(index);
    axios
      .post(route("manage.general.checkAttributeValue"), {
        attribute_values_id: attribute_values_id,
      })
      .then((res) => {
        if (res.data == "not_match") {
          Swal.fire({
            title: "Warning!",
            text:
              "Please Select only One AttributeValue Per One Attribute (i.e Attribute : Color , AttributeValue : Blue)",
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ok",
          });

          attribute_values_id.pop();
          console.log(attribute_values_id);

          productForm.dynamic[index].attribute_value = attribute_values_id;
        }
      });
  }
};
const imageChanged = (index, e) => {
  // console.log(e);
  // console.log(index);
  // productForm.dynamic[index].image = e.target.files[0];
  // var fileReader = new FileReader();
  // fileReader.readAsDataURL(e.target.files[0]);
  // fileReader.onload = (e) => {
  //   console.log(e);
  //   productForm.dynamic[index].image = e.target.result;
  // };
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
