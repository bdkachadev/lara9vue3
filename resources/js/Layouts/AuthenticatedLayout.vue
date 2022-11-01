<script setup>
import { ref, computed, onBeforeMount } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { usePage, Link } from "@inertiajs/inertia-vue3";

const showingNavigationDropdown = ref(false);
const g_count = ref(0);

onBeforeMount(() => {
  // console.log("Component is onBeforeMount!");
  axios.get(route("getCount")).then((res) => {
    g_count.value = res.data;
  });
});
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link
                  v-if="$page.props.auth.role && $page.props.auth.role !== 'user'"
                  :href="route('dashboard')"
                >
                  <ApplicationLogo class="block h-9 w-auto" />
                </Link>
                <Link v-else :href="route('home')">
                  <ApplicationLogo class="block h-9 w-auto" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-2 sm:-my-px sm:ml-10 sm:flex">
                <NavLink
                  v-if="$page.props.auth.role && $page.props.auth.role !== 'user'"
                  :href="route('dashboard')"
                  :active="route().current('dashboard')"
                >
                  Dashboard
                </NavLink>

                <NavLink
                  v-if="$page.props.auth.role && $page.props.auth.role === 'user'"
                  :href="route('home')"
                  :active="route().current('home')"
                >
                  Home
                </NavLink>

                <NavLink
                  v-if="
                    $page.props.auth.role &&
                    ($page.props.auth.role === 'super_admin' ||
                      $page.props.auth.role === 'admin')
                  "
                  :href="route('manage.users.index')"
                  :active="route().current('manage.users.index')"
                >
                  Users
                </NavLink>

                <NavLink
                  v-if="
                    $page.props.auth.role &&
                    ($page.props.auth.role === 'super_admin' ||
                      $page.props.auth.role === 'admin')
                  "
                  :href="route('manage.roles.index')"
                  :active="route().current('manage.roles.index')"
                >
                  Roles
                </NavLink>

                <NavLink
                  v-if="
                    $page.props.auth.role &&
                    ($page.props.auth.role === 'super_admin' ||
                      $page.props.auth.role === 'admin')
                  "
                  :href="route('manage.permissions.index')"
                  :active="route().current('manage.permissions.index')"
                >
                  Permissions
                </NavLink>

                <NavLink
                  v-if="
                    $page.props.auth.role &&
                    ($page.props.auth.role === 'super_admin' ||
                      $page.props.auth.role === 'admin' ||
                      $page.props.auth.role === 'manager')
                  "
                  :href="route('manage.products.index')"
                  :active="route().current('manage.products.index')"
                >
                  Products
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <NavLink
                v-if="
                  $page.props.auth.role &&
                  ($page.props.auth.role === 'super_admin' ||
                    $page.props.auth.role === 'admin' ||
                    $page.props.auth.role === 'manager' ||
                    $page.props.auth.role === 'user')
                "
                :href="route('manage.carts.index')"
                :active="route().current('manage.carts.index')"
              >
                <svg class="flex-1 w-6 h-6 fill-current" viewbox="0 0 24 24">
                  <path
                    d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"
                  />
                </svg>
                <span
                  class="absolute right-0 top-0 rounded-full bg-red-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm leading-tight text-center"
                >
                </span>
                <span
                  class="inline-block py-0.5 px-1.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-indigo-500 text-white rounded"
                  >{{ g_count }}</span
                >
              </NavLink>
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                      >
                        {{ $page.props.auth.user.name }}

                        <svg
                          class="ml-2 -mr-0.5 h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                      Log Out
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
          }"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Dashboard
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
              <div class="font-medium text-base text-gray-800">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ $page.props.auth.user.email }}
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
