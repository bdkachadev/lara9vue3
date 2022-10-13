<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
    </template>
    <span v-if="$page.props.flash.success">
      {{ success($page.props.flash.success) }}
    </span>
    <span v-if="$page.props.flash.error">
      {{ error($page.props.flash.error) }}
    </span>
    <div class="py-8 flex">
      <div class="max-w-7xl mx-auto sm:px-12 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flow-root">
              <p class="float-left">Add / Edit Roles</p>
            </div>
          </div>
          <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formRole"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @submit.prevent="submitRole"
            >
              <input v-model="roleForm.id" type="hidden" value="" />
              <div className="mb-4">
                <BreezeLabel for="name" value="Name" />
                <BreezeInput
                  id="name"
                  type="text"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="roleForm.name"
                  autofocus
                />

                <span className="text-red-600" v-if="roleForm.errors.name">
                  {{ roleForm.errors.name }}
                </span>
              </div>
              <div className="mb-4">
                <!-- <BreezeLabel for="permission" value="Permissions" />
                <select
                  id="permission"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
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
                  <label class="typo__label">Permission Given to Role</label>
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
                        class="multiselect__single"
                        v-if="roleForm.permission.length &amp;&amp; !isOpen"
                        >{{ roleForm.permission.length }} options selected</span
                      ></template
                    >
                  </multiselect> 
                  <pre class="language-json"><code>{{ value  }}</code></pre> -->

                  <Multiselect
                    mode="tags"
                    :close-on-select="false"
                    :searchable="true"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    :create-option="true"
                    v-model="roleForm.permission"
                    :options="options"
                  />
                </div>
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
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flow-root">
              <p class="float-left">Given Permission to Role</p>
            </div>
          </div>
          <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formgivenPermission"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @submit.prevent="submitgivenPermission"
            >
              <div className="mb-4">
                <BreezeLabel for="permission" value="Permissions" />
                <select
                  id="permission"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                  v-model="givenPermissionForm.permission"
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

                <span className="text-red-600" v-if="givenPermissionForm.errors.name">
                  {{ givenPermissionForm.errors.name }}
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
        </div> -->
      </div>
    </div>
    <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flow-root">
              <p class="float-left">Role List</p>
            </div>
          </div>
          <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="py-3 px-6">Role name</th>
                  <th scope="col" class="py-3 px-6">Given Permissions</th>
                  <th scope="col" class="py-3 px-6">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="role in roles"
                  class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ role.name }}
                  </th>

                  <th
                    scope="row"
                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{
                      role.permissions.length > 0
                        ? role.permissions.map((item) => item.name)
                        : ""
                    }}
                  </th>

                  <td class="py-4 px-6">
                    <a
                      @click="updateRole(role.id)"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      @click="deleteRole(role.id)"
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
import Multiselect from "@vueform/multiselect";

defineProps({
  roles: Object,
  permissions: Object,
  options: Object,
});

const roleForm = useForm({
  name: "",
  id: "",
  permission: null,
});
// const givenPermissionForm = useForm({
//   permission: "",
// });

// const value = null;
// const options = ["Batman", "Robin", "Joker"];

// const options = computed((permissions) => {
//   console.warn(permissions);
//   var arrNames = [];
//   //iterate through object keys
//   Object.keys(permissions).forEach(function (key) {
//     //get the value of name
//     var val = permissions[key]["name"];
//     //push the name string in the array
//     arrNames.push(val);
//   });
//   return arrNames;
//   console.log(arrNames); //prints ["someone1", "someone2"]
// });
const submitRole = (event) => {
  roleForm.post(route("manage.roles.store"), {
    onFinish: () => event.target.reset(),
  });
};
const submitgivenPermission = (event) => {
  givenPermissionForm.post(route("manage.roles.permissions.given"), {
    onFinish: () => event.target.reset(),
  });
};

const updateRole = (id) => {
  axios
    .get(route("manage.roles.edit"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      var permissions = res.data.permissions.map((item) => item.name);
      roleForm.id = res.data.id;
      roleForm.name = res.data.name;
      roleForm.permission = permissions;
    });
};

const deleteRole = (id) => {
  axios
    .get(route("manage.roles.delete"), {
      params: {
        id: id,
      },
    })
    .then((res) => {
      Swal.fire({
        title: "Wow!",
        text: "Role Successfully Deleted!!!",
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
