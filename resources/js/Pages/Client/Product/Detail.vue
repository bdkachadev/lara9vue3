<template>
  <Head title="Detail" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Detail</h2>
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
          <div className=" bg-white border-b border-gray-200">
            <div className="flow-root">
              <!-- Contents -->
              <div className="container mx-auto font-kumbh text-base">
                <!-- Main Content -->
                <main className="w-full flex flex-col lg:flex-row">
                  <!-- Gallery -->
                  <section
                    className="h-fit flex-col gap-8 mt-16 sm:flex sm:flex-row sm:gap-4 sm:h-full sm:mt-24 sm:mx-2 md:gap-8 md:mx-4 lg:flex-col lg:mx-0 "
                  >
                    <picture
                      className="relative flex items-center bg-indigo sm:bg-transparent"
                    >
                      <button
                        className="bg-white w-10 h-10 flex items-center justify-center pr-1 rounded-full absolute left-6 z-10 sm:hidden"
                        id="previous-mobile"
                      >
                        <svg
                          width="12"
                          height="18"
                          xmlns="http://www.w3.org/2000/svg"
                          id="previous-mobile"
                        >
                          <path
                            d="M11 1 3 9l8 8"
                            stroke="#1D2026"
                            stroke-width="3"
                            fill="none"
                            fill-rule="evenodd"
                            id="previous-mobile"
                          />
                        </svg>
                      </button>
                      <img
                        :src="myImage"
                        alt="product"
                        className="object-cover h-96 w-96 block sm:rounded-xl xl:w-[70%] xl:rounded-xl m-auto pointer-events-none transition duration-300 lg:w-3/4 lg:pointer-events-auto lg:cursor-pointer lg:hover:shadow-xl"
                        id="hero"
                      />

                      <button
                        className="bg-white w-10 h-10 flex items-center justify-center pl-1 rounded-full absolute right-6 z-10 sm:hidden"
                        id="next-mobile"
                      >
                        <svg
                          width="13"
                          height="18"
                          xmlns="http://www.w3.org/2000/svg"
                          id="next-mobile"
                        >
                          <path
                            d="m2 1 8 8-8 8"
                            stroke="#1D2026"
                            stroke-width="3"
                            fill="none"
                            fill-rule="evenodd"
                            id="next-mobile"
                          />
                        </svg>
                      </button>
                    </picture>

                    <!-- <div
                      className="thumbnails hidden justify-between gap-4 m-auto sm:flex sm:flex-col sm:justify-start sm:items-center sm:h-fit md:gap-5 lg:flex-row"
                      >
                      <div
                        v-for="image in product.images"
                        className="w-1/5 cursor-pointer rounded-xl sm:w-28 md:w-32 lg:w-[72px] xl:w-[78px] ring-active"
                      >
                        <img
                          :src="image.image"
                          @mouseover="toggleInfoImage(image.image)"
                          alt="thumbnail"
                          className="rounded-xl hover:opacity-50 transition active"
                          id="thumb-1"
                        />
                      </div>
                    </div> -->
                  </section>

                  <!-- Text -->
                  <section className="w-full p-6  lg:pr-20 lg:py-10 2xl:pr-40 2xl:mt-40">
                    <h1 className="text-very-dark mb-4 font-bold text-3xl lg:text-4xl">
                      {{ product.title }}
                    </h1>
                    <p className="text-dark-grayish mb-6 text-base sm:text-lg">
                      {{ product.description }}
                    </p>

                    <div
                      className="flex items-center justify-between mb-6 sm:flex-col sm:items-start"
                    >
                      <div className="flex items-center gap-4">
                        <h3 className="text-very-dark font-bold text-3xl inline-block">
                          ${{ product.price }}
                        </h3>
                        <!-- <span
                          className="inline-block h-fit py-0.5 px-2 font-bold bg-pale-indigo text-indigo rounded-lg text-sm"
                          >50%</span
                        > -->
                      </div>
                      <!-- <p
                        className="text-dark-grayish w-fit line-through decoration-dark-grayish decoration-1 my-auto"
                      >
                        $250.00
                      </p> -->
                    </div>

                    <div className="flex flex-col gap-5 mb-16 sm:flex-row lg:mb-0">
                      <div
                        className="w-full h-10 text-sm bg-light py-2 flex items-center justify-between rounded-lg font-bold relatives sm:w-80"
                      >
                        <button
                          id="minus"
                          className="plus-minus"
                          :disabled="isActive"
                          @click="count != 1 ? count-- : 1"
                        >
                          <div className="w-3 h-1 bg-indigo absolute" id="minus"></div>
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="shadow-md shadow-indigo hover:brightness-125 transition select-none w-8 h-9 inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-indigo-500 text-white rounded"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 12h-15"
                            />
                          </svg>
                        </button>
                        <span id="amount" className="select-none font-bold">{{
                          count
                        }}</span>
                        <button
                          id="plus"
                          className="plus-minus"
                          :disabled="isActive"
                          @click="count != product.quantity ? count++ : product.quantity"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="shadow-md shadow-indigo hover:brightness-125 transition select-none w-8 h-9 inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-indigo-500 text-white rounded"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15"
                            />
                          </svg>
                        </button>
                      </div>
                      <button
                        className="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-indigo-500 text-white rounded    w-full h-10 bg-indig-500 py-2 flex items-center justify-center gap-4 text-xs rounded-lg font-bold text-light shadow-md shadow-indigo hover:brightness-125 transition select-none"
                        id="add-cart"
                        :disabled="isActive"
                        @click="addToCart(product.id)"
                      >
                        <svg
                          width="16"
                          height="16"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 22 20"
                        >
                          <path
                            d="M20.925 3.641H3.863L3.61.816A.896.896 0 0 0 2.717 0H.897a.896.896 0 1 0 0 1.792h1l1.031 11.483c.073.828.52 1.726 1.291 2.336C2.83 17.385 4.099 20 6.359 20c1.875 0 3.197-1.87 2.554-3.642h4.905c-.642 1.77.677 3.642 2.555 3.642a2.72 2.72 0 0 0 2.717-2.717 2.72 2.72 0 0 0-2.717-2.717H6.365c-.681 0-1.274-.41-1.53-1.009l14.321-.842a.896.896 0 0 0 .817-.677l1.821-7.283a.897.897 0 0 0-.87-1.114ZM6.358 18.208a.926.926 0 0 1 0-1.85.926.926 0 0 1 0 1.85Zm10.015 0a.926.926 0 0 1 0-1.85.926.926 0 0 1 0 1.85Zm2.021-7.243-13.8.81-.57-6.341h15.753l-1.383 5.53Z"
                            fill="hsl(223, 64%, 98%)"
                            fill-rule="nonzero"
                          />
                        </svg>
                        Add to cart
                      </button>
                    </div>
                    <div className="mt-2">Available Variants</div>
                    <div v-html="stock"></div>
                    <div
                      v-for="(arr, index) in Arr"
                      className="w-full mt-2 h-10 text-sm bg-light py-2 flex items-center justify-between rounded-lg font-bold relatives sm:w-80"
                    >
                      <div class="w-16 shrink-0">
                        <div class="h-10 flex flex-col justify-center">
                          <div
                            class="text-sm font-semibold text-slate-900 dark:text-slate-200"
                          >
                            {{ index }}
                          </div>
                        </div>
                      </div>
                      <Multiselect
                        :close-on-select="true"
                        :searchable="true"
                        :create-option="true"
                        :options="Object.values(arr)"
                        :placeholder="placeholder"
                        @change="onChangeVariant(index, $event, product.id)"
                      />
                    </div>
                    <!-- <div class="grid grid-cols-1 gap-8">
                      <div v-for="(arr, index) in Arr">
                        <div
                          class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-y-0 sm:space-x-4"
                        >
                          <div class="w-16 shrink-0">
                            <div class="h-10 flex flex-col justify-center">
                              <div
                                class="text-sm font-semibold text-slate-900 dark:text-slate-200"
                              >
                                {{ index.split("-")[1] }}
                              </div>
                            </div>
                          </div>
                          <div
                            class="min-w-0 flex-1 grid grid-cols-6 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2"
                          >
                            <a
                              v-for="(a, i) in arr"
                              @click="clickOnVariant(index, a)"
                              class="relative flex border-2 border-gray-400 cursor-pointer"
                              :class="
                                ([
                                  index == 'Color'
                                    ? 'bg-' + a.value.toLowerCase() + '-600'
                                    : '',
                                ],
                                { 'border-blue-600': sssss })
                              "
                            >
                              <div class="h-full w-full text-center pt-3 font-bold">
                                {{ a.label }}
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </section>
                </main>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, beforeMount } from "vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
  product: Object,
  Arr: Object,
  variant: {},

  //   can: Object,
});
var selectedAttribute = {};
const stock = ref("");
const isActive = ref(false);

