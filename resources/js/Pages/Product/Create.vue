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

          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 ">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Category</p>
                    </div>
                  </div>
                  <input v-model="categoryForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="categoryForm.name"
                      autofocus
                    />

                    <span className="text-red-600" v-if="categoryForm.errors.name">
                      {{ categoryForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button
                      @click="submitCategory"
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                    >
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
                    <BreezeInput
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="brandForm.name"
                      autofocus
                    />

                    <span className="text-red-600" v-if="brandForm.errors.name">
                      {{ brandForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button
                      @click="submitBrand"
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                    >
                      Save
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 ">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Category Lists</p>
                    </div>
                  </div>

                  <table
                    className="w-full text-sm text-left text-gray-500 dark:text-gray-400 "
                  >
                    <thead
                      className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="cat in categoriesData.data"
                        className="overflow-y-scroll"
                      >
                        <td scope="col" className="py-3 px-6">{{ cat.name }}</td>
                        <td scope="col" className="py-3 px-6">
                          <a
                            @click="editCategory(cat.id)"
                            className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            @click="destroyCategory(cat.id)"
                            className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="float-right">
                    <Pagination class="mt-6" :links="categoriesData.links" />
                  </div>
                  <div
                    v-if="categoriesData.data.length <= 0"
                    className="mt-5 flex justify-center"
                  >
                    No found records!
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Brand Lists</p>
                    </div>
                  </div>
                  <table
                    className="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                  >
                    <thead
                      className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="brd in brandsData.data">
                        <td scope="col" className="py-3 px-6">{{ brd.name }}</td>
                        <td scope="col" className="py-3 px-6">
                          <a
                            @click="editBrand(brd.id)"
                            className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            @click="destroyBrand(brd.id)"
                            className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="float-right">
                    <Pagination class="mt-6" :links="brandsData.links" />
                  </div>
                  <div
                    v-if="categoriesData.data.length <= 0"
                    className="mt-5 flex justify-center"
                  >
                    No found records!
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
                    <BreezeInput
                      id="image"
                      type="file"
                      @input="productForm.image = $event.target.files"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productForm.image"
                      autofocus
                      multiple
                    />

                    <span className="text-red-600" v-if="productForm.errors.image">
                      {{ productForm.errors.image }}
                    </span>
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
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
  options: Object,
  products: Object,
  brandsData: Object,
  categoriesData: Object,
  brandsOption: Object,
  unitsOption: Object,
  categoriesOption: Object,
});

const productForm = useForm({
  description: "",
  id: "",
  price: "",
  quantity: "",
  title: "",
  image: null,
  brand: "",
  category: "",
  unit: "",
});

const brandForm = useForm({
  id: "",
  name: "",
});
const categoryForm = useForm({
  id: "",
  name: "",
});

const submitProduct = (event) => {
  productForm.post(route("manage.products.store"), {
    onFinish: () => event.target.reset(),
  });
};
const submitBrand = (event) => {
  brandForm.post(route("manage.brands.store"), {
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
    confirmButtonText: "Yes, delete it!",
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
    confirmButtonText: "Yes, delete it!",
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
    confirmButtonText: "Yes, delete it!",
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
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
