<template>
  <Head title="Custom Taxonomy" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">
        Custom Taxonomy
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
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Custom Taxonomy</p>
                    </div>
                  </div>
                  <input v-model="taxonomyForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="name" value="Name" />
                    <BreezeInput
                      id="name"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyForm.name"
                      autofocus
                    />
                    <span className="text-red-600" v-if="taxonomyForm.errors.name">
                      {{ taxonomyForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="slug" value="Slug" />
                    <BreezeInput
                      id="slug"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyForm.slug"
                      autofocus
                    />
                    <span className="text-red-600" v-if="taxonomyForm.errors.slug">
                      {{ taxonomyForm.errors.slug }}
                    </span>
                  </div>
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyForm.description"
                      autofocus
                    />
                    <span className="text-red-600" v-if="taxonomyForm.errors.description">
                      {{ taxonomyForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <button
                      @click="submitTaxonomy"
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                    >
                      Save
                    </button>
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Add/Edit Custom Taxonomy Attribute</p>
                    </div>
                  </div>
                  <input v-model="taxonomyAttributeForm.id" type="hidden" value="" />
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="type" value="Type" />
                    <Multiselect
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      v-model="taxonomyAttributeForm.type"
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
                  <div className="mb-4 mt-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                      v-model="taxonomyAttributeForm.description"
                      autofocus
                    />

                    <span
                      className="text-red-600"
                      v-if="taxonomyAttributeForm.errors.description"
                    >
                      {{ taxonomyAttributeForm.errors.description }}
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
              <div class="grid grid-cols-2 gap-1">
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Custom Taxonomy Lists</p>
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
                        v-for="taxonomy in taxonomiesData"
                        className="overflow-y-scroll"
                      >
                        <td scope="col" className="py-3 px-6">
                          {{ taxonomy.taxonomy_name }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          {{ taxonomy.taxonomy_slug }}
                        </td>

                        <td scope="col" className="py-3 px-6">
                          {{ taxonomy.taxonomy_description }}
                        </td>

                        <td scope="col" className="py-3 px-6">
                          <a
                            @click="editTaxonomy(taxonomy.id)"
                            className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            @click="destroyTaxonomy(taxonomy.id)"
                            className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="attributesData.links" />
                  </div> -->
                  <div
                    className="mt-5 flex justify-center"
                    v-if="taxonomiesData.length <= 0"
                  >
                    No found records!
                  </div>
                </div>
                <div>
                  <div className="bg-white border-b border-gray-200">
                    <div className="flow-root">
                      <p className="float-left">Taxonomy's Attribute Lists</p>
                    </div>
                  </div>
                  <table
                    className="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                  >
                    <thead
                      className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                      <tr>
                        <th scope="col" className="py-3 px-6">Name</th>
                        <th scope="col" className="py-3 px-6">Slug</th>

                        <th scope="col" className="py-3 px-6">Desctiption</th>
                        <th scope="col" className="py-3 px-6">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="attributeValue in taxonomyAttributeData">
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.attribute_name }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.attribute_slug }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          {{ attributeValue.attribute_description }}
                        </td>
                        <td scope="col" className="py-3 px-6">
                          <a
                            @click="editTaxonomyAttribute(attributeValue.id)"
                            className="ml-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                          >
                            Edit
                          </a>
                          <a
                            @click="destroyTaxonomyAttribute(attributeValue.id)"
                            className="ml-2 font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <div className="float-right">
                    <Pagination class="mt-6" :links="attributesValueData.links" />
                  </div> -->
                  <div
                    v-if="taxonomyAttributeData.length <= 0"
                    className="mt-5 flex justify-center"
                  >
                    No found records!
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
import { useForm, Head } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
  taxonomiesOption: Object,
  taxonomiesData: Object,
  taxonomyAttributeData: Object,
});

const taxonomyAttributeForm = useForm({
  id: "",
  type: "",
  name: "",
  description: "",
  slug: "",
});
const taxonomyForm = useForm({
  id: "",
  name: "",
  description: "",
  slug: "",
});

const submitTaxonomy = (event) => {
  taxonomyForm.post(route("manage.customTaxonomy.store"), {
    onFinish: () => event.target.reset(),
  });
};
const submitTaxonomyAttribute = (event) => {
  taxonomyAttributeForm.post(route("manage.taxonomyAttribute.store"), {
    onFinish: () => event.target.reset(),
  });
};

const destroyTaxonomy = (id) => {
  Swal.fire({
    title: "Warning!",
    text: "Are you s  ure you want to delete this?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      taxonomyForm.delete(route("manage.customTaxonomy.destroy", id));
    }
  });
};

const editTaxonomy = (id) => {
  axios.get(route("manage.customTaxonomy.edit", id)).then((res) => {
    taxonomyForm.id = res.data.id;
    taxonomyForm.name = res.data.taxonomy_name;
    taxonomyForm.description = res.data.taxonomy_description;
    taxonomyForm.slug = res.data.taxonomy_slug;
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
    confirmButtonText: "Yes, delete it!",
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
    taxonomyAttributeForm.description = res.data.attribute_description;
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
