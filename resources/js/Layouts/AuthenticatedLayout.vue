<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex flex-between min-h-screen bg-gray-100 dark:bg-gray-900">
                <nav class="flex flex-col overflow-y-hidden w-1/6 px-3 border-r-2 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

                    <!-- Logo -->
                    <div class="shrink-0 flex items-center pt-5">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 mb-5"
                            />
                        </Link>
                    </div>

                    <!-- nav -->
                    <div class="flex flex-col gap-96">
                        <!-- menu -->
                        <div class="flex flex-col p-4">
                            <div class="flex flex-col items-center">
                                <NavLink class="font-bold text-xl tracking-tight m-2" :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink class="font-bold text-xl tracking-tight m-2" :href="route('items.index')" :active="route().current('items.*')">
                                    商品一覧
                                </NavLink>
                                <NavLink class="font-bold text-xl tracking-tight m-2" :href="route('customers.index')" :active="route().current('customers.*')">
                                    顧客管理
                                </NavLink>
                                <NavLink class="font-bold text-xl tracking-tight m-2">
                                    購入履歴
                                </NavLink>
                                <NavLink class="font-bold text-xl tracking-tight m-2">
                                    データ分析
                                </NavLink>
                            </div>
                        </div>

                        <!-- profile -->
                        <div class="flex flex-col p-2 mx-2 bg-white dark:bg-gray-700 rounded-xl">
                                <NavLink class="font-bold text-lg tracking-tight m-2" :href="route('profile.edit')">Profile</NavLink>
                                <NavLink class="font-bold text-lg tracking-tight m-2" :href="route('logout')" method="post" as="button">Log Out</NavLink>
                        </div>
                    </div>
                </nav>

                <main class="w-5/6 p-5 h-screen overflow-y-scroll">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
