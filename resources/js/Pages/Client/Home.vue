<template>
  <Head title="Home" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
    </template>

    <div class="w-screen h-screen justify-start">
      <div class="flex flex-wrap">
        <div
          v-for="product in products"
          class="card flex flex-col justify-center p-10 bg-white rounded-lg shadow-2xl sm:w-1/4"
        >
          <a :href="route('manage.products.detail', product.id)">
            <div class="prod-title">
              <p class="text-xl uppercase text-gray-900 font-bold">{{ product.title }}</p>
              <!-- <p class="uppercase text-sm text-gray-600">
                {{ product.description }}
              </p> -->
            </div>
            <div class="prod-img">
              <img :src="product.image" class="w-full h-64 object-cover object-center" />
            </div>
            <div class="prod-info grid gap-10">
              <!-- <div>
              <ul class="flex flex-row justify-center items-center">
                <li class="mr-4 last:mr-0">
                  <span
                    class="block p-1 border-2 border-gray-500 rounded-full transition ease-in duration-300"
                  >
                    <a href="#blue" class="block w-6 h-6 bg-blue-900 rounded-full"></a>
                  </span>
                </li>
                <li class="mr-4 last:mr-0">
                  <span
                    class="block p-1 border-2 border-white hover:border-gray-500 rounded-full transition ease-in duration-300"
                  >
                    <a
                      href="#yellow"
                      class="block w-6 h-6 bg-yellow-500 rounded-full"
                    ></a>
                  </span>
                </li>
                <li class="mr-4 last:mr-0">
                  <span
                    class="block p-1 border-2 border-white hover:border-gray-500 rounded-full transition ease-in duration-300"
                  >
                    <a href="#red" class="block w-6 h-6 bg-red-500 rounded-full"></a>
                  </span>
                </li>
                <li class="mr-4 last:mr-0">
                  <span
                    class="block p-1 border-2 border-white hover:border-gray-500 rounded-full transition ease-in duration-300"
                  >
                    <a href="#green" class="block w-6 h-6 bg-green-500 rounded-full"></a>
                  </span>
                </li>
              </ul>
            </div> -->
              <!-- <div
              class="flex flex-col md:flex-row justify-between items-center text-gray-900"
            >
              <button
                @click="count != 1 ? count-- : 1"
                class="text-white bg-indigo-500 px-4 py-2 rounded hover:bg-indigo-900"
              >
                <svg
                  class="w-6 h-6"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </button>

              <span class="m-5">{{ count }}</span>
              <button
                @click="count++"
                class="text-white bg-indigo-500 px-4 py-2 rounded hover:bg-indigo-900"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  ></path>
                </svg>
              </button>
            </div> -->
              <div
                class="flex flex-col md:flex-row justify-between items-center text-gray-900"
              >
                <p class="font-bold text-1xl">{{ product.price }} $</p>
                <!-- <button
                  @click="addToCart(product.id)"
                  class="px-3 py-1 transition ease-in duration-200 uppercase rounded-full hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none"
                >
                  Add to cart
                </button> -->
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref } from "vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  productsCount: String,
  usersCount: String,
  products: Object,
});

// const count = ref(1);

const addToCart = async (id) => {
  await axios
    // .post(route("manage.carts.store"), { count: count.value, id: id })
    .post(route("manage.carts.store"), { id: id })
    .then((response) => {
      window.location.href = route("manage.carts.index");

      // Swal.fire({
      //   title: "Wow!",
      //   text: "Product is Added to Cart Successfully",
      //   icon: "success",
      // });
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>
