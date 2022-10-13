<template>
  <Head title="Permissions" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Permissions</h2>
    </template>
    <span v-if="$page.props.flash.success">
      {{ success($page.props.flash.success) }}
    </span>
    <span v-if="$page.props.flash.error">
      {{ error($page.props.flash.error) }}
    </span>
    <div className="py-8 ">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Add / Edit Permissions</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formPermission"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 "
              @submit.prevent="submitPermission"
            >
              <input v-model="permissionForm.id" type="hidden" value="" />
              <div className="mb-4">
                <BreezeLabel for="name" value="Name" />
                <BreezeInput
                  id="name"
                  type="text"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="permissionForm.name"
                  autofocus
                />

                <span className="text-red-600" v-if="permissionForm.errors.name">
                  {{ permissionForm.errors.name }}
                </span>
              </div>
              <div className="mb-4">
                <!-- <BreezeLabel for="permission" value="Permissions" />
                <select
                  id="permission"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="roleForm.permission"
                >
                  <option value="">Select Permission</option>
                  <option
                    value="permission.name"
                    v-for="permission in permissions"
                    :key="permission.id"
                  >
                    {{ permission.name }}
                  </option>
                </select>

                <span className="text-red-600" v-if="roleForm.errors.name">
                  {{ roleForm.errors.name }}
                </span> -->

                <div>
                  <BreezeLabel for="name" value="Assign Role to Permission" />
                  <!-- <multiselect
                    v-model="roleForm.permission"
                    :options="options"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    placeholder="Pick some"
                    label="name"
                    track-by="name"
                    :preselect-first="true"
                  >
                    <template slot="selection" slot-scope="{ values, search, isOpen }"
                      ><span
                        className="multiselect__single"
                        v-if="roleForm.permission.length &amp;&amp; !isOpen"
                        >{{ roleForm.permission.length }} options selected</span
                      ></template
                    >
                  </multiselect> 
                  <pre className="language-json"><code>{{ value  }}</code></pre> -->

                  <Multiselect
                    mode="tags"
                    :close-on-select="false"
                    :searchable="true"
                    :create-option="true"
                    v-model="permissionForm.role"
                    :options="options"
                  />
                </div>
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
              <p className="float-left">Permission List</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Permission name</th>
                  <th scope="col" className="py-3 px-6">Assign Roles</th>
                  <th scope="col" className="py-3 px-6">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="permission in permissions"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ permission.name }}
                  </th>

                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{
                      permission.roles.length > 0
                        ? permission.roles.map((item) => item.name)
                        : ""
                    }}
                  </th>

                  <td className="py-4 px-6">
                    <a
                      @click="updatePermission(permission.id)"
                      className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      @click="deletePermission(permission.id)"
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
  roles: Object,
  permissions: Object,
  options: Object,
});
const permissionForm = useForm({
  name: "",
  id: "",
  role: null,
});
// const assignRoleForm = useForm({
//   role: "",
// });

const submitPermission = (event) => {
  permissionForm.post(route("manage.permissions.store"), {
    onFinish: () => event.target.reset(),
  });
};
const submitassignRoleForm = (event) => {
  assignRoleForm.post(route("manage.permissions.roles.assign"), {
    onFinish: () => event.target.reset(),
  });
};
const updatePermission = (id) => {
  axios
    .get(route("manage.permissions.edit"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      var roles = res.data.roles.map((item) => item.name);
      console.warn(roles);
      permissionForm.id = res.data.id;
      permissionForm.name = res.data.name;
      permissionForm.role = roles;
    });
};

const deletePermission = (id) => {
  axios
    .get(route("manage.permissions.delete"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      Swal.fire({
        title: "Wow!",
        text: "Permission Successfully Deleted!!!",
        icon: "success",
      });
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
<style src="@vueform/multiselect/themes/default.css"></style>
