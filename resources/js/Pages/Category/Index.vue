<template>
  <Head title="Categories" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
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
          <div v-if="can.add || can.edit">
            <div className="p-6 bg-white border-b border-gray-200">
              <div className="flow-root">
                <p className="float-left">Add / Edit Category</p>
              </div>
            </div>
            <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
              <form
                ref="formPermission"
                className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
                @submit.prevent="submitCategory"
              >
                <input v-model="categoryForm.id" type="hidden" value="" />
                <div className="mb-4">
                  <BreezeLabel for="name" value="Name" />
                  <BreezeInput
                    id="name"
                    type="text"
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="categoryForm.name"
                    autofocus
                  />

                  <span className="text-red-600" v-if="categoryForm.errors.name">
                    {{ categoryForm.errors.name }}
                  </span>
                </div>
                <div className="mb-4">
                  <!-- <BreezeLabel for="permission" value="categories" />
                <select
                  id="permission"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="roleForm.permission"
                >
                  <option value="">Select Permission</option>
                  <option
                    value="permission.name"
                    v-for="permission in categories"
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
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Assign Role to Permission</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formassignRole"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @submit.prevent="submitassignRole"
            >
              <div className="mb-4">
                <BreezeLabel for="role" value="Roles" />
                <select
                  id="role"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="assignRoleForm.role"
                >
                  <option value="">Select Role</option>
                  <option value="role.name" v-for="role in roles" :key="role.id">
                    {{ role.name }}
                  </option>
                </select>

                <span className="text-red-600" v-if="assignRoleForm.errors.name">
                  {{ assignRoleForm.errors.name }}
                </span>
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
        </div> -->
      </div>
    </div>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Categories List</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Category name</th>
                  <th v-if="can.delete || can.edit" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="category in categories"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th scope="row" className="py-4 px-6">
                    {{ category.name }}
                  </th>

                  <td className="py-4 px-6">
                    <a
                      v-if="can.edit"
                      @click="editCategory(category.id)"
                      className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      v-if="can.delete"
                      @click="destroyCategory(category.id)"
                      className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                      >Delete</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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

defineProps({
  categories: Object,
  can: Object,
});
const categoryForm = useForm({
  name: "",
  id: "",
});

const submitCategory = (event) => {
  console.warn(categoryForm);
  categoryForm.post(route("manage.categories.store"), {
    // onFinish: () => event.target.reset(),
  });
};
const submitassignRoleForm = (event) => {
  assignRoleForm.post(route("manage.categories.roles.assign"), {
    onFinish: () => event.target.reset(),
  });
};
const editCategory = (id) => {
  axios.get(route("manage.categories.edit", id)).then((res) => {
    categoryForm.id = res.data.id;
    categoryForm.name = res.data.name;
  });
};

const destroyCategory = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you sure you want to delete this?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      categoryForm.delete(route("manage.categories.destroy", id));
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
