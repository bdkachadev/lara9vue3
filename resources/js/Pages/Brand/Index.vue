<template>
  <Head title="Brands" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Brands</h2>
    </template>
    <div class="grid gap-4 grid-cols-2">
      <div className="py-8">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- <div class="p-5 text-center"> -->
            <div>
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
            <div v-if="can.add || can.edit_brand">
              <div className="p-6 bg-white border-b border-gray-200">
                <div className="flow-root">
                  <p className="float-left">Add / Edit Brand</p>
                  <Link
                    class="float-right bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                    :href="route('manage.products.create')"
                    >Back</Link
                  >
                </div>
              </div>
              <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
                <form
                  ref="formPermission"
                  className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
                  @submit.prevent="submitBrand"
                >
                  <input v-model="brandForm.id" type="hidden" value="" />
                  <div className="mb-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="brandForm.name"
                      placeholder="Enter name"
                      autofocus
                    />

                    <span className="text-red-600" v-if="brandForm.errors.name">
                      {{ brandForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="slug" value="Slug" />
                    <BreezeInput
                      id="slug"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="brandForm.slug"
                      placeholder="Enter slug"
                      autofocus
                    />

                    <span className="text-red-600" v-if="brandForm.errors.slug">
                      {{ brandForm.errors.slug }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="brandForm.description"
                      placeholder="Enter description"
                      autofocus
                    />

                    <span className="text-red-600" v-if="brandForm.errors.description">
                      {{ brandForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <!-- <BreezeLabel for="permission" value="brands" />
                <select
                  id="permission"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="roleForm.permission"
                >
                  <option value="">Select Permission</option>
                  <option
                    value="permission.name"
                    v-for="permission in brands"
                    :key="permission.id"
                  >
                    {{ permission.name }}
                  </option>
                </select>

                <span className="text-red-600" v-if="roleForm.errors.name">
                  {{ roleForm.errors.name }}
                </span> -->
                  </div>
                  <div className="flex items-center justify-between">
                    <button
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="submit"
                    >
                      Save
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
      </div>

      <div className="pt-2 pb-8">
        <div className="max-w-9xl mx-auto sm:px-6 lg:px-4">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 bg-white border-b border-gray-200">
              <div className="flow-root">
                <p className="float-left">Brands List</p>
              </div>
            </div>
            <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
              <table
                className="w-full text-sm text-left text-gray-500 dark:text-gray-400"
              >
                <thead
                  className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th scope="col" className="py-3 px-6">Brand name</th>
                    <th scope="col" className="py-3 px-6">Brand slug</th>
                    <th scope="col" className="py-3 px-6">Brand description</th>

                    <th
                      v-if="can.delete_brand || can.edit_brand"
                      scope="col"
                      className="py-3 px-6"
                    >
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="brand in brands.data"
                    className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                  >
                    <th scope="row" className="py-4 px-6">
                      {{ brand.name }}
                    </th>
                    <th scope="row" className="py-4 px-6">
                      {{ brand.slug }}
                    </th>
                    <th scope="row" className="py-4 px-6">
                      {{ brand.description }}
                    </th>

                    <td className="py-4 px-6">
                      <a
                        v-if="can.edit_brand"
                        @click="editBrand(brand.id)"
                        className="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline"
                        >Edit</a
                      >
                      <a
                        v-if="can.delete_brand"
                        @click="destroyBrand(brand.id)"
                        className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <div className="float-right">
                <!-- <Pagination class="mt-6" :links="brands.links" /> -->
              </div>
              <div v-if="brands.data.length <= 0" className="mt-5 flex justify-center">
                No records found!
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
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";
import { computed, ref, onBeforeMount, onMounted, onUnmounted, defineEmits } from "vue";

const props = defineProps({
  brands: Object,
  can: Object,
});
const brandForm = useForm({
  name: "",
  id: "",
  slug: "",
  description: "",
});

const filters = [
  {
    id: "brand",
    name: "Brand",
    options: props.brands,
  },
];

const submitBrand = (event) => {
  console.warn(brandForm);
  brandForm.post(route("manage.brands.store"), {
    // onFinish: () => event.target.reset(),
  });
};
const submitassignRoleForm = (event) => {
  assignRoleForm.post(route("manage.brands.roles.assign"), {
    onFinish: () => event.target.reset(),
  });
};
const editBrand = (id) => {
  axios.get(route("manage.brands.edit", id)).then((res) => {
    brandForm.id = res.data.id;
    brandForm.name = res.data.name;
    brandForm.description = res.data.description;
    brandForm.slug = res.data.slug;
  });
};

const destroyBrand = (id) => {
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
      brandForm.delete(route("manage.brands.destroy", id));
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
