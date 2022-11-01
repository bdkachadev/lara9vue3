<template>
  <Head title="Cart" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Cart</h2>
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
              <p className="float-left">Cart List</p>
              <p className="float-right" v-if="carts.data.length > 0">
                <Link
                  v-if="can.buy"
                  :href="route('manage.carts.checkout')"
                  className=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Buy All
                </Link>
                <Link
                  v-if="can.delete"
                  @click="clearAllCart()"
                  className="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Remove All
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
                  <th scope="col" className="py-3 px-6">Item Price</th>
                  <th scope="col" className="py-3 px-6">Quantity</th>
                  <th scope="col" className="py-3 px-6">Total Price</th>

                  <th v-if="can.edit || can.delete" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="cart in carts.data"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <td className="py-4 px-6">
                    <img :src="cart.image" width="200" height="200" />
                  </td>
                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ cart.title }}
                  </th>

                  <td className="py-4 px-6">{{ cart.description }}</td>
                  <td className="py-4 px-6">{{ cart.price }}</td>
                  <td className="py-4 px-6">
                    <select
                      @change="onChangeQuantity(cart, $event)"
                      v-model="cart.quantity"
                    >
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                    </select>
                  </td>
                  <td className="py-4 px-6">{{ cart.price * cart.quantity }}</td>

                  <!-- <td className="py-4 px-6">
                    {{ product.roles.length > 0 ? product.roles.map((item) => item.name) : "" }}
                  </td> -->

                  <td className="py-4 px-6">
                    <!-- <a
                      v-if="can.edit"
                      :href="route('manage.products.edit', cart.id)"
                      className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >
                      Edit
                    </a> -->
                    <a
                      v-if="can.buy"
                      :href="route('manage.carts.checkout', cart.id)"
                      className="ml-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded"
                    >
                      Buy Now
                    </a>
                    <a
                      v-if="can.delete"
                      @click="destroyCart(cart.id)"
                      className="ml-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded"
                      >Remove</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <div className="float-right">
              <Pagination class="mt-6" :links="carts.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";

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
  carts: Object,
  can: Object,
});

const onChangeQuantity = (cart, event) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to change quantity?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post(route("manage.carts.changeQuantity"), {
          id: cart.id,
          quantity: event.target.value,
        })
        .then((response) => {
          window.location.href = route("manage.carts.index");

          // Swal.fire({
          //   title: "Wow!",
          //   text: "All Item are removed from cart Successfully!!",
          //   icon: "success",
          // });
          console.log(response);
          // quantity.value = event.target.value;
        });
    }
  });
};

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

const destroyCart = (id) => {
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
      productForm.delete(route("manage.carts.destroy", id));
    }
  });
};
const clearAllCart = () => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to clear cart?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.get(route("manage.carts.clearAllCart")).then((response) => {
        // Swal.fire({
        //   title: "Wow!",
        //   text: "All Item are removed from cart Successfully!!",
        //   icon: "success",
        // });
        window.location.href = route("manage.carts.index");
      });
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
