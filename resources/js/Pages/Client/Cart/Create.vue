<template>
  <Head title="Products" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </template>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <!-- <div class="p-5 text-center"> --> <div>
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
              <p className="float-left">Add Product</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formproduct"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
              @submit.prevent="submitProduct"
            >
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
              <div className="mb-2">
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
              <div className="mb-2">
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
              <div className="mb-4">
                <BreezeLabel for="image" value="Image" />
                <BreezeInput
                  id="image"
                  type="file"
                  @input="productForm.image = $event.target.files[0]"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="productForm.image"
                  autofocus
                />

                <span className="text-red-600" v-if="productForm.errors.image">
                  {{ productForm.errors.image }}
                </span>
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
});

const productForm = useForm({
  description: "",
  id: "",
  price: "",
  quantity: "",
  title: "",
  image: null,
});

const submitProduct = () => {
  productForm.post(route("manage.products.store"), {
    onFinish: () => event.target.reset(),
  });
};
const editProduct = (id) => {
  axios.get(route("manage.products.edit", id)).then((res) => {
    var roles = res.data.roles.map((item) => item.name);
    console.warn(roles);

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
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
