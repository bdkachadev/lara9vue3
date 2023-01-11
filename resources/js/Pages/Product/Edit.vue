<template>
  <Head title="products" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">products</h2>
    </template>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <!-- <div class="p-5 text-center"> -->
          <div>
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
              <p className="float-left">Edit Product</p>
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700   leading-tight focus:outline-none focus:shadow-outline"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700   leading-tight focus:outline-none focus:shadow-outline"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700   leading-tight focus:outline-none focus:shadow-outline"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700   leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.quantity"
                      autofocus
                    />

                    <span className="text-red-600" v-if="productForm.errors.quantity">
                      {{ productForm.errors.quantity }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <label
                      class="block font-medium text-sm text-gray-700"
                      for="taxonomy_attributes"
                    >
                      <span
                        >Taxonomy Attribute
                        <!-- <Link
                          :href="route('manage.taxonomyAttribute.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        > -->
                      </span>
                    </label>
                    <Multiselect
                      id="taxonomy_attributes"
                      v-model="productForm.taxonomy_attributes"
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      :options="taxonomyAttributesOption"
                      mode="tags"
                    />

                    <span
                      className="text-red-600"
                      v-if="productForm.errors.taxonomy_attributes"
                    >
                      {{ productForm.errors.taxonomy_attributes }}
                    </span>
                  </div>
                </div>
                <div>
                  <div className="mb-4">
                    <label
                      class="block font-medium text-sm text-gray-700"
                      for="categories"
                    >
                      <span
                        >Category
                        <!-- <Link
                          :href="route('manage.categories.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        > -->
                      </span>
                    </label>
                    <Multiselect
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.categories"
                      :options="categoriesOption"
                      mode="tags"
                    />

                    <span className="text-red-600" v-if="productForm.errors.categories">
                      {{ productForm.errors.categories }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <label class="block font-medium text-sm text-gray-700" for="brands">
                      <span
                        >Brand
                        <!-- <Link
                          :href="route('manage.brands.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        > -->
                      </span>
                    </label>
                    <Multiselect
                      :close-on-select="false"
                      mode="tags"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.brands"
                      :options="brandsOption"
                    />

                    <span className="text-red-600" v-if="productForm.errors.brands">
                      {{ productForm.errors.brands }}
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
                    <label class="block font-medium text-sm text-gray-700" for="brand">
                      <span
                        >Tag
                        <!-- <Link
                          :href="route('manage.tags.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        > -->
                      </span>
                    </label>
                    <Multiselect
                      id="tag"
                      v-model="productForm.tags"
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      :options="tagsOption"
                      mode="tags"
                      placeholder="-- Tag --"
                    />

                    <span className="text-red-600" v-if="productForm.errors.tags">
                      {{ productForm.errors.tags }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="image" value="Image" />
                    <!-- <BreezeInput
                      id="image"
                      type="file"
                      @input="productForm.image = $event.target.files"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700   leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.image"
                      autofocus
                      multiple
                    /> -->
                    <FilePond
                      name="productImage"
                      ref="filepondProductImageInput"
                      class-name="my-pond"
                      allow-multiple="true"
                      accepted-file-types="image/*, image/png"
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
                    <label
                      class="block font-medium text-sm text-gray-700"
                      for="attaribute_value"
                    >
                      <span
                        >Attribute Value
                        <!-- <Link
                          :href="route('manage.attributesValue.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        > -->
                      </span>
                    </label>
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

                  <span className="text-red-600" v-if="productForm.errors.unit">
                    {{ productForm.errors.unit }}
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
                <div className="col-span-2">
                  <BreezeLabel for="image" value="image" />
                  <input
                    type="file"
                    @change="onFileChange(index, $event)"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  />
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
                      className="inline-block py-0.5 cursor-pointer px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded"
                    >
                      Add
                    </a>
                    <a
                      @click="removeDynamic(index)"
                      className="inline-block py-0.5 cursor-pointer px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-500 text-white rounded"
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
              <div v-if="productForm.dynamic.length == 0">
                <a
                  @click="addDynamiwc"
                  className="cursor-pointer inline-block py-0.5 m-4 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded"
                >
                  Add Variant
                </a>
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
import { Link, useForm, Head, Inertia } from "@inertiajs/inertia-vue3";
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
  tagsOption: Object,
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

const onFileChange = (index, e) => {
  productForm.dynamic[index].image = e.target.files[0];
};

const addDynamiwc = () => {
  productForm.dynamic.push({
    // sku: "",
    attribute_value: [],
    price: "",
    quantity: "",
    image: "",
    // size: "",
    // color: "",
  });
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
  categories: props.product.categories.map((category) => category.id),
  brands: props.product.brands.map((brand) => brand.id),
  unit: props.product.unit,
  taxonomy_attributes: props.product.taxonomy_attributes.map((attribute) => attribute.id),
  tags: props.product.tags.map((tag) => tag.id),
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
  event.preventDefault();

  // productForm.put(route("manage.products.update", productForm.id), {
  //   onFinish: () => event.target.reset(),
  // });

  productForm
    // .transform((data) => {
    //   // const formdata = new FormData();
    //   // data.append("image", item.image);
    //   // console.log(data.productImage.map((item) => item.serverId));
    //   // alert(data.productImage.map((item) => item.serverId));
    //   return {
    //     ...data,

    //     productImage: data.productImage.map((item) => item.serverId), // Pluck only the serverIds
    //   };
    // })
    .post(route("manage.products.updateProduct", { preserveState: true }), {
      onSuccess: () => {
        filepondProductImageInput.value.removeFiles(), event.target.reset();
      },
    });
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
// const imageChanged = (index, e) => {
// console.log(e);
// console.log(index);
// productForm.dynamic[index].image = e.target.files[0];
// var fileReader = new FileReader();
// fileReader.readAsDataURL(e.target.files[0]);
// fileReader.onload = (e) => {
//   console.log(e);
//   productForm.dynamic[index].image = e.target.result;
// };
// };

const imageChanged = (index, e) => {
  let files = e.target.files,
    reader = new FileReader(),
    formData = new FormData(),
    self = this;

  // Set loading to true
  this.loading = true;

  formData.append("file", files[0]);
  formData.append("banner_id", this.bannerId);

  axios
    .post(window.App.baseUrl + "/admin/banner/upload-image", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then(function (response) {
      if (response.data.status == "success") {
        self.photo = response.data.fileName; // result : chelsea.png
        this.loading = false;
      }
    })
    .catch(function (error) {
      console.log("FAILURE!!");
    });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