const myImage = ref(props.product.images[0]["image"]);
const count = ref(1);
// var sssss = ref(false);
var placeholder1 = "";
const toggleInfoImage = (image) => {
  // alert(image);
  myImage = image;
  // alert(myImage);
  // $("#hero").attr("src") = image;
};
const addToCart = async (product_id) => {
  var variant_id = null;
  if (props.variant) {
    variant_id = props.variant.id;
  }
  await axios
    .post(route("manage.carts.store"), {
      count: count.value,
      id: product_id,
      variant_id: variant_id,
    })
    // .post(route("manage.carts.store"), { id: id })
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
// const clickOnVariant = (type, value) => {
//   sssss != sssss;

//   var value = JSON.parse(JSON.stringify(value));
//   console.log(type.split("-")[0]);
//   console.log(value);
// };

const onChangeVariant = (type, event, product_id) => {
  selectedAttribute[type] = event;
  console.log(selectedAttribute);

  axios
    .post(route("manage.general.onChangeVariant"), {
      selectedAttribute: selectedAttribute,
      product_id: product_id,
    })
    .then((response) => {
      if (response.data) {
        // console.log("ll");
        // console.log(response.data);
        stock.value = "<span class='text-green-600	 font-bold'>In Stock</span>";
        props.variant = response.data;
        // console.log(props.variant.image.image);
        myImage.value = props.variant.image.image;
        props.product.price = props.variant.price;
        props.product.quantity = props.variant.quantity;
        isActive.value = false;
        count.value = 1;

        // console.log(myImage);
      } else {
        // console.log("lll");
        // props.variant = {};
        myImage.value = props.product.images[0]["image"];
        props.product.price = props.variant.price;
        props.product.quantity = props.variant.quantity;
        isActive.value = true;
        count.value = 0;

        // console.log(myImage);

        stock.value = "<span class='text-red-600	 font-bold'>Out Of Stock</span>";
      }
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

// const getAttributeName = (id) => {
//   axios
//     .post(route("manage.general.getNameOfAttribute"), { id: id })
//     .then((response) => {
//       placeholder1 = response;
//     })
//     .catch((error) => {
//       console.log(error);
//     });
// };

// onBeforeMount((id) => {
//   axios
//     .post(route("manage.general.getNameOfAttribute"), { id: id })
//     .then((response) => {
//       attribute_name = response;
//     })
//     .catch((error) => {
//       console.log(error);
//     });
// });

// const getAttributeName = computed(() => {
//   return function (id) {
//     axios
//       .post(route("manage.general.getNameOfAttribute"), { id: id })
//       .then((response) => {
//         console.log(response);
//         return response;
//       })
//       .catch((error) => {
//         console.log(error);
//       });
//   };
// });
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
