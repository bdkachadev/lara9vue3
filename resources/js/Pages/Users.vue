<template>
  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
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
        <div v-if="can.edit" v-show="editShow">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Edit User</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formUser"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
              @submit.prevent="submitUser"
            >
              <input v-model="userForm.id" type="hidden" value="" />
              <div className="mb-4">
                <BreezeLabel for="name" value="Name" />
                <BreezeInput
                  id="title"
                  type="text"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="userForm.name"
                  autofocus
                />

                <span className="text-red-600" v-if="userForm.errors.name">
                  {{ userForm.errors.name }}
                </span>
              </div>
              <div className="mb-2">
                <BreezeLabel for="name" value="Email" />
                <BreezeInput
                  id="email"
                  type="email"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="userForm.email"
                  autofocus
                />

                <span className="text-red-600" v-if="userForm.errors.email">
                  {{ userForm.errors.email }}
                </span>
              </div>
              <div className="mb-2">
                <BreezeLabel for="name" value="Assign Role To User" />
                <Multiselect
                  :close-on-select="false"
                  :searchable="true"
                  :create-option="true"
                  v-model="userForm.role"
                  :options="options"
                />

                <span className="text-red-600" v-if="userForm.errors.email">
                  {{ userForm.errors.email }}
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
        </div>
      </div>
    </div>
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div className="p-6 bg-white border-b border-gray-200">
          <div className="flow-root">
            <p className="float-left">User List</p>
          </div>
        </div>
        <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
          <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" className="py-3 px-6">User name</th>
                <th scope="col" className="py-3 px-6">Email</th>
                <th scope="col" className="py-3 px-6">Role</th>
                <th v-if="can.edit || can.delete" scope="col" className="py-3 px-6">
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="user in users.data"
                className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
              >
                <th scope="row" className="py-4 px-6">
                  {{ user.name }}
                </th>
                <td className="py-4 px-6">{{ user.email }}</td>
                <td className="py-4 px-6">
                  {{
                    user.roles.length > 0
                      ? user.roles.map((item) => item.name).join(", ")
                      : ""
                  }}
                </td>

                <td className="py-4 px-6">
                  <a
                    v-if="can.edit"
                    @click="editUser(user.id)"
                    className="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline"
                    >Edit</a
                  >
                  <a
                    v-if="can.delete"
                    @click="destroyUser(user.id)"
                    className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                    >Delete</a
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div className="float-right">
            <Pagination class="mt-6" :links="users.links" />
          </div>
          <div v-if="users.data.length <= 0" className="mt-5 flex justify-center">
            No records found!
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
import Pagination from "@/Components/Pagination.vue";

defineProps({
  options: Object,
  users: Object,
  can: Object,
});

const userForm = useForm({
  name: "",
  id: "",
  email: "",
  role: null,
});
var editShow = false;
const submitUser = (event) => {
  userForm.post(route("manage.users.store"), {
    onFinish: () => event.target.reset(),
  });
};

const editUser = (id) => {
  editShow = true;
  axios.get(route("manage.users.edit", id)).then((res) => {
    var roles = res.data.roles.map((item) => item.name);
    console.warn(roles);

    userForm.id = res.data.id;
    userForm.name = res.data.name;
    userForm.email = res.data.email;
    userForm.role = roles;
  });
};

const destroyUser = (id) => {
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
      userForm.delete(route("manage.users.destroy", id));
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
