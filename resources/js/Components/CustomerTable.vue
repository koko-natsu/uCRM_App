<script setup>
import { genderColor } from '@/genderColor'

defineEmits(['getCustomer'])

defineProps({
    customers: {
        type: Object
    }
})

</script>

<template>
    <table class="table-auto w-full whitespace-normal overflow-hidden bg-white">
        <thead>
            <tr class="border-2 text-sm">
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">名前</th>
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">読み仮名</th>
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">最終購入日</th>
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">購入回数</th>
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">Contact</th>
                <th class="text-center px-2 py-3 tracking-wider font-medium text-md">Status</th>
                <th class="text-center px-2 py-3"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="customer in customers" :key="customer.id" class="border-2 text-xs">
                <td class="px-4 py-3 text-center font-medium text-sm">{{ customer.data.attributes.name }}</td>
                <td class="px-4 py-3 text-center font-medium">{{ customer.data.attributes.kana }}</td>
                <td class="px-4 py-3 text-center text-gray-400 font-medium">2022-10-03</td>
                <td class="px-4 py-3 text-center text-gray-400 font-medium">10</td>
                <td class="px-4 py-3 text-center font-medium">
                    <div class="flex justify-center">
                        <button class="mr-5 p-2 rounded-full bg-[#0144dd]">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                        </button>
                        <button class="p-2 rounded-full bg-[#0144dd]">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                        </button>
                    </div>
                </td>
                <td class="px-4 py-3 text-center font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 448 512" fill="#f78502"><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                </td>
                <td class="px-4 py-3 text-center">
                    <button @click="$emit('getCustomer', customer.data.customer_id)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>