<template>
  <Head title="Checkout" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Checkout</h2>
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
              <!-- <p className="float-left">Checkout List</p> -->
              <!-- <p className="float-right">
                <Link
                  v-if="can.delete"
                  @click="clearAllCart()"
                  className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Remove All
                </Link>
              </p> -->

              <div class="container p-12 mx-auto">
                <!-- <form class="justify-center w-full mx-auto"> -->
                <div class="flex flex-col w-full px-0 mx-auto md:flex-row">
                  <div class="flex flex-col md:w-full">
                    <h2 class="mb-4 font-bold md:text-xl text-heading">
                      Shipping Address
                    </h2>
                    <div class="">
                      <div class="mt-4">
                        <div class="w-full">
                          <label
                            for="Name"
                            class="block mb-3 text-sm font-semibold text-gray-500"
                            >Name</label
                          >
                          <input
                            type="text"
                            placeholder="Name"
                            v-model="checkoutForm.name"
                            class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                          />
                          <span className="text-red-600" v-if="checkoutForm.errors.name">
                            {{ checkoutForm.errors.name }}
                          </span>
                        </div>
                      </div>
                      <div class="mt-4">
                        <div class="w-full">
                          <label
                            for="Email"
                            class="block mb-3 text-sm font-semibold text-gray-500"
                            >Email</label
                          >
                          <input
                            v-model="checkoutForm.email"
                            type="text"
                            placeholder="Email"
                            class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                          />
                        </div>
                      </div>
                      <div class="mt-4">
                        <div class="w-full">
                          <label
                            for="Address"
                            class="block mb-3 text-sm font-semibold text-gray-500"
                            >Address</label
                          >
                          <textarea
                            v-model="checkoutForm.address"
                            class="w-full px-4 py-3 text-xs border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            cols="20"
                            rows="4"
                            placeholder="Address"
                          ></textarea>
                          <span
                            className="text-red-600"
                            v-if="checkoutForm.errors.address"
                          >
                            {{ checkoutForm.errors.address }}
                          </span>
                        </div>
                      </div>

                      <div class="mt-4">
                        <div class="w-full">
                          <label
                            for="city"
                            class="block mb-3 text-sm font-semibold text-gray-500"
                            >City</label
                          >
                          <input
                            v-model="checkoutForm.city"
                            type="text"
                            placeholder="City"
                            class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                          />
                          <span className="text-red-600" v-if="checkoutForm.errors.city">
                            {{ checkoutForm.errors.city }}
                          </span>
                        </div>
                      </div>

                      <div class="relative pt-3 xl:pt-6">
                        <label
                          for="note"
                          class="block mb-3 text-sm font-semibold text-gray-500"
                        >
                          Notes (Optional)</label
                        ><textarea
                          v-model="checkoutForm.note"
                          class="flex items-center w-full px-4 py-3 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-600"
                          rows="4"
                          placeholder="Notes for delivery"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-col w-full ml-0 lg:ml-12 lg:w-4/5">
                    <!-- <div class="pt-12 md:pt-0 2xl:ps-4">
                      <h2 class="text-xl font-bold">Order Summary</h2>
                      <div class="mt-8">
                        <div class="flex flex-col space-y-4">
                          <div v-for="cart in carts" class="flex space-x-4">
                            <div>
                              <img :src="cart.image" alt="image" class="w-60" />
                            </div>
                            <div>
                              <h2 class="text-xl font-bold">{{ cart.title }}</h2>
                              <p class="text-sm">{{ cart.description }}</p>
                              <span class="text-red-600">Price</span> ${{ cart.price }}
                              <span class="text-blue-600">Quantity</span>
                              {{ cart.quantity }}
                            </div>
                            <div>
                              <svg
                                @click="removeFromCheckout(cart.id)"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"
                                />
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="flex p-4 mt-4">
                        <h2 class="text-xl font-bold">ITEMS {{ carts.length }}</h2>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Subtotal<span class="ml-2">${{ subTotal }}</span>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Shipping Tax<span class="ml-2">${{ shippingTax }}</span>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Total<span class="ml-2">${{ total }}</span>
                      </div>
                      </div> -->
                    <h2 class="mb-4 font-bold md:text-xl text-heading">
                      Billing Details
                    </h2>
                    <div>
                      <div class="flex p-4 mt-3">
                        <h2 class="text-xl font-bold">Your order</h2>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Subtotal<span class="ml-2">${{ subTotal }}</span>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Shipping Tax<span class="ml-2">${{ shippingTax }}</span>
                      </div>
                      <div
                        class="flex items-center w-full py-4 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0"
                      >
                        Order Total<span class="ml-2">${{ total }}</span>
                      </div>
                    </div>
                    <form class="justify-center w-full mx-auto">
                      <div class="">
                        <div class="mt-4">
                          <div class="w-full">
                            <label
                              for="Email"
                              class="block mb-3 text-sm font-semibold text-gray-500"
                              >Card Holder Name*
                            </label>
                            <input
                              v-model="checkoutForm.holder_name"
                              type="text"
                              placeholder="Name"
                              class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                            <span
                              className="text-red-600"
                              v-if="checkoutForm.errors.holder_name"
                            >
                              {{ checkoutForm.errors.holder_name }}
                            </span>
                          </div>
                        </div>
                        <!-- <div class="mt-4">
                          <div class="w-full">
                            <label
                              for="Email"
                              class="block mb-3 text-sm font-semibold text-gray-500"
                              >Card Number*
                            </label>
                            <input
                              name="Number"
                              type="text"
                              placeholder="Number"
                              class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                          </div>
                        </div>

                        <div class="space-x-0 lg:flex lg:space-x-4 mt-4">
                          <div class="w-full lg:w-1/2">
                            <label
                              for="city"
                              class="block mb-3 text-sm font-semibold text-gray-500"
                              >Month</label
                            >
                            <input
                              name="city"
                              type="text"
                              placeholder="City"
                              class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                          </div>
                          <div class="w-full lg:w-1/2">
                            <label
                              for="postcode"
                              class="block mb-3 text-sm font-semibold text-gray-500"
                            >
                              Year</label
                            >
                            <input
                              name="postcode"
                              type="text"
                              placeholder="Post Code"
                              class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                          </div>
                        </div> -->
                        <input
                          type="hidden"
                          class="payment-method"
                          v-model="checkoutForm.payment_method"
                        />

                        <input type="hidden" v-model="checkoutForm.price" />
                        <input type="hidden" v-model="checkoutForm.cart_ids" />

                        <div class="mt-4 col-lg-4 col-md-6">
                          <div
                            id="card-element"
                            className="w-full px-4 py-3 text-sm
                            border border-gray-300 rounded lg:text-sm focus:outline-none
                            focus:ring-1 focus:ring-blue-600"
                          ></div>
                        </div>
                        <!-- <div class="mt-4">
                          <div class="w-full">
                            <label
                              for="Email"
                              class="block mb-3 text-sm font-semibold text-gray-500"
                              >CVV*
                            </label>
                            <input
                              name="Number"
                              type="text"
                              placeholder="Number"
                              class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                          </div>
                        </div> -->
                      </div>
                    </form>
                  </div>
                </div>
                <div class="mt-4">
                  <!-- <StripeCheckout ref="checkoutRef" :pk="publishableKey" mode="payment" /> -->
                  <button
                    @click="submit"
                    class="w-full px-6 py-2 text-blue-200 bg-blue-600 hover:bg-blue-900"
                  >
                    Make Payment
                  </button>
                </div>
                <!-- </form> -->
              </div>

              <!-- <StripeCheckout
                ref="checkoutRef"
                :pk="publishableKey"
                :sessionId="sessionId"
              />
              <div class="mt-4">
                <button
                  @click="submit"
                  class="w-full px-6 py-2 text-blue-200 bg-blue-600 hover:bg-blue-900"
                >
                  Process
                </button>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { loadStripe } from "@stripe/stripe-js";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";
