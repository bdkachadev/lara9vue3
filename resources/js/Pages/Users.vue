<template>
  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <span v-if="$page.props.flash.success">
      {{ success($page.props.flash.success) }}
    </span>
    <span v-if="$page.props.flash.error">
      {{ error($page.props.flash.error) }}
    </span>
    <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flow-root">
              <p class="float-left">Edit User</p>
            </div>
          </div>
          <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formUser"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @submit.prevent="submitUser"
            >
              <input v-model="userForm.id" type="hidden" value="" />
              <div className="mb-4">
                <BreezeLabel for="name" value="Name" />
                <BreezeInput
                  id="title"
                  type="text"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="userForm.name"
                  autofocus
                />

                <span className="text-red-600" v-if="userForm.errors.name">
                  {{ userForm.errors.name }}
                </span>
              </div>
              <div class="mb-2">
                <BreezeLabel for="name" value="Email" />
                <BreezeInput
                  id="email"
                  type="email"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="userForm.email"
                  autofocus
                />

                <span className="text-red-600" v-if="userForm.errors.email">
                  {{ userForm.errors.email }}
                </span>
              </div>
              <div class="flex items-center justify-between">
                <button
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
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
    <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flow-root">
              <p class="float-left">User List</p>
            </div>
          </div>
          <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="py-3 px-6">User name</th>
                  <th scope="col" class="py-3 px-6">Email</th>
                  <th scope="col" class="py-3 px-6">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="user in users"
                  class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ user.name }}
                  </th>
                  <td class="py-4 px-6">{{ user.email }}</td>

                  <td class="py-4 px-6">
                    <a
                      @click="updateUser(user.id)"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      href="#"
                      class="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
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

defineProps({
  users: Object,
});

const userForm = useForm({
  name: "",
  id: "",
  email: "",
});

const submitUser = (event) => {
  userForm.post(route("manage.users.store"), {
    onFinish: () => event.target.reset(),
  });
};

const updateUser = (id) => {
  axios
    .get(route("manage.users.edit"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      userForm.id = res.data.id;
      userForm.name = res.data.name;
      userForm.email = res.data.email;
    });
};

const deleteUser = (id) => {
  axios
    .get(route("manage.users.edit"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      userForm.id = res.data.id;
      userForm.name = res.data.name;
      userForm.email = res.data.email;
    });
};
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