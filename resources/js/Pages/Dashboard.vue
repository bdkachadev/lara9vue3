<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div
        class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800"
        id="stats"
        role="tabpanel"
        aria-labelledby="stats-tab"
      >
        <dl
          class="grid grid-cols-2 gap-8 p-4 mx-auto max-w-screen-xl text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8"
        >
          <div class="flex flex-col justify-center items-center">
            <dt class="mb-2 text-3xl font-extrabold">{{ usersCount }}</dt>
            <dd class="font-light text-gray-500 dark:text-gray-400">Users</dd>
          </div>
          <div class="flex flex-col justify-center items-center">
            <dt class="mb-2 text-3xl font-extrabold">{{ productsCount }}</dt>
            <dd class="font-light text-gray-500 dark:text-gray-400">Products</dd>
          </div>
          <div class="flex flex-col justify-center items-center">
            <dt class="mb-2 text-3xl font-extrabold">{{ ordersCount }}</dt>
            <dd class="font-light text-gray-500 dark:text-gray-400">Orders</dd>
          </div>
        </dl>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { Inertia } from "@inertiajs/inertia";

defineProps({
  ordersCount: String,
  productsCount: String,
  usersCount: String,
});
</script>
