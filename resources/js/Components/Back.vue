<template>
  <Link :href="route('manage.products.create')">Back</Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
  components: {
    Link,
  },
});
</script>
