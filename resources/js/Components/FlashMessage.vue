<template>
  <div class="container mx-auto space-y-5">
    <!-- Alert Success  -->
    <div
      v-if="type === 'success'"
      v-show="show"
      class="flex justify-between text-green-200 shadow-inner rounded p-3 bg-green-600"
    >
      <p class="self-center"><strong>Wow! </strong>{{ message }}</p>
      <strong class="text-xl align-center cursor-pointer alert-del" @click="show = !show"
        >&times;</strong
      >
    </div>

    <!-- Alert Warning  -->
    <div
      v-if="type === 'warning'"
      v-show="show"
      class="flex justify-between text-yellow-200 shadow-inner rounded p-3 bg-yellow-600"
    >
      <p class="self-center"><strong>Warning! </strong>{{ message }}</p>
      <strong class="text-xl align-center cursor-pointer alert-del" @click="show = !show"
        >&times;</strong
      >
    </div>

    <!-- Alert Danger  -->
    <div
      v-if="type === 'error'"
      v-show="show"
      class="flex justify-between text-red-200 shadow-inner rounded p-3 bg-red-600"
    >
      <p class="self-center"><strong>Oh! </strong>{{ message }}</p>
      <strong class="text-xl align-center cursor-pointer alert-del" @click="show = !show"
        >&times;</strong
      >
    </div>
  </div>
</template>

<script setup>
import Swal from "sweetalert2";

const props = defineProps({
  message: String,
  type: String,
  show: Boolean,
});
</script>
