<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputModal from '@/Components/InputModal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { reactive } from 'vue';
import { genderColor } from '@/genderColor'
import { form, deleteFormContent } from '@/customerState'
import { getAddress } from '@/getAddress'
import InputError from '@/Components/InputError.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import CustomerTable from '@/Components/CustomerTable.vue';
import axios from 'axios';

const props = defineProps({
    customers: {
        type: Object,
    },
})

const showInputModal = ref(false)
const modalHeader = ref('')
const data = reactive({
    customers: props.customers,
})

const mergingNames = () => {
    form.name = form.name.last_name.concat(' ', form.name.first_name)
    form.kana = form.kana.last_name.concat(' ', form.kana.first_name)
}

const storeCustomer = async () => {
    try {
        mergingNames();
        const response = await axios.post('/api/customers', form);
        data.customers = response.data;
        showInputModal.value = false;
    } catch(errors) {
        console.log(errors);
    }
}

const retrieveCustomer = async customer_id => {
    try {
        const response = await axios.get(`/api/customers/${customer_id}`);

        form.customer_id = response.data.data.customer_id
        Object.assign(form, response.data.data.attributes)
        modalHeader.value = '顧客情報編集'
        showInputModal.value = true
    } catch(errors) {
        console.log(errors);
    }

}


const updateCustomer = async customer_id => {
    try {
        mergingNames();
        const response = await axios.patch(`/api/customers/${customer_id}`, form);
        showInputModal.value = false;
        data.customers = response.data;
    } catch(errors) {
        console.log(errors.response);
    }

    deleteFormContent();
}


const removeCustomer = async customer_id => {
    if(confirm("顧客情報を削除しますか？")) {
        try {
            const response = await axios.delete(`/api/customers/${customer_id}`);
            showInputModal.value = false;
            data.customers = response.data;
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
                :show="showInputModal"
                @close="showInputModal = false; deleteFormContent()"
                class="overflow-y-scroll">
                <template #header>
                    {{ modalHeader }}
                </template>

                <template #body>
                    <div class="flex flex-col">

                        <label name="name" class="mb-1">顧客名</label>
                        <div class="flex flex-wrap">
                            <input
                                class="grow mr-2 rounded-lg drop-shadow-md border-gray-300"
                                type="text" 
                                v-model.trim="form.name.last_name"
                                placeholder="姓">
                            <input
                                class="grow rounded-lg drop-shadow-md border-gray-300"
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
                                class="grow mr-2 rounded-lg drop-shadow-md border-gray-300"
                                type="text"
                                v-model.trim="form.kana.last_name"
                                placeholder="セイ">
                            <input
                                class="grow rounded-lg drop-shadow-md border-gray-300"
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
                            class="grow rounded-lg drop-shadow-md border-gray-300">

                        <label name="tel" class="mt-3">電話番号</label>
                        <input
                            v-model.trim="form.tel"
                            type="tel"
                            class="grow rounded-lg drop-shadow-md border-gray-300" >

                        <label name="postcode" class="mt-3">郵便番号</label>
                        <div class="flex flex-wrap">
                            <input
                                v-model.trim="form.postcode"
                                type="text"
                                class="lg:w-1/2 rounded-lg drop-shadow-md border-gray-300"
                                pattern="\d{3}-\d{4}">
                            <button
                                @click="getAddress(form.postcode)"
                                class="border-2 ml-5 px-4 py-2 rounded-xl">住所検索</button>
                        </div>

                        <label name="address" class="mt-3">住所</label>
                        <input v-model.trim="form.address"
                            type="text"
                            class="rounded-lg drop-shadow-md border-gray-300">

                        <label name="memo" class="mt-3">メモ</label>
                        <textarea
                            class="rounded-lg resize-none drop-shadow-md border-gray-300"
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
            <!-- Search Bar -->
                <div class="flex items-center justify-end w-full mt-4 mb-4">
                    <div class="relative flex justify-end w-1/2 fill-slate-500">
                        <input type="text" class="text-xs pr-10 rounded-md border-none bg-[#ecf0fb]" placeholder="Search Item">
                        <svg xmlns="http://www.w3.org/2000/svg" height=".8em" viewBox="0 0 512 512" class="absolute top-2.5 right-3"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                    </div>
                    <button
                        class="bg-[#0144dd] text-white text-sm font-bold rounded-md ml-10 px-5 py-2"
                        @click="showInputModal = true; modalHeader = '顧客登録'">顧客登録
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

                    <small class="font-bold text-[#717377]">Total Items: 3</small>
                    
                </div>

            <div class="px-5">
                <CustomerTable 
                    :customers="data.customers.data"
                    @getCustomer="retrieveCustomer"/>
            </div>
        </div>
    </div> 


    </AuthenticatedLayout>
</template>