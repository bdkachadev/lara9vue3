<template>
  <Disclosure
    v-if="objSub.sub_categories"
    v-for="(subCat, optionSubIdx) in objSub.sub_categories"
    :key="subCat.id"
    class="border-b border-gray-200 py-2"
    as="div"
    v-slot="{ open }"
  >
    <input
      :id="`filter-${objSub.id}-${optionSubIdx}`"
      :name="`${subCat.id}[]`"
      :value="subCat.id"
      type="checkbox"
      :checked="subCat.checked"
      className="ml-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
    />

    <label
      :for="`filter-${objSub.id}-${optionSubIdx}`"
      className="ml-3 text-sm text-gray-600 cursor-pointer"
      >{{ subCat.name }}
    </label>

    <DisclosureButton
      v-if="can.edit_category"
      class="items-center justify-between bg-white text-sm text-blue-900 hover:text-blue-900"
      @click="onClickEditButton(subCat.id)"
    >
      <span class="ml-6 flex items-center">
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
            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
          />
        </svg>
      </span>
    </DisclosureButton>
    <DisclosureButton
      @click="onClickDestroyButton(subCat.id)"
      v-if="can.delete_category"
      class="items-center justify-between bg-white text-sm text-red-900 hover:text-red-900"
    >
      <span class="ml-6 flex items-center">
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
            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"
          />
        </svg>
      </span>
    </DisclosureButton>

    <DisclosureButton
      class="items-center justify-between bg-white text-sm text-gray-400 hover:text-gray-500"
    >
      <span class="ml-6 flex items-center">
        <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
        <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
      </span>
    </DisclosureButton>
    <DisclosurePanel class="pt-2">
      <SubCategory
        :data="subCat.id"
        :can="can"
        @emitForDestroyEvent="destroyCategory"
        @emitForEditEvent="editCategory"
      />
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SubCategory from "@/Pages/Category/SubCategory.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";

import Swal from "sweetalert2";
import axios from "axios";

import { computed, ref, onBeforeMount, onMounted, onUnmounted, defineEmits } from "vue";
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";

import {
  ChevronDownIcon,
  FunnelIcon,
  MinusIcon,
  PlusIcon,
  Squares2X2Icon,
} from "@heroicons/vue/20/solid";
const props = defineProps({
  can: Object,
  data: String,
});
const emits = defineEmits(["emitForDestroyEvent", "emitForEditEvent"]);
const objSub = ref({});
const showButton = ref(false);

// const objSub = computed(() => {
//   alert(props.data);
//   axios
//     .post(route("manage.general.getSubCatObject"), { category_id: props.data })
//     .then((response) => {
//       return response.data;
//       console.log(response);
//     });
// });

// onMounted(() =>
//   axios
//     .post(route("manage.general.getSubCatObject"), { category_id: props.data })
//     .then((response) => {
//       return response.data;
//       console.log(response);
//     })
// );
// onUnmounted(() =>
//   axios
//     .post(route("manage.general.getSubCatObject"), { category_id: props.data })
//     .then((response) => {
//       return response.data;
//       console.log(response);
//     })
// );
onBeforeMount(async () => {
  // alert(props.data);
  await axios
    .post(route("manage.general.getSubCatObject"), { category_id: props.data })
    .then((response) => {
      console.log(response.data.sub_categories.length);
      objSub.value = response.data;
      console.log(response.data.sub_categories.length);
      if (response.data.sub_categories.length > 0) {
        showButton.value = true;
      }
    });
});

const onClickEditButton = (id) => {
  emits("emitForEditEvent", id);
};
const onClickDestroyButton = (id) => {
  emits("emitForDestroyEvent", id);
};
const destroyCategory = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to delete this?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("manage.categories.destroy", id));
    }
  });
};
</script>
