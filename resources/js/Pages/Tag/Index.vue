<template>
  <Head title="Tags" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Tags</h2>
    </template>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <!-- <div class="p-5 text-center"> --> <div>
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
                <p className="float-left">Add / Edit Tag</p>
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
                @submit.prevent="submitTag"
              >
                <input v-model="tagForm.id" type="hidden" value="" />
                <div className="mb-4">
                  <BreezeLabel for="name" value="Name" />
                  <BreezeInput
                    id="name"
                    type="text"
                    placeholder="Enter name"
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="tagForm.name"
                    autofocus
                  />

                  <span className="text-red-600" v-if="tagForm.errors.name">
                    {{ tagForm.errors.name }}
                  </span>
                </div>

                <div className="mb-4">
                  <BreezeLabel for="slug" value="Slug" />
                  <BreezeInput
                    id="slug"
                    placeholder="Enter slug"
                    type="text"
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="tagForm.slug"
                    autofocus
                  />

                  <span className="text-red-600" v-if="tagForm.errors.slug">
                    {{ tagForm.errors.slug }}
                  </span>
                </div>

                <div className="mb-4">
                  <BreezeLabel for="description" value="Description" />
                  <BreezeInput
                    id="description"
                    placeholder="Enter description"
                    type="text"
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="tagForm.description"
                    autofocus
                  />

                  <span className="text-red-600" v-if="tagForm.errors.description">
                    {{ tagForm.errors.description }}
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
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
    </div>
    <div className="py-8">
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Tags List</p>
            </div>
          </div>
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Tag name</th>
                  <th scope="col" className="py-3 px-6">Tag slug</th>
                  <th scope="col" className="py-3 px-6">Tag description</th>

                  <th v-if="can.delete || can.edit" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="tag in tags.data"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th scope="row" className="py-4 px-6">
                    {{ tag.name }}
                  </th>
                  <th scope="row" className="py-4 px-6">
                    {{ tag.slug }}
                  </th>
                  <th scope="row" className="py-4 px-6">
                    {{ tag.description }}
                  </th>

                  <td className="py-4 px-6">
                    <a
                      v-if="can.edit"
                      @click="editTag(tag.id)"
                      className="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      v-if="can.delete"
                      @click="destroyTag(tag.id)"
                      className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                      >Delete</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <div className="float-right">
              <Pagination class="mt-6" :links="tags.links" />
            </div>
            <div v-if="tags.data.length <= 0" className="mt-5 flex justify-center">
              No records found!
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";

defineProps({
  tags: Object,
  can: Object,
});
const tagForm = useForm({
  name: "",
  description: "",
  slug: "",
  id: "",
});

const submitTag = (event) => {
  console.warn(tagForm);
  tagForm.post(route("manage.tags.store"), {
    // onFinish: () => event.target.reset(),
  });
};
const submitassignRoleForm = (event) => {
  assignRoleForm.post(route("manage.tags.roles.assign"), {
    onFinish: () => event.target.reset(),
  });
};
const editTag = (id) => {
  axios.get(route("manage.tags.edit", id)).then((res) => {
    tagForm.id = res.data.id;
    tagForm.name = res.data.name;
  });
};

const destroyTag = (id) => {
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
      tagForm.delete(route("manage.tags.destroy", id));
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