// import "https://js.stripe.com/v3/";
import "https://code.jquery.com/jquery-3.6.1.js";
const publishableKey = ref(
  "pk_test_51LzJ7MSDa845TZYQzfqsQm2cMJAYtMSkPvoML17VRV6gAsPKQ0u7r9Rf8o621D2BMTZ6YZcWCC1Yhrd1gvU4YS3Z00uGK2CLXW"
);
var sessionId = ref();
// const checkoutRef = ref();

// var loading = false;
// var lineItems =
//   // price: "some-price-id", // The id of the one-time price you created in your Stripe dashboard
//   // quantity: 1,
//   [
//     {
//       price_data: {
//         currency: "inr",
//         unit_amount: props.total * 100,
//         product_data: {
//           name: "Order Payment",
//         },
//       },
//       quantity: 1,
//     },
//   ];

// var successURL = route("manage.carts.checkout");

// var cancelURL = route("manage.carts.checkout");
var paymentMethod = null;
var cardElelement = {};
var stripe = {};

const props = defineProps({
  carts: Object,
  subTotal: String,
  shippingTax: String,
  total: String,
  user: Object,
  intent: Object,
  cartIds: Object,
  //   can: Object,
});
const checkoutForm = useForm({
  name: props.user.name,
  email: props.user.email,
  address: "",
  city: "",
  // postcode: "",
  note: "",
  price: props.total,
  holder_name: "",
  payment_method: paymentMethod,
  cart_ids: props.cartIds,
});

