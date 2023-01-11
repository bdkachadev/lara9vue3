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
              <FlashMessage type="success" :message="$page.props.flash.success" :show="true"></FlashMessage>
            </div>
            <div v-if="$page.props.flash.error">
              <FlashMessage type="error" :show="true" :message="$page.props.flash.error"></FlashMessage>
            </div>
            <div v-if="$page.props.flash.warning">
              <FlashMessage :show="true" type="warning" :message="$page.props.flash.warning"></FlashMessage>
            </div>
          </div>

          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <div className="bg-white shadow-md rounded px-8 py-3  ">
              <div class="grid grid-cols-4 gap-2">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Category</p>
                    </div>
                  </div>
                  <input v-model="categoryForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput id="name" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="categoryForm.name" autofocus />

                    <span className="text-red-600" v-if="categoryForm.errors.name">
                      {{ categoryForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button @click="submitCategory" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                      Save
                    </button>
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Brand</p>
                    </div>
                  </div>
                  <input v-model="productForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput id="name" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="brandForm.name" autofocus />

                    <span className="text-red-600" v-if="brandForm.errors.name">
                      {{ brandForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button @click="submitBrand" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                      Save
                    </button>
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Attribute</p>
                    </div>
                  </div>
                  <input v-model="attributeForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput id="name" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="attributeForm.name" autofocus />
                    <span className="text-red-600" v-if="attributeForm.errors.name">
                      {{ attributeForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button @click="submitAttribute" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                      Save
                    </button>
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Attribute Value</p>
                    </div>
                  </div>
                  <input v-model="attributeValueForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="type" value="Type" />
                    <Multiselect :close-on-select="true" :searchable="true" :create-option="true" v-model="attributeValueForm.type" :options="attributesOption" />
                    <span className="text-red-600" v-if="attributeValueForm.errors.type">
                      {{ attributeValueForm.errors.type }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="value" value="Value" />
                    <BreezeInput id="value" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="attributeValueForm.value" autofocus />

                    <span className="text-red-600" v-if="attributeValueForm.errors.value">
                      {{ attributeValueForm.errors.value }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button @click="submitAttributeValue" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                      Save
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 ">
              <div class="grid grid-cols-4 gap-1">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Category Lists</p>
                    </div>
                  </div>

                  <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cat in categoriesData" className="overflow-y-scroll">
                        <td scope="col" className="py-3 px-6">{{ cat.name }}</td>
                        <td scope="col" className="py-3 px-6">
                          <a @click="editCategory(cat.id)" className="ml-2 cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                          </a>
                          <a @click="destroyCategory(cat.id)" className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="categoriesData.links" />
                  </div> -->
                  <div v-if="categoriesData.length <= 0" className="mt-5 flex justify-center">
                    No records found!
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Brand Lists</p>
                    </div>
                  </div>
                  <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="brd in brandsData">
                        <td scope="col" className="py-3 px-6">{{ brd.name }}</td>
                        <td scope="col" className="py-3 px-6">
                          <a @click="editBrand(brd.id)" className="ml-2 cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                          </a>
                          <a @click="destroyBrand(brd.id)" className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="brandsData.links" />
                  </div> -->
                  <div v-if="categoriesData.length <= 0" className="mt-5 flex justify-center">
                    No records found!
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Attribute Lists</p>
                    </div>
                  </div>

                  <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="attribute in attributesData" className="overflow-y-scroll">
                        <td scope="col" className="py-3 px-6">{{ attribute.name }}</td>
                        <td scope="col" className="py-3 px-6">
                          <a @click="editAttribute(attribute.id)" className="ml-2 cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                          </a>
                          <a @click="destroyAttribute(attribute.id)" className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="attributesData.links" />
                  </div> -->
                  <div v-if="attributesData.length <= 0" className="mt-5 flex justify-center">
                    No records found!
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Attribute's Value Lists</p>
                    </div>
                  </div>
                  <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                        <th scope="col" className="py-3 px-6">Value</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="attributeValue in attributesValueData">
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.value }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          <a @click="editAttributeValue(attributeValue.id)" className="ml-2 cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                          </a>
                          <a @click="destroyAttributeValue(attributeValue.id)" className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="attributesValueData.links" />
                  </div> -->
                  <div v-if="attributesValueData.length <= 0" className="mt-5 flex justify-center">
                    No records found!
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Add Product</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form ref="formproduct" className="bg-white shadow-md rounded px-8 pt-6 pb-8 " @submit.prevent="submitProduct">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <input v-model="productForm.id" type="hidden" value="" />
                  <div className="mb-4">
                    <BreezeLabel for="title" value="Title" />
                    <BreezeInput id="title" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="productForm.title" autofocus />

                    <span className="text-red-600" v-if="productForm.errors.title">
                      {{ productForm.errors.title }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput id="description" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="productForm.description" autofocus />

                    <span className="text-red-600" v-if="productForm.errors.description">
                      {{ productForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="price" value="Price" />
                    <BreezeInput id="price" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="productForm.price" autofocus />

                    <span className="text-red-600" v-if="productForm.errors.price">
                      {{ productForm.errors.price }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="quantity" value="Quantity" />
                    <BreezeInput id="quantity" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="productForm.quantity" autofocus />

                    <span className="text-red-600" v-if="productForm.errors.quantity">
                      {{ productForm.errors.quantity }}
                    </span>
                  </div>
                </div>
                <div>
                  <div className="mb-4">
                    <BreezeLabel for="category" value="Category" />
                    <Multiselect :close-on-select="true" :searchable="true" :create-option="true" v-model="productForm.category" :options="categoriesOption" />

                    <span className="text-red-600" v-if="productForm.errors.category">
                      {{ productForm.errors.category }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="brand" value="Brand" />
                    <Multiselect :close-on-select="true" :searchable="true" :create-option="true" v-model="productForm.brand" :options="brandsOption" />

                    <span className="text-red-600" v-if="productForm.errors.brand">
                      {{ productForm.errors.brand }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="unit" value="Unit" />
                    <Multiselect :close-on-select="true" :searchable="true" :create-option="true" v-model="productForm.unit" :options="unitsOption" />

                    <span className="text-red-600" v-if="productForm.errors.unit">
                      {{ productForm.errors.unit }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="image" value="Image" />
                    <!-- <BreezeInput id="image" type="file" @input="productForm.image = $event.target.files" className="shadow appearance-none border rounded w-full  px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline w-full cursor-pointer rounded-lg border  text-gray-600 file:mr-20 file:rounded-lg file:border-none file:bg-indigo-600 file:p-2 file:text-white hover:file:cursor-pointer hover:file:bg-indigo-500" v-model="productForm.image" autofocus multiple /> -->
                    <FilePond name="productImage" ref="filepondProductImageInput" class-name="my-pond" allow-multiple="true" accepted-file-types="image/jpeg, image/png" @init="handleFilePondInit" @processfile="handleFilePondProductImageProcess" @removefile="handleFilePondProductImageRemoveFile" />
                    <!-- <span className="text-red-600" v-if="productForm.errors.image">
                      {{ productForm.errors.image }}
                    </span> -->
                    <div v-if="productForm.errors">
                      <div v-for="(error, index) in productForm.errors" class="text-red-500">
                        {{ error }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="grid grid-cols-10 gap-1" v-for="(item, index) in productForm.dynamic" :key="item">
                <!-- <input v-model="item.attrArr" type="hidden" value="" /> -->

                <div class="col-span-2">
                  <!-- <div>{{ item }}</div> -->
                  <div className="">
                    <BreezeLabel for="sku" value="Sku" />
                    <BreezeInput id="sku" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="item.sku" autofocus />
                  </div>
                </div>
                <!-- <div>
                  <div className="">
                    <BreezeLabel for="attribute" value="Attribute" />
                     <Multiselect v-model="item.attribute" :close-on-select="false" :searchable="true" :create-option="true" :options="attributesOption" @change="onChangeAttribute($event)" mode="tags" /> 
                  </div>
                </div>  -->
                <div className="col-span-4">
                  <div className="">
                    <BreezeLabel for="attribute_value" value="Attribute Value" />
                    <Multiselect :close-on-select="false" :searchable="true" :create-option="true" v-model="item.attribute_value" :options="attributesValueOption" mode="tags" />
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
                    <BreezeInput id="price" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="item.price" autofocus />
                  </div>
                </div>
                <div>
                  <div className="">
                    <BreezeLabel for="quantity" value="Quantity" />
                    <BreezeInput id="quantity" type="text" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" v-model="item.quantity" autofocus />
                  </div>
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
                    <a @click="addDynamic" className="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">
                      Add
                    </a>
                    <a @click="removeDynamic(index)" className="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-500 text-white rounded">
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
                <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
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
  import {
    reactive,
    ref,
    onMounted
  } from "vue";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import {
    useForm,
    Head
  } from "@inertiajs/inertia-vue3";
  import BreezeLabel from "@/Components/InputLabel.vue";
  import BreezeInput from "@/Components/TextInput.vue";
  import FlashMessage from "@/Components/FlashMessage.vue";
  import Swal from "sweetalert2";
  import Multiselect from "@vueform/multiselect";

  // Import filepond
  import vueFilePond, {
    setOptions
  } from "vue-filepond";

  // Import filepond plugins
  import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
  import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

  // Import filepond styles
  import "filepond/dist/filepond.min.css";
  import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

  const filepondProductImageInput = ref(null); // Reference the input to clear the files later

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

    attributesData: Object,
    csrf_token: String,
  });

  const productForm = useForm({
    description: "",
    id: "",
    price: "",
    quantity: "",
    title: "",
    productImage: [],
    brand: "",
    category: "",
    unit: "",
    dynamic: reactive([{
      sku: "",
      price: "",
      quantity: "",
      // size: "",
      // color: "",
      attribute_value: [],
      // attribute: [],
      // attrArr: [],
      // variantImage: null,
    }, ]),
  });
  const attributeValueForm = useForm({
    id: "",
    type: "",
    value: "",
  });
  const attributeForm = useForm({
    id: "",
    name: "",
  });
  const brandForm = useForm({
    id: "",
    name: "",
  });
  const categoryForm = useForm({
    id: "",
    name: "",
  });

  // dynamic

  const addDynamic = () => {
    productForm.dynamic.push({
      sku: "",
      price: "",
      quantity: "",
      size: "",
      color: "",
    });
  };

  const removeDynamic = (index) => {
    // if (productForm.dynamic.length > 1) {
    productForm.dynamic.splice(index, 1);
    // }
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
  // // Set the server id from response
  // const handleFilePondProductVariantImageProcess = (error, file) => {
  //   console.log(file.id);
  //   console.warn(file.serverId);
  //   productForm.dynamic.variantImage = file.serverId;
  // };
  // // Remove the server id on file remove
  // const handleFilePondProductVariantImageRemoveFile = (error, file) => {
  //   productForm.dynamic.variantImage = null;
  // };
  const submitAttribute = (event) => {
    attributeForm.post(route("manage.attributes.store"), {
      onFinish: () => event.target.reset(),
    });
  };
  const submitAttributeValue = (event) => {
    attributeValueForm.post(route("manage.attributesValue.store"), {
      onFinish: () => event.target.reset(),
    });
  };
  const submitCategory = (event) => {
    categoryForm.post(route("manage.categories.store"), {
      onFinish: () => event.target.reset(),
    });
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

  const destroyBrand = (id) => {
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
        brandForm.delete(route("manage.brands.destroy", id));
      }
    });
  };

  const destroyCategory = (id) => {
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
        categoryForm.delete(route("manage.categories.destroy", id));
      }
    });
  };

  const editCategory = (id) => {
    axios.get(route("manage.categories.edit", id)).then((res) => {
      categoryForm.id = res.data.id;
      categoryForm.name = res.data.name;
    });
  };

  const editBrand = (id) => {
    axios.get(route("manage.brands.edit", id)).then((res) => {
      brandForm.id = res.data.id;
      brandForm.name = res.data.name;
    });
  };

  const destroyAttribute = (id) => {
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
        categoryForm.delete(route("manage.attributes.destroy", id));
      }
    });
  };

  const editAttribute = (id) => {
    axios.get(route("manage.attributes.edit", id)).then((res) => {
      attributeForm.id = res.data.id;
      attributeForm.name = res.data.name;
    });
  };

  const destroyAttributeValue = (id) => {
    console.log(id);
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
        attributeValueForm.delete(route("manage.attributesValue.destroy", id));
      }
    });
  };

  const editAttributeValue = (id) => {
    console.log(id);

    axios.get(route("manage.attributesValue.edit", id)).then((res) => {
      console.log(res.data);
      attributeValueForm.id = res.data.id;
      attributeValueForm.value = res.data.value;
      attributeValueForm.type = res.data.attribute_id;
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
</script>
<style src="@vueform/multiselect/themes/default.css"></style>