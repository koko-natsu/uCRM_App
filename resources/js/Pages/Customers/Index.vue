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
        <div class="flex w-full p-10 mx-auto overflow-auto">
            <div class="w-full px-5 m-auto">

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


                <div>
                    <button 
                        class="bg-white font-bold ml-10 px-5 py-2 border rounded-xl"
                        @click="showInputModal = true; modalHeader = '新規顧客登録'">New</button>
                </div>

                <CustomerTable 
                    :customers="data.customers.data"
                    @getCustomer="retrieveCustomer"/>
            </div>
        </div>


    </AuthenticatedLayout>
</template>