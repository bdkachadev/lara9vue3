<template>

  <Head title="My Order" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">My Order</h2>
    </template>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-5 text-center">
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
          <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
            <div class="flex justify-start item-start space-y-2 flex-col">
              <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">
                Order {{ order.order_id }}
              </h1>
              <!-- <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">
                21st Mart 2021 at 10:34 PM
              </p> -->
            </div>
            <div class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
              <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                  <p class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800">
                    Order’s Details
                  </p>
                  <div v-for="c in cart" class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                    <div class="pb-4 md:pb-8 w-full md:w-40">
                      <img class="w-full hidden md:block" :src="c.image" />
                      <img class="w-full md:hidden" :src="c.image" />
                    </div>
                    <div class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                      <div class="w-full flex flex-col justify-start items-start space-y-8">
                        <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">
                          {{ c.title }}
                        </h3>
                        <!--<div class="flex justify-start items-start flex-col space-y-2">
                          <p class="text-sm dark:text-white leading-none text-gray-800">
                            <span class="dark:text-gray-400 text-gray-300">Style: </span>
                            {{ c.description }}
                          </p>
                           <p class="text-sm dark:text-white leading-none text-gray-800">
                            <span class="dark:text-gray-400 text-gray-300">Size: </span>
                            Small
                          </p>
                          <p class="text-sm dark:text-white leading-none text-gray-800">
                            <span class="dark:text-gray-400 text-gray-300">Color: </span>
                            Light Blue
                          </p> 
                        </div> -->
                      </div>
                      <div class="flex justify-between space-x-8 items-start w-full">
                        <p class="text-base dark:text-white xl:text-lg leading-6">
                          ${{ c.price }}
                          <!-- <span class="text-red-300 line-through"> $45.00</span> -->
                        </p>
                        <p class="text-base dark:text-white xl:text-lg leading-6 text-gray-800">
                          {{ c.quantity }}
                        </p>
                        <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">
                          ${{ c.price * c.quantity }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
                <div class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                  <div class="flex flex-col justify-start items-start flex-shrink-0"></div>
                  <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                    <div class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                      <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                        <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">
                          Address
                        </p>
                        <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                          {{ order.address }}
                        </p>
                      </div>
                      <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">
                          Summary
                        </h3>
                        <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                          <div class="flex justify-between w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">
                              Subtotal
                            </p>
                            <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                              ${{ order.order_subtotal }}
                            </p>
                          </div>
                          <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">
                              Shipping Charge
                            </p>
                            <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                              ${{ order.shipping_charge }}
                            </p>
                          </div>
                          <!-- <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white leading-4 text-gray-800">
                              Discount
                            </p>
                            <p
                              class="text-base dark:text-gray-300 leading-4 text-gray-600"
                            >
                              0
                            </p>
                          </div> -->
                        </div>
                        <div class="flex justify-between items-center w-full">
                          <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">
                            Total
                          </p>
                          <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">
                            ${{ order.order_subtotal + order.shipping_charge }}
                          </p>
                        </div>
                      </div>

                      <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">
                          Status :
                          <span v-if="order.order_status == 'confirmed'" class="inline-block py-1.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">{{ order.order_status }}</span>
                          <span v-if="order.order_status == 'canceled'" class="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-500 text-white rounded">{{ order.order_status }}</span>
                          <span v-if="order.order_status == 'pending'" class="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-yellow-500 text-white rounded">{{ order.order_status }}</span>
                          <span v-if="order.order_status == 'delivered'" class="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-blue-500 text-white rounded">{{ order.order_status }}</span>
                          <span v-if="order.order_status == 'shipped'" class="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-gray-500 text-white rounded">{{ order.order_status }}</span>
                        </h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import {
    useForm,
    Link,
    Head
  } from "@inertiajs/inertia-vue3";
  import BreezeLabel from "@/Components/InputLabel.vue";
  import BreezeInput from "@/Components/TextInput.vue";
  import FlashMessage from "@/Components/FlashMessage.vue";
  import Swal from "sweetalert2";
  import Multiselect from "@vueform/multiselect";
  import Pagination from "@/Components/Pagination.vue";

  defineProps({
    //   options: Object,
    order: Object,
    cart: Object,
    can: Object,
  });
</script>
<style src="@vueform/multiselect/themes/default.css"></style>