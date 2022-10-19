<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
    </template>

    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-12 lg:px-8">
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
                <p className="float-left">Add / Edit Roles</p>
              </div>
            </div>

            <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
              <form
                ref="formRole"
                className="bg-white shadow-md rounded px-8 pt-6 pb-8"
                @submit.prevent="submitRole"
              >
                <input v-model="roleForm.id" type="hidden" value="" />
                <div className="mb-4">
                  <BreezeLabel for="name" value="Name" />
                  <BreezeInput
                    id="name"
                    type="text"
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
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
                    <BreezeLabel for="name" value="Given Permission To Role" />

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
                      v-model="roleForm.permission"
                      :options="options"
                    />
                    <span className="text-red-600" v-if="roleForm.errors.permission">
                      {{ roleForm.errors.permission }}
                    </span>
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
      </div>
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Given Permission to Role</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <form
              ref="formgivenPermission"
              className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @submit.prevent="submitgivenPermission"
            >
              <div className="mb-4">
                <BreezeLabel for="permission" value="Permissions" />
                <select
                  id="permission"
                  className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
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
              <p className="float-left">Role List</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Role name</th>
                  <th scope="col" className="py-3 px-6">Given Permissions</th>
                  <th v-if="can.edit || can.delete" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="role in roles"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ role.name }}
                  </th>

                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{
                      role.permissions.length > 0
                        ? role.permissions.map((item) => item.name)
                        : ""
                    }}
                  </th>

                  <td className="py-4 px-6">
                    <a
                      v-if="can.edit"
                      @click="editRole(role.id)"
                      className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      v-if="can.delete"
                      @click="destroyRole(role.id)"
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
import { Inertia } from "@inertiajs/inertia";

defineProps({
  roles: Object,
  permissions: Object,
  options: Object,
  errors: Object,
  can: Object,
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

const editRole = (id) => {
  axios.get(route("manage.roles.edit", id)).then((res) => {
    var permissions = res.data.permissions.map((item) => item.name);
    roleForm.id = res.data.id;
    roleForm.name = res.data.name;
    roleForm.permission = permissions;
  });
};

const destroyRole = (id) => {
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
      roleForm.delete(route("manage.roles.destroy", id));
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