onMounted(() => {
  // alert("l");
  // alert(props.user.name);
  // axios
  //   .post(route("manage.checkout.getStripeSession"), {
  //     price: props.total,
  //   })
  //   .then(async (response) => {
  //     // sessionId = response.data.id;
  //     stripe = await loadStripe(
  //       "pk_test_51LzJ7MSDa845TZYQzfqsQm2cMJAYtMSkPvoML17VRV6gAsPKQ0u7r9Rf8o621D2BMTZ6YZcWCC1Yhrd1gvU4YS3Z00uGK2CLXW"
  //     );
  //     // Swal.fire({
  //     //   title: "Wow!",
  //     //   text: "All Item are removed from cart Successfully!!",
  //     //   icon: "success",
  //     // });
  //     // window.location.href = route("manage.carts.checkout");
  //   });
  stripe = Stripe(
    "pk_test_51M01BbCroadtmyvPAjR4H8TXqX2ct6ShQXurogA5FEkxvCJPnirt4SeSHPFXPSNyqFq6ZHAvwqIugpCxbPgnLGuR005GEfOPxz"
  );

  var elements = stripe.elements();
  var style = {
    base: {
      color: "#32325d",
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: "antialiased",
      fontSize: "16px",
      "::placeholder": {
        color: "#aab7c4",
      },
    },
    invalid: {
      color: "#fa755a",
      iconColor: "#fa755a",
    },
  };
  var card = elements.create("card", {
    style: style,
  });
  console.log(card);
  // alert(card);
  card.mount("#card-element");
  cardElelement = card;
});
const submit = () => {
  checkoutForm.errors.name = "";

  if (!checkoutForm.name) {
    checkoutForm.errors.name = "The name field is required";
  }
  checkoutForm.errors.email = "";

  if (!checkoutForm.email) {
    checkoutForm.errors.email = "The email field is required";
  }
  checkoutForm.errors.address = "";
  if (!checkoutForm.address) {
    checkoutForm.errors.address = "The address field is required";
  }
  checkoutForm.errors.city = "";

  if (!checkoutForm.city) {
    checkoutForm.errors.city = "The city field is required";
  }
  checkoutForm.errors.holder_name = "";

  if (!checkoutForm.holder_name) {
    checkoutForm.errors.holder_name = "The name field is required";
  }

  if (
    checkoutForm.name &&
    checkoutForm.email &&
    checkoutForm.address &&
    checkoutForm.city &&
    checkoutForm.holder_name
  ) {
    if (paymentMethod) {
      return true;
    }
    // console.log(cardElelement);
    stripe
      .confirmCardSetup(props.intent.client_secret, {
        payment_method: {
          card: cardElelement,
          billing_details: {
            // name: $(".card_holder_name").val(),
            name: checkoutForm.holder_name,
          },
        },
      })
      .then(function (result) {
        console.log(result.error);
        // alert(result.setupIntent.payment_method);
        if (result.error) {
          $("#card-errors").text(result.error.message);
          $("button.pay").removeAttr("disabled");
        } else {
          paymentMethod = result.setupIntent.payment_method;
          // alert(paymentMethod);
          // $(".payment-method").val(paymentMethod);
          checkoutForm.payment_method = paymentMethod;

          // $(".card-form").submit();
          checkoutForm.post(route("manage.checkout.purchase"), {
            onFinish: () => console.log(""),
          });
          // .then(async (response) => {
          //   // Swal.fire({
          //   //   title: "Wow!",
          //   //   text: "All Item are removed from cart Successfully!!",
          //   //   icon: "success",
          //   // });
          //   // window.location.href = route("manage.carts.checkout");
          // });
        }
      });
  }
};
const removeFromCheckout = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to remove this item?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post(route("manage.carts.removeFromCheckout"), { id: id })
        .then((response) => {
          // Swal.fire({
          //   title: "Wow!",
          //   text: "All Item are removed from cart Successfully!!",
          //   icon: "success",
          // });
          window.location.href = route("manage.carts.checkout");
        });
    }
  });
};

// let stripe = Stripe("{{ env('STRIPE_KEY') }}");
// alert(stripe);
// let elements = stripe.elements();
// let style = {
//   base: {
//     color: "#32325d",
//     fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
//     fontSmoothing: "antialiased",
//     fontSize: "16px",
//     "::placeholder": {
//       color: "#aab7c4",
//     },
//   },
//   invalid: {
//     color: "#fa755a",
//     iconColor: "#fa755a",
//   },
// };
// let card = elements.create("card", {
//   style: style,
// });
// card.mount("#card-element");
// let paymentMethod = null;
// $(".card-form").on("submit", function (e) {
//   $("button.pay").attr("disabled", true);

//   if (paymentMethod) {
//     return true;
//   }
//   stripe
//     .confirmCardSetup("{{ $intent->client_secret }}", {
//       payment_method: {
//         card: card,
//         billing_details: {
//           name: $(".card_holder_name").val(),
//         },
//       },
//     })
//     .then(function (result) {
//       if (result.error) {
//         $("#card-errors").text(result.error.message);
//         $("button.pay").removeAttr("disabled");
//       } else {
//         paymentMethod = result.setupIntent.payment_method;
//         alert(paymentMethod);
//         $(".payment-method").val(paymentMethod);
//         $(".card-form").submit();
//       }
//     });
//   return false;
// });
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
