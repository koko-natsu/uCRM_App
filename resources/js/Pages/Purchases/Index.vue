<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PurchaseTable from '@/Components/PurchaseTable.vue';
import RegisterButton from '@/Components/RegisterButton.vue';
import SortAndFilter from '@/Components/SortAndFilter.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import InputModal from '@/Components/InputModal.vue';

const props = defineProps({
    purchases: Object,
})

const data = reactive({
    purchases: props.purchases,
})

// Modal
const showModal = ref(false)
const modalHeader = ref('')

const setModal = bool => { showModal.value = bool }
const setModalHeader = title => { modalHeader.value = title }
</script>

<template>
    <Head title="Purchase" />
    <AuthenticatedLayout>

        
        <div class="flex flex-wrap w-full">
            <div class="grow m-auto">
                <!-- Search Bar -->
                <div class="flex items-center justify-end w-full mt-4 mb-4">
                    <RegisterButton
                        :title="'新規購入'"
                        @setModal="setModal"
                        @setModalHeader="setModalHeader"
                    />
                </div>

                <!-- <SortAndFilter
                    :data=""
                    :columns=""
                    @retrieveSortedData=""
                /> -->

                <div class="px-5">
                    <PurchaseTable 
                        :purchases="data.purchases.data"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

    <InputModal
        :show="showModal"
        @close="showModal = false"
        class="over-flow-y-scroll"
    >
        <template #header>{{ modalHeader }}</template>

        <template #body>
            <div class="flex flex-col">
                
            </div>
        </template>
    </InputModal>
</template>