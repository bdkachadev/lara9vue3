<template>
  <Head title="Products" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </template>
    <div>
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="text-center">
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

          <div className="p-8 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">
                Add Product
                <span class="text-red-600">
                  (*make sure you have added Category, Brand, Tag, Taxonomy and Product
                  Variant Attributes based on your requirements)</span
                >
              </p>
              <Link
                class="float-right bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                :href="route('manage.products.index')"
                >Back</Link
              >
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formproduct"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
              @submit.prevent="submitProduct"
            >
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <input v-model="productForm.id" type="hidden" value="" />
                  <div className="mb-4">
                    <BreezeLabel for="title" value="Title" />
                    <BreezeInput
                      id="title"
                      type="text"
                      className="shadow appearance-none
                    border rounded w-full py-2 px-3 text-gray-700 leading-tight
                    focus:outline-none focus:shadow-outline"
                      v-model="productForm.title"
                      autofocus
                      placeholder="Enter title"
                      @keyup="formValidation('title')"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.description"
                      autofocus
                      placeholder="Enter description"
                      @keyup="formValidation('description')"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.price"
                      autofocus
                      placeholder="Enter price"
                      @keyup="formValidation('price')"
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
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.quantity"
                      autofocus
                      placeholder="Enter quantity"
                      @keyup="formValidation('quantity')"
                    />

                    <span className="text-red-600" v-if="productForm.errors.quantity">
                      {{ productForm.errors.quantity }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <label class="block font-medium text-sm text-gray-700" for="brand">
                      <span
                        >Custom Taxonomy Attribute

                        <Link
                          :href="route('manage.taxonomyAttribute.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
                      </span>
                    </label>
                    <Multiselect
                      id="taxonomy_attributes"
                      v-model="productForm.taxonomy_attributes"
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      :options="taxonomyAttributesOption"
                      placeholder="-- Taxonomy Attributes --"
                      mode="tags"
                      @change="formValidation('taxonomy_attributes')"
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
                    <label class="block font-medium text-sm text-gray-700" for="category">
                      <span
                        >Category
                        <Link
                          :href="route('manage.categories.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
                      </span>
                    </label>

                    <Multiselect
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.categories"
                      :options="categoriesOption"
                      placeholder="-- Category --"
                      mode="tags"
                      @keyup="
                        productForm.errors.categories =
                          productForm.categories === ''
                            ? 'The categories field is required.'
                            : ''
                      "
                    />

                    <span className="text-red-600" v-if="productForm.errors.categories">
                      {{ productForm.errors.categories }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <label class="block font-medium text-sm text-gray-700" for="brand">
                      <span
                        >Brand
                        <Link
                          :href="route('manage.brands.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
                      </span>
                    </label>
                    <Multiselect
                      :close-on-select="false"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.brands"
                      :options="brandsOption"
                      placeholder="-- Brand --"
                      mode="tags"
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
                      placeholder="-- Unit --"
                    />

                    <span className="text-red-600" v-if="productForm.errors.unit">
                      {{ productForm.errors.unit }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <label class="block font-medium text-sm text-gray-700" for="brand">
                      <span
                        >Tag
                        <Link
                          :href="route('manage.tags.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
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
                    <!-- <BreezeInput id="image" type="file" @input="productForm.image = $event.target.files" className="shadow appearance-none border rounded w-full  px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full cursor-pointer rounded-lg border  text-gray-600 file:mr-20 file:rounded-lg file:border-none file:bg-indigo-600 file:p-2 file:text-white hover:file:cursor-pointer hover:file:bg-indigo-500" v-model="productForm.image" autofocus multiple /> -->
                    <FilePond
                      name="productImage"
                      ref="filepondProductImageInput"
                      class-name="my-pond"
                      allow-multiple="true"
                      accepted-file-types="image/*"
                      @init="handleFilePondInit"
                      @processfile="handleFilePondProductImageProcess"
                      @removefile="handleFilePondProductImageRemoveFile"
                    />
                    <span className="text-red-600" v-if="productForm.errors.productImage">
                      {{ productForm.errors.productImage }}
                    </span>
                    <!-- <div v-if="productForm.errors">
                      <div
                        v-for="(error, index) in productForm.errors"
                        class="text-red-500"
                      >
                        {{ error }}
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- <span class="text-red-600">
                (*Image is not selected then its taken from main product image )</span
              > -->
              <div
                class="grid grid-cols-10 gap-1"
                v-for="(item, index) in productForm.dynamic"
                :key="item"
              >
                <!-- <input v-model="item.attrArr" type="hidden" value="" /> -->
                <BreezeInput
                  id="variant_id"
                  type="hidden"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="productForm.dynamic[index].variant_id"
                />
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
                        <Link
                          :href="route('manage.attributesValue.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
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
                      placeholder="-- Attribute - Value --"
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
                      placeholder="-- Price --"
                      autofocus
                    />
                  </div>
                </div>
                <div>
                  <div className="col-span-1">
                    <BreezeLabel for="unit" value="Unit" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="productForm.dynamic[index].unit"
                      :options="unitsOption"
                      placeholder="-- Unit --"
                    />
                  </div>
                </div>
                <div>
                  <div className="">
                    <BreezeLabel for="quantity" value="Quantity" />
                    <BreezeInput
                      id="quantity"
                      type="number"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.dynamic[index].quantity"
                      autofocus
                      placeholder="1"
                    />
                  </div>
                </div>
                <div className="col-span-2">
                  <BreezeLabel for="image" value="Image" />
                  <BreezeInput
                    id="image"
                    type="file"
                    @input="productForm.dynamic[index].image = $event.target.files[0]"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    autofocus
                  />
                </div>

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
                      className=" cursor-pointer inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded"
                    >
                      Add
                    </a>
                    <a
                      @click="removeDynamic(index)"
                      className="cursor-pointer inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-500 text-white rounded"
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
                  :disabled="isDisabled"
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
import { reactive, ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Back from "@/Components/Back.vue";

// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";

// Import filepond plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import filepond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const filepondProductImageInput = ref(null); // Reference the input to clear the files later
const isDisabled = ref(false);
// const validateInput = () => {
//   productForm.errors.title =
//     productForm.title === "" ? "The Input field is required" : "";
// };
const formValidation = (fieldName, event) => {
  productForm.errors[fieldName] = "";
  isDisabled.value = false;

  if (productForm[fieldName] === "") {
    isDisabled.value = true;
    productForm.errors[fieldName] = "The " + fieldName + " field is required.";
  }

  if (productForm[fieldName] != "" && fieldName == "price") {
    var check = /^\d{0,8}(\.\d{1,2})?$/.test(productForm[fieldName]);
    if (!check) {
      isDisabled.value = true;
      productForm.errors[fieldName] = "Please enter valid " + fieldName + ".";
    }
  }

  if (productForm[fieldName] != "" && fieldName == "quantity") {
    var check = /^\d{0,8}?$/.test(productForm[fieldName]);
    if (!check) {
      isDisabled.value = true;
      productForm.errors[fieldName] = "Please enter valid " + fieldName + ".";
    }
  }
};
// const filepondProductVariantImageInput = ref(null); // Reference the input to clear the files later
const props = defineProps({
  options: Object,
  products: Object,
  brandsData: Object,
  categoriesData: Object,
  brandsOption: Object,
  unitsOption: Object,
  categoriesOption: Object,
  sizesOption: Object,
  attributesOption: Object,
  attributesValueOption: Object,
  colorsOption: Object,
  attributesValueData: Object,
  taxonomyAttributesOption: Object,
  attributesData: Object,
  csrf_token: String,
  tagsOption: Object,
});

const productForm = useForm({
  taxonomy_attributes: [],
  description: "",
  id: "",
  price: "",
  quantity: "",
  title: "",
  productImage: [],
  brands: [],
  tags: [],
  categories: [],
  unit: "",
  dynamic: reactive([
    {
      price: "",
      quantity: "",
      unit: "",
      image: "",
      attribute_value: [],
      variant_id: "",
    },
  ]),
  errors: reactive([
    {
      taxonomy_attributes: [],
      description: "",
      id: "",
      price: "",
      quantity: "",
      title: "",
      productImage: [],
      brands: [],
      tags: [],
      categories: [],
      unit: "",
    },
  ]),
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
      // size: "",
      // color: "",
    });
  } else {
    Swal.fire({
      title: "Warning!",
      text: "Please Select Attribute Value, Price, Quantity and Image",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ok",
    });
  }
};

const removeDynamic = (index) => {
  console.log(index);
  if (productForm.dynamic.length > 1) {
    productForm.dynamic.splice(index, 1);
  }
};
const submitBrand = (event) => {
  brandForm.post(route("manage.brands.store"), {
    onFinish: () => event.target.reset(),
  });
};
const submitProduct = (event) => {
  // productForm.post(route("manage.products.store"), {
  //   onFinish: () => event.target.reset(),
  // });
  productForm
    .transform((data) => {
      console.log(data);
      // alert(data.productImage.map((item) => item.serverId));
      return {
        ...data,
        productImage: data.productImage.map((item) => item.serverId), // Pluck only the serverIds
        // variantImage: data.variantImage.map((item) => item.serverId), // Pluck only the serverIds
      };
    })
    .post(route("manage.products.store"), {
      onSuccess: () => {
        // filepondProductImageInput.value.removeFiles(),
        // filepondProductVariantImageInput.value.removeFiles(),
        event.target.reset();
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

const editProduct = (id) => {
  axios.get(route("manage.products.edit", id)).then((res) => {
    var roles = res.data.roles.map((item) => item.name);

    productForm.id = res.data.id;
    productForm.name = res.data.name;
    productForm.email = res.data.email;
    productForm.role = roles;
  });
};

const destroyProduct = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to delete this?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      productForm.delete(route("manage.products.destroy", id));
    }
  });
};

const onChangeAttribute = (event) => {
  // console.log(event);

  axios
    .post(route("manage.general.onChangeAttribute"), {
      attribute_id: event,
    })
    .then((res) => {
      // console.log(res.data);
      props.attributesValueOption = res.data;
    });
};

const onChangeAttributeValue = (event) => {
  alert(event);
  // axios
  //   .post(route("manage.general.onChangeAttributeValue"), {
  //     attribute_value_id: event,
  //   })
  //   .then((res) => {
  //     // console.log(res.data);
  //     props.attributesValueOption = res.data;
  //   });
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
          // console.log(typeof(attribute_values_id));

          productForm.dynamic[index].attribute_value = attribute_values_id;
        }
      });
  }
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style></style>
