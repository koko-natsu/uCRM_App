<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputModal from '@/Components/InputModal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { reactive } from 'vue';

const props = defineProps({
    customers: {
        type: Object,
    },
})

const data = reactive({
    customers: props.customers,
})

const showInputModal = ref(false)
const modalHeader = ref('')


</script>

<template>
    <Head title="Customer" />
    <AuthenticatedLayout>..
        <div class="flex w-full p-10 mx-auto overflow-auto">
            <div class="w-full px-5 m-auto">

                <!-- Input Modal -->
                <Teleport to="body">
                    <InputModal
                        :show="showInputModal"
                        @close="showInputModal = false">
                        <template #header>
                            {{ modalHeader }}
                        </template>

                        <template #body>

                        </template>
                    </InputModal>

                </Teleport>

                <div>
                    <button 
                        class="bg-white font-bold ml-10 px-5 py-2 border rounded-xl"
                        @click="showInputModal = true; modalHeader = 'Create Customer'">New</button>
                </div>

                <table class="table-auto w-full whitespace-normal rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                            <th class="border-r-2 text-center py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">性別</th>
                            <th class="text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">連絡先</th>
                            <th class="border-r-2 text-center px-10 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">住所</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in data.customers.data" :key="customers.id">
                            <td class="px-4 py-3 bg-white text-center border-r-2">
                                <p class="text-xs">{{ customer.data.attributes.kana }}</p>
                                {{ customer.data.attributes.name }}
                            </td>
                            <td v-if="customer.data.attributes.gender == 1" class="px-4 py-3 bg-white text-end border-r-2">男性</td>
                            <td v-else-if="customer.data.attributes.gender == 2" class="px-4 py-3 bg-white text-end border-r-2">女性</td>
                            <td v-else class="px-4 py-3 bg-white text-end border-r-2">他</td>
                            <td class="px-4 py-3 bg-white text-start border-r-2">
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
            </div>
        </div>


    </AuthenticatedLayout>
</template>