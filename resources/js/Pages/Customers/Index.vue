<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputModal from '@/Components/InputModal.vue';
import InputError from '@/Components/InputError.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import CustomerTable from '@/Components/CustomerTable.vue';
import SortAndFilter from '@/Components/SortAndFilter.vue';
import RegisterButton from '@/Components/RegisterButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { form, deleteFormContent } from '@/customerState'
import { getAddress } from '@/getAddress'

const props = defineProps({
    customers: Object,
})

const sortedData = reactive({
    data: props.customers.data,
})

const mergingNames = () => {
    form.name = form.name.last_name.concat(' ', form.name.first_name)
    form.kana = form.kana.last_name.concat(' ', form.kana.first_name)
}


// Sort and Search
const gridColumns = { 'kana': '顧客名', 'purchase_day': '購入日', 'num_of_purchases': '購入回数'}
const retrieveSortedData = filteredData => {
    sortedData.data = filteredData
}


// Modal
const showModal = ref(false)
const modalHeader = ref('')

const setModal = bool => { showModal.value = bool }
const setModalHeader = title => { modalHeader.value = title }


// CRUD
const storeCustomer = async () => {
    try {
        mergingNames();
        const response = await axios.post('/api/customers', form);
        sortedData.data = response.data;
        showModal.value = false;
    } catch(errors) {
        console.log(errors);
    }
}

const retrieveCustomer = async customer_id => {
    try {
        const response = await axios.get(`/api/customers/${customer_id}`);
        modalHeader.value = '顧客情報編集'
        showModal.value = true
        form.customer_id = response.data.data.customer_id
        Object.assign(form, response.data.data.attributes)
    } catch(errors) {
        console.log(errors);
    }

}


const updateCustomer = async customer_id => {
    try {
        mergingNames();
        const response = await axios.patch(`/api/customers/${customer_id}`, form);
        showModal.value = false;
        sortedData.data = response.data;
    } catch(errors) {
        console.log(errors.response);
    }

    deleteFormContent();
}


const removeCustomer = async customer_id => {
    if(confirm("顧客情報を削除しますか？")) {
        try {
            const response = await axios.delete(`/api/customers/${customer_id}`);
            showModal.value = false;
            sortedData.data = response.data;
        } catch(errors) {
            console.log(errors.response);
        }
    }
}
</script>

<template>
    <Head title="Customer" />
    <AuthenticatedLayout>

        <!-- Input Modal -->
        <Teleport to="body">
            <InputModal
                :show="showModal"
                @close="showModal = false; deleteFormContent()"
                class="overflow-y-scroll">
                <template #header>
                    {{ modalHeader }}
                </template>

                <template #body>
                    <div class="flex flex-col">

                        <label name="name" class="mb-1">顧客名</label>
                        <div class="flex flex-wrap">
                            <input
                                class="grow mr-2 rounded-lg border-gray-300"
                                type="text" 
                                v-model.trim="form.name.last_name"
                                placeholder="姓">
                            <input
                                class="grow rounded-lg border-gray-300"
                                type="text"
                                v-model.trim="form.name.first_name"
                                placeholder="名">
                        </div>
                        <InputError 
                            v-for="msg in form.errors.name"
                            :message="msg">
                        </InputError>

                        <label name="kana" class="mt-3 mb-1">読み仮名</label>
                        <div class="flex flex-wrap">
                            <input
                                class="grow mr-2 rounded-lg border-gray-300"
                                type="text"
                                v-model.trim="form.kana.last_name"
                                placeholder="セイ">
                            <input
                                class="grow rounded-lg border-gray-300"
                                type="text"
                                v-model.trim="form.kana.first_name"
                                placeholder="メイ">
                        </div>
                        <InputError 
                            v-for="msg in form.errors.price"
                            :message="msg">
                        </InputError>

                        <label name="is_selling" class="mt-3">性別</label>
                        <div>
                            <input
                                class="m-2 mr-2"
                                type="radio"
                                value="1"
                                v-model="form.gender"
                                id="male">
                            <label for="male" class="">男性</label>
                            <input
                                class="m-2 mr-2"
                                type="radio"
                                value="0"
                                v-model="form.gender"
                                id="female">
                            <label for="female" class="">女性</label>
                        </div>

                        <label name="email" class="mt-3">メールアドレス</label>
                        <input
                            v-model.trim="form.email"
                            type="email"
                            class="grow rounded-lg border-gray-300">

                        <label name="tel" class="mt-3">電話番号</label>
                        <input
                            v-model.trim="form.tel"
                            type="tel"
                            class="grow rounded-lg border-gray-300" >

                        <label name="postcode" class="mt-3">郵便番号</label>
                        <div class="flex flex-wrap">
                            <input
                                v-model.trim="form.postcode"
                                type="text"
                                class="lg:w-1/2 rounded-lg border-gray-300"
                                pattern="\d{3}-\d{4}">
                            <button
                                @click="getAddress(form.postcode)"
                                class="border-2 ml-5 px-4 py-2 rounded-xl">住所検索</button>
                        </div>

                        <label name="address" class="mt-3">住所</label>
                        <input v-model.trim="form.address"
                            type="text"
                            class="rounded-lg border-gray-300">

                        <label name="memo" class="mt-3">メモ</label>
                        <textarea
                            class="rounded-lg resize-none border-gray-300"
                            type="text"
                            v-model="form.memo">
                        </textarea>
                        <InputError
                                v-for="msg in form.errors.memo"
                            :message="msg">
                        </InputError>

                        <div v-if="form.name" class="text-right mr-5">
                            <SubmitButton
                                class="border rounded-lg p-2 mr-5"
                                @submit-event="removeCustomer(form.customer_id)"
                                type="submit">削除</SubmitButton>

                            <SubmitButton
                                class="border rounded-lg p-2"
                                @submit-event="updateCustomer(form.customer_id)"
                                type="submit">更新</SubmitButton>
                        </div>

                        <div v-else class="flex justify-end mt-5">

                            <SubmitButton
                                @submit-event="storeCustomer()"
                                class="border rounded-t-lg p-2"
                                type="submit">登録</SubmitButton>
                        </div>
                    </div>
                </template>
            </InputModal>
        </Teleport>

<div class="flex flex-wrap w-full">
            <div class="grow m-auto">
                <div class="flex items-center justify-end w-full mt-4 mb-4">
                    <RegisterButton 
                        :title="'顧客登録'"
                        @setModal="setModal"
                        @setModalHeader="setModalHeader"
                    />
                </div>
                <!-- SortBar -->
                <SortAndFilter 
                    :data="sortedData"
                    :columns="gridColumns"
                    @retrieve-sorted-data="retrieveSortedData"
                >
                    Total Customers: {{ sortedData.data.length }}
                </SortAndFilter>

            <div class="px-5">
                <CustomerTable 
                    :customers="sortedData.data"
                    @getCustomer="retrieveCustomer"
                />
            </div>
        </div>

        
    </div> 


    </AuthenticatedLayout>
</template>