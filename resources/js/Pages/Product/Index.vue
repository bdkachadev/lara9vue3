<template>
  <Head title="Products" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </template>
    <div className="">
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
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Product List</p>
              <p className="float-right">
                <Link
                  v-if="can.add"
                  :href="route('manage.products.create')"
                  className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Add New
                </Link>
              </p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Image</th>
                  <th scope="col" className="py-3 px-6">Title</th>
                  <th scope="col" className="py-3 px-6">Description</th>
                  <th scope="col" className="py-3 px-6">Price</th>
                  <th scope="col" className="py-3 px-6">Quantity</th>
                  <th v-if="can.edit || can.delete" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="product in products.data"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <td className="py-4 px-6">
                    <img :src="product.images[0]['image']" width="200" height="200" />
                  </td>
                  <th className="py-4 px-6">
                    {{ product.title }}
                  </th>

                  <td className="py-4 px-6">{{ product.description }}</td>
                  <td className="py-4 px-6">{{ product.price }}</td>
                  <td className="py-4 px-6">{{ product.quantity }}</td>

                  <!-- <td className="py-4 px-6">
                    {{ product.roles.length > 0 ? product.roles.map((item) => item.name) : "" }}
                  </td> -->

                  <td className="py-4 px-6">
                    <a
                      v-if="can.edit"
                      :href="route('manage.products.edit', product.id)"
                      className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >
                      Edit
                    </a>
                    <a
                      v-if="can.delete"
                      @click="destroyProduct(product.id)"
                      className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                      >Delete</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <div className="float-right">
              <Pagination class="mt-6" :links="products.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";

defineProps({
  options: Object,
  products: Object,
  can: Object,
});

const productForm = useForm({
  name: "",
  id: "",
  email: "",
  role: null,
});

const submitProduct = (event) => {
  productForm.post(route("manage.products.store"), {
    onFinish: () => event.target.reset(),
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
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
