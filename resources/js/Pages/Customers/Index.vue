<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputModal from '@/Components/InputModal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { reactive } from 'vue';
import { genderColor } from '@/genderColor'
import { form } from '@/customerState'
import { getAddress } from '@/getAddress'
import SubmitButton from '@/Components/SubmitButton.vue';
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

const storeCustomer = async function() {
    form.name = form.name.last_name.concat(' ', form.name.first_name)
    form.kana = form.kana.last_name.concat(' ', form.kana.first_name)
    await axios.post('/api/customers', form)
        .then(res => {
            showInputModal.value = false;
            data.customers = res.data;
        })
        .catch(error => {
            console.log(error.response.data.errors);
        })
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
                        @close="showInputModal = false"
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

                                <div class="flex justify-end mt-5">
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

                <table class="table-auto w-full whitespace-normal rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-white text-md bg-blue-600">名前</th>
                            <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-white text-md bg-blue-600">連絡先</th>
                            <th class="border-r-2 text-center px-10 py-3 tracking-wider font-medium text-white text-md bg-blue-600">住所</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in data.customers.data" :key="customers.id">
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
            </div>
        </div>


    </AuthenticatedLayout>
</template>