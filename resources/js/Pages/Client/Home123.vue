<template>
  <Head title="Home" />

  <AuthenticatedLayout>
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
    </template> -->
    <div class="p-10">
      <!--Card 1-->
      <div class="w-full lg:max-w-full lg:flex">
        <div
          class="w-full border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-300 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
        >
          Filter By Category
          <div v-for="cat in categories" :key="cat.id">
            <input
              :id="cat.id + cat.name"
              type="checkbox"
              @click="filterBy('category', cat)"
            />
            <label :for="cat.id + cat.name">{{ cat.name }}</label>
          </div>
          Filter By Brand
          <div v-for="brd in brands" :key="brd.id">
            <input
              :id="brd.id + brd.name"
              type="checkbox"
              @click="filterBy('brand', brd)"
            />
            <label :for="brd.id + brd.name">{{ brd.name }}</label>
          </div>
          <div class="mb-8">
            <p class="text-sm text-gray-600 flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"
                />
              </svg>

              Filter By
            </p>
            <div class="text-gray-900 font-bold text-xl mb-2">
              Best Mountain Trails 2020
            </div>
            <p class="text-gray-700 text-base">
              Lorem ipsum dolor siLorem ipsum dolor sit amet, consectetur adipisicing
              elit. Voluptatibus quia, Nonea! Maiores et perferendis eaque, exercitationem
              praesentium nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Voluptatibus quia, Nonea! Maiores et perferendis eaque, exercitationem
              praesentium nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Voluptatibus quia, Nonea! Maiores et perferendis eaque, exercitationem
              praesentium nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Voluptatibus quia, Nonea! Maiores et perferendis eaque, exercitationem
              praesentium nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Voluptatibus quia, Nonea! Maiores et perferendis eaque, exercitationem
              praesentium nihil.t amet, consectetur adipisicing elit. Voluptatibus quia,
              Nonea! Maiores et perferendis eaque, exercitationem praesentium nihil.
            </p>
          </div>
          <div class="flex items-center">
            <div class="text-sm">
              <p class="text-gray-900 leading-none">John Smith</p>
              <p class="text-gray-600">Aug 18</p>
            </div>
          </div>
          <!-- {{ category }}
          {{ brand }} -->
        </div>
      </div>
    </div>
    <div class="w-screen h-screen justify-start">
      <div class="flex flex-wrap">
        <div
          v-for="(product, index) in products"
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
import { ref, computed } from "vue";

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
  categories: Object,
  products: Object,
  brands: Object,
});

// const count = ref(1);

var brand = [];
var category = [];
var sortBy = "title";
let mainProductsObject = props.products;

const filterBy = computed(() => {
  return function (filter_type, payload) {
    if (filter_type == "category") {
      if (category.includes(payload.id)) {
        category = _.without(category, payload.id);
      } else {
        category.push(payload.id);
      }
    }
    if (filter_type == "brand") {
      if (brand.includes(payload.id)) {
        brand = _.without(brand, payload.id);
      } else {
        brand.push(payload.id);
      }
    }
    props.products = mainProductsObject
      .filter((item) => {
        return (
          // (this.keyword.length === 0 || item.name.includes(this.keyword)) &&
          (category.length === 0 || category.includes(item.category_id)) &&
          (brand.length === 0 || brand.includes(item.brand_id))
        );
      })
      .sort((a, b) => {
        return a[sortBy].toString().localeCompare(b[sortBy].toString());
      });
  };
});

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
