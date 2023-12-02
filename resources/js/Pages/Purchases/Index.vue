<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PurchaseTable from '@/Components/PurchaseTable.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    purchases: Object,
})

const data = reactive({
    purchases: props.purchases,
})
</script>

<template>
    <Head title="Purchase" />
    <AuthenticatedLayout>

        <div class="flex flex-wrap w-full">
            <div class="grow m-auto">
                <!-- Search Bar -->
                <div class="flex items-center justify-end w-full mt-4 mb-4">
                    <div class="relative flex justify-end w-1/2 fill-slate-500">
                        <input type="text" class="text-xs pr-10 rounded-md border-none bg-[#ecf0fb]" placeholder="Search Purchase">
                        <svg xmlns="http://www.w3.org/2000/svg" height=".8em" viewBox="0 0 512 512" class="absolute top-2.5 right-3"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                    </div>
                    <button
                        class="bg-[#0144dd] text-white text-sm font-bold rounded-md ml-10 px-5 py-2"
                        @click="showInputModal = true; modalHeader = '新規購入'">新規購入
                    </button>
                </div>

                <!-- SortBar -->
                <div class="flex justify-between items-center px-5">
                    <div class="flex">
                        <div class="relative flex items-center bg-[#ecf0fb] rounded-full pr-3">
                            <small class="px-2 text-[#717377]">name</small>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="absolute top-1.5 right-1.5" fill="#717377" viewBox="0 0 320 512"><path d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/></svg>
                        </div>
                        <div class="relative flex items-center pr-3 bg-[#ecf0fb] rounded-full">
                            <small class="px-2 text-[#717377]">price</small>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="absolute top-1.5 right-1.5" fill="#717377" viewBox="0 0 320 512"><path d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/></svg>
                        </div>
                        <div class="relative flex items-center pr-3 bg-[#ecf0fb] rounded-full">
                            <small class="px-2 text-[#717377]">created at</small>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="absolute top-1.5 right-1.5" fill="#717377" viewBox="0 0 320 512"><path d="M182.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/></svg>
                        </div>
                    </div>

                    <small class="font-bold text-[#717377]">Total Purchases: 10</small>
                </div>

                <div class="px-5">
                    <PurchaseTable 
                        :purchases="data.purchases.data"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>