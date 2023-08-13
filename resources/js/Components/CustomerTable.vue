<script setup>
import { genderColor } from '@/genderColor'

defineProps({
    customers: {
        type: Array
    }
})

</script>

<template>
    <table class="table-auto w-full whitespace-normal rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-white text-md bg-blue-600">名前</th>
                <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-white text-md bg-blue-600">連絡先</th>
                <th class="border-r-2 text-center px-10 py-3 tracking-wider font-medium text-white text-md bg-blue-600">住所</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="customer in customers.data" :key="customers.id">
                <td class="px-4 py-3 bg-white text-center"
                :class="genderColor(customer.data.attributes.gender)">
                    <p class="text-xs">{{ customer.data.attributes.kana }}</p>
                    {{ customer.data.attributes.name }}
                </td>
                <td class="px-4 py-3 bg-white text-start border-r-2 border-l-2">
                    <p>{{ customer.data.attributes.tel }}</p>
                    <p>{{ customer.data.attributes.email }}</p>
                </td>
                <td class="px-4 py-3 bg-white border-r-2">
                    <p>{{ customer.data.attributes.postcode }}</p>
                    <p>{{ customer.data.attributes.address }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</template>