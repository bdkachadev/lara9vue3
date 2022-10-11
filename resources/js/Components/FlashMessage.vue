<template>
  <span v-if="type == success">
    {{ success(message) }}
  </span>
  <span v-if="type == error">
    {{ error(message) }}
  </span>
</template>

<script setup>
import Swal from "sweetalert2";

defineProps({
  message: String,
  type: String,
});
const success = (success) => {
  Swal.fire({
    title: "Wow!",
    text: success,
    icon: "success",
  });
};
const error = (error) => {
  Swal.fire({
    title: "Oh!",
    text: error,
    icon: "error",
  });
};
</script>
