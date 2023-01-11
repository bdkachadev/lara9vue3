<template>
  <Head title="Taxonomy Attribute" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">
        Taxonomy Attribute
      </h2>
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
                      <p className="float-left">Add/Edit Custom Taxonomy Attribute</p>
                      <Link
                        class="float-right bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                        :href="route('manage.products.create')"
                        >Back</Link
                      >
                    </div>
                  </div>
                  <input v-model="taxonomyAttributeForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <!-- <BreezeLabel for="type" value="Custom Taxonomy Type" /> -->
                    <label class="block font-medium text-sm text-gray-700" for="brand">
                      <span
                        >Custom Taxonomy Type
                        <Link
                          :href="route('manage.customTaxonomy.index')"
                          className="text text-indigo-600 cursor-pointer"
                          >&nbsp;Add new</Link
                        >
                      </span>
                    </label>
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="taxonomyAttributeForm.type"
                      placeholder="-- Custom Taxonomy --"
                      :options="taxonomiesOption"
                    />
                    <span
                      className="text-red-600"
                      v-if="taxonomyAttributeForm.errors.type"
                    >
                      {{ taxonomyAttributeForm.errors.type }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput
                      placeholder="Enter name"
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyAttributeForm.name"
                      autofocus
                    />

                    <span
                      className="text-red-600"
                      v-if="taxonomyAttributeForm.errors.name"
                    >
                      {{ taxonomyAttributeForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="slug" value="Slug" />
                    <BreezeInput
                      id="slug"
                      placeholder="Enter slug"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyAttributeForm.slug"
                      autofocus
                    />

                    <span
                      className="text-red-600"
                      v-if="taxonomyAttributeForm.errors.slug"
                    >
                      {{ taxonomyAttributeForm.errors.slug }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button
                      @click="submitTaxonomyAttribute"
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
                      <p className="float-left">
                        {{ canTaxonomyAttribute }}Taxonomy's Attribute Lists
                      </p>
                    </div>
                  </div>
                  <table
                    className="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                  >
                    <thead
                      className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                      <tr>
                        <th scope="col" className="py-3 px-6">Taxonomy Name</th>
                        <th scope="col" className="py-3 px-6">Attribute Name</th>
                        <th scope="col" className="py-3 px-6">Slug</th>

                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="attributeValue in taxonomyAttributeData.data">
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.taxonomy.taxonomy_name }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.attribute_name }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.attribute_slug }}
                        </td>

                        <td scope="col" className="py-3 px-6">
                          <a
                            v-if="can.edit"
                            @click="editTaxonomyAttribute(attributeValue.id)"
                            className="ml-2 cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            v-if="can.delete"
                            @click="destroyTaxonomyAttribute(attributeValue.id)"
                            className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="float-right">
                    <Pagination class="mt-6" :links="taxonomyAttributeData.links" />
                  </div>

                  <div
                    v-if="taxonomyAttributeData.data.length <= 0"
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
import { Link, useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";
const props = defineProps({
  taxonomiesOption: Object,
  can: Object,
  taxonomiesData: Object,
  taxonomyAttributeData: Object,
});

const taxonomyAttributeForm = useForm({
  id: "",
  type: "",
  name: "",
  slug: "",
});

const submitTaxonomyAttribute = (event) => {
  taxonomyAttributeForm.post(route("manage.taxonomyAttribute.store"), {
    onFinish: () => event.target.reset(),
  });
};

const destroyTaxonomyAttribute = (id) => {
  console.log(id);
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
      // alert(id);
      taxonomyAttributeForm.delete(route("manage.taxonomyAttribute.destroy", id));
    }
  });
};

const editTaxonomyAttribute = (id) => {
  console.log(id);

  axios.get(route("manage.taxonomyAttribute.edit", id)).then((res) => {
    console.log(res.data);
    taxonomyAttributeForm.id = res.data.id;
    taxonomyAttributeForm.name = res.data.attribute_name;
    taxonomyAttributeForm.type = res.data.taxonomy_id;
    taxonomyAttributeForm.slug = res.data.attribute_slug;
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
