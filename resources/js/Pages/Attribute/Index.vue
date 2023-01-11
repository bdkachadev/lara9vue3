<template>
  <Head title="Attribute" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Attribute</h2>
    </template>
    <div>
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="text-center">
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
          <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <div className="bg-white shadow-md rounded px-8 py-3  ">
              <div class="grid grid-cols-1 gap-2">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Attribute</p>
                      <Link
                        class="float-right bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                        :href="route('manage.attributesValue.index')"
                        >Back</Link
                      >
                    </div>
                  </div>
                  <input v-model="attributeForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="attributeForm.name"
                      placeholder="Enter name"
                      autofocus
                    />
                    <span className="text-red-600" v-if="attributeForm.errors.name">
                      {{ attributeForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="slug" value="Slug" />
                    <BreezeInput
                      id="slug"
                      type="text"
                      placeholder="Enter slug"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="attributeForm.slug"
                      autofocus
                    />
                    <span className="text-red-600" v-if="attributeForm.errors.slug">
                      {{ attributeForm.errors.slug }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="attributeForm.description"
                      placeholder="Enter description"
                      autofocus
                    />
                    <span
                      className="text-red-600"
                      v-if="attributeForm.errors.description"
                    >
                      {{ attributeForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button
                      @click="submitAttribute"
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                    >
                      Save
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 ">
              <div class="grid grid-cols-1 gap-1">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Attribute Lists</p>
                    </div>
                  </div>

                  <table
                    className="w-full text-sm text-left text-gray-500 dark:text-gray-400 "
                  >
                    <thead
                      className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Slug</th>
                        <th scope="col" className="py-3 px-6">Description</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="attribute in attributesData.data"
                        className="overflow-y-scroll"
                      >
                        <td scope="col" className="py-3 px-6">{{ attribute.name }}</td>
                        <td scope="col" className="py-3 px-6">{{ attribute.slug }}</td>
                        <td scope="col" className="py-3 px-6">
                          {{ attribute.description }}
                        </td>

                        <td scope="col" className="py-3 px-6">
                          <a
                            v-if="can.edit"
                            @click="editAttribute(attribute.id)"
                            className="cursor-pointer ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            v-if="can.delete"
                            @click="destroyAttribute(attribute.id)"
                            className="cursor-pointer ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                            >delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="float-right">
                    <Pagination class="mt-6" :links="attributesData.links" />
                  </div>
                  <div
                    v-if="attributesData.length <= 0"
                    className="mt-5 flex justify-center"
                  >
                    No records found!
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
  attributesData: Object,
  can: Object,
});
const attributeForm = useForm({
  id: "",
  name: "",
  slug: "",
  description: "",
});
const submitAttribute = (event) => {
  attributeForm.post(route("manage.attributes.store"), {
    onFinish: () => event.target.reset(),
  });
};

const destroyAttribute = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you s  ure you want to delete this?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      attributeForm.delete(route("manage.attributes.destroy", id));
    }
  });
};

const editAttribute = (id) => {
  axios.get(route("manage.attributes.edit", id)).then((res) => {
    attributeForm.id = res.data.id;
    attributeForm.name = res.data.name;
    attributeForm.slug = res.data.slug;
    attributeForm.description = res.data.description;
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
