<template>
  <Head title="Categories" />

  <AuthenticatedLayout>
    <template #header>
      <h2 className="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
    </template>
    <div class="grid gap-4 grid-cols-2">
      <div className="pt-8">
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
            <div v-if="can.add || can.edit_category">
              <div className="p-6 bg-white border-b border-gray-200">
                <div className="flow-root">
                  <p className="float-left">Add / Edit Category</p>
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
                      placeholder="Enter name"
                      autofocus
                    />

                    <span className="text-red-600" v-if="categoryForm.errors.name">
                      {{ categoryForm.errors.name }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="slug" value="Slug" />
                    <BreezeInput
                      id="slug"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="categoryForm.slug"
                      placeholder="Enter slug"
                      autofocus
                    />

                    <span className="text-red-600" v-if="categoryForm.errors.slug">
                      {{ categoryForm.errors.slug }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="description" value="Description" />
                    <BreezeInput
                      id="description"
                      type="text"
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="categoryForm.description"
                      placeholder="Enter description"
                      autofocus
                    />

                    <span className="text-red-600" v-if="categoryForm.errors.description">
                      {{ categoryForm.errors.description }}
                    </span>
                  </div>
                  <div className="mb-4">
                    <BreezeLabel for="parentcat" value="Parent Category" />
                    <Multiselect
                      id="parentcat"
                      v-model="categoryForm.parent_id"
                      :close-on-select="true"
                      :searchable="true"
                      :create-option="true"
                      :options="parentCategories"
                      placeholder="-- None --"
                    />
                    <span className="text-red-600" v-if="categoryForm.errors.parent_id">
                      {{ categoryForm.errors.parent_id }}
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
      <div className="pt-2 pb-8">
        <div className="max-w-9xl mx-auto sm:px-6 lg:px-4">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- <div className="p-6 bg-white border-b border-gray-200">
            <div className="flow-root">
              <p className="float-left">Categories List</p>
            </div>
          </div> -->
            <!-- <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" className="py-3 px-6">Parent of</th>

                  <th scope="col" className="py-3 px-6">Category Name</th>
                  <th scope="col" className="py-3 px-6">Category Slug</th>
                  <th scope="col" className="py-3 px-6">Category Descripton</th>
                  <th v-if="can.delete || can.edit" scope="col" className="py-3 px-6">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="category in categories.data"
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th scope="row" className="py-4 px-6">
                    {{ category.parent_category ? category.parent_category.name : null }}
                  </th>
                  <th scope="row" className="py-4 px-6">
                    {{ category.name }}
                  </th>
                  <th scope="row" className="py-4 px-6">
                    {{ category.slug }}
                  </th>
                  <th scope="row" className="py-4 px-6">
                    {{ category.description }}
                  </th>

                  <td className="py-4 px-6">
                    <a
                      v-if="can.edit"
                      @click="editCategory(category.id)"
                      className="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline"
                      >Edit</a
                    >
                    <a
                      v-if="can.delete"
                      @click="destroyCategory(category.id)"
                      className="ml-2 cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                      >Delete</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <div className="float-right">
              <Pagination class="mt-6" :links="categories.links" />
            </div>
            <div v-if="categories.data.length <= 0" className="mt-5 flex justify-center">
              No records found!
            </div>
          </div> -->

            <section aria-labelledby="products-heading" class="pt-6 pb-6">
              <!-- <h2 id="products-heading" class="sr-only1">Products</h2> -->

              <!-- Filters -->
              <!-- <form class="hidden lg:block border-r border-b border-l border-gray-400 lg:border-t lg:border-gray-300 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"> -->
              <!-- <h3 class="sr-only1">Filter By</h3> -->

              <Disclosure
                as="div"
                v-for="section in filters"
                :key="section.id"
                className="border-b border-gray-200 py-2 cursor-pointer"
                v-slot="{ open }"
              >
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="py-2 flex w-full items-center justify-between bg-white text-sm text-gray-400 hover:text-gray-500"
                  >
                    <span class="font-medium text-gray-900">Categories List</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-4">
                  <Disclosure
                    v-for="(option, optionIdx) in section.options"
                    :key="option.value"
                    class="border-b border-gray-200 py-2"
                    as="div"
                    v-slot="{ open }"
                  >
                    <input
                      :id="`filter-${section.id}-${optionIdx}`"
                      :name="`${section.id}[]`"
                      :value="option.value"
                      type="checkbox"
                      :checked="option.checked"
                      class="ml-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                    />
                    <label
                      :for="`filter-${section.id}-${optionIdx}`"
                      class="ml-3 text-sm text-gray-600 cursor-pointer"
                      >{{ option.label }}</label
                    >

                    <DisclosureButton
                      v-if="can.edit_category"
                      class="items-center justify-between bg-white text-sm text-blue-900 hover:text-blue-900"
                      @click="editCategory(option.id)"
                    >
                      <span class="ml-6 flex items-center">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-4 h-4"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                          />
                        </svg>
                      </span>
                    </DisclosureButton>
                    <DisclosureButton
                      @click="destroyCategory(option.id)"
                      v-if="can.delete_category"
                      class="items-center justify-between bg-white text-sm text-red-900 hover:text-red-900"
                    >
                      <span class="ml-6 flex items-center">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-4 h-4"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"
                          />
                        </svg>
                      </span>
                    </DisclosureButton>

                    <DisclosureButton
                      class="items-center justify-between bg-white text-sm text-gray-400 hover:text-gray-500"
                    >
                      <span class="ml-6 flex items-center">
                        <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                        <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                      </span>
                    </DisclosureButton>

                    <DisclosurePanel class="pt-2">
                      <SubCategory
                        @emitForDestroyEvent="destroyCategory"
                        @emitForEditEvent="editCategory"
                        :data="option.id"
                        :can="can"
                      />
                    </DisclosurePanel>
                  </Disclosure>
                </DisclosurePanel>
              </Disclosure>
              <!-- </form> -->
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import BreezeLabel from "@/Components/InputLabel.vue";
import BreezeInput from "@/Components/TextInput.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Components/Pagination.vue";
import SubCategory from "@/Pages/Category/SubCategory.vue";
import { computed, ref, onBeforeMount, onMounted, onUnmounted, defineEmits } from "vue";

import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import {
  ChevronDownIcon,
  FunnelIcon,
  MinusIcon,
  PlusIcon,
  Squares2X2Icon,
} from "@heroicons/vue/20/solid";
const emits = defineEmits(["emitForDestroyEvent", "emitForEditEvent"]);

const props = defineProps({
  categories: Object,
  can: Object,
  parentCategories: Object,
});
const categoryForm = useForm({  
  name: "",
  slug: "",
  description: "",
  parent_id: null,
  id: "",
});

const filters = [
  {
    id: "category",
    name: "Category",
    options: props.categories,
  },
];

const submitCategory = (event) => {
  console.warn(categoryForm);
  categoryForm.post(route("manage.categories.store"), {
    onFinish: () => location.reload(),
  });
};
const editCategory = (id) => {
  axios.get(route("manage.categories.edit", id)).then((res) => {
    console.log(res);
    categoryForm.id = res.data.id;
    categoryForm.name = res.data.name;
    categoryForm.slug = res.data.slug;
    categoryForm.description = res.data.description;
    categoryForm.parent_id = res.data.parent_id;
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
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      categoryForm.delete(route("manage.categories.destroy", id));
      location.reload();
    }
  });
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
