<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ItemsTable from '@/Components/ItemsTable.vue';
import axios from 'axios';
import InputModal from '@/Components/InputModal.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import InputError from '@/Components/InputError.vue';
import SortAndFilter from '@/Components/SortAndFilter.vue';
import RegisterButton from '@/Components/RegisterButton.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, ref, computed, watch } from 'vue';
import { form, deleteFormContent } from '@/itemState'


const props = defineProps({
    items: Object,
})

const sortedData = reactive({
    data: props.items.data });

// Sort and Search
const gridColumns = {'name': '商品名', 'price': '金額', 'created_at': '作成日'};
const retrieveSortedData = data => {
    sortedData.data = data
}

// Modal
const showModal = ref(false)
const modalHeader = ref('')

const setModal = bool => { showModal.value = bool }
const setModalHeader = title => { modalHeader.value = title }


// CRUD
const storeItem = () => {
    axios.post('/api/items', form)
        .then(res => {
            showModal.value = false
            sortedData.data = res.data
            deleteFormContent()
        })
        .catch(error => {
            form.errors = error.response.data.errors
        })
}

const retrieveItem = item_id => {
    axios.get(`/api/items/${item_id}`)
    .then(res => {
            showModal.value = true
            modalHeader.value = '商品情報編集'
            form.item_id = res.data.data.item_id
            Object.assign(form, res.data.data.attributes)
        })
        .catch(error => {
        })
}

const updateItem = item_id => {
    axios.patch(`/api/items/${item_id}`, form)
        .then(res => {
            showModal.value = false
            sortedData.data = res.data.data
            deleteFormContent()
        })
        .catch(error => {
            form.errors = error.response
        })
}

const removeItem = item_id => {
    if(confirm("選択した商品を削除してもいいですか?")) {
        axios.delete(`/api/items/${item_id}`)
            .then(res => {
                showModal.value = false
                sortedData.data = res.data
            })
            .catch(error => {  
            })
    }
}
</script>

<template>
    <Head title="Item" />
    <AuthenticatedLayout>

        <!-- Input Modal -->
        <Teleport to="body">
            <InputModal :show="showModal"
                @close="showModal = false;
                deleteFormContent()">
                <template #header>
                    {{ modalHeader }}
                </template>

                <template #body>
                    <div class="flex flex-col">
                        <label name="name">商品名</label>
                        <input class="m-5 mt-2 rounded-lg"
                            type="text"
                            v-model="form.name">
                        <InputError 
                            v-for="msg in form.errors.name"
                            :message="msg">
                        </InputError>
                        <label name="price">金額</label>
                        <input class="m-5 mt-2 rounded-lg"
                            type="number"
                            v-model="form.price">
                        <InputError v-for="msg in form.errors.price"
                            :message="msg">
                        </InputError>
                        <label name="is_selling">ステータス</label>
                        <div>
                            <input class="m-4 mr-2"
                                type="radio"
                                value="1"
                                v-model="form.is_selling"
                                id="selling">
                            <label for="selling">販売可</label>
                            <input  class="m-4 mr-2"
                                type="radio" value="0"
                                v-model="form.is_selling" 
                                id="not_selling">
                            <label for="not_selling">売切れ</label>
                        </div>
                        <label name="memo">メモ</label>
                        <textarea class="m-5 mt-2 rounded-lg resize-none" 
                            type="text"
                            v-model="form.memo">
                        </textarea>
                        <InputError
                            v-for="msg in form.errors.memo"
                            :message="msg">
                        </InputError>

                        <div v-if="form.item_id" class="text-right mr-5">
                            <SubmitButton
                                class="border rounded-lg p-2 mr-5"
                                @submit-event="removeItem(form.item_id)"
                                type="submit">Remove</SubmitButton>

                            <SubmitButton
                                class="border rounded-lg p-2"
                                @submit-event="updateItem(form.item_id)"
                                type="submit">Update</SubmitButton>
                        </div>

                        <div v-else class="text-right mr-5">
                            <SubmitButton 
                                class="border rounded-lg p-2"
                                @submit-event="storeItem"
                                type="submit">Create</SubmitButton>
                        </div>

                    </div>
                </template>
            </InputModal> 
        </Teleport>


        <div class="flex flex-wrap w-full">
            <div class="grow m-auto">
                <div class="flex items-center justify-end w-full mt-4 mb-4">
                    <RegisterButton
                        :title="'商品登録'"
                        @setModal="setModal"
                        @setModalHeader="setModalHeader"
                    />
                </div>
                <!-- SortBar -->
                <SortAndFilter
                    :data="sortedData"
                    :columns="gridColumns"
                    @retrieve-sorted-data="retrieveSortedData">
                    Total Items: {{ sortedData.data.length }}
                </SortAndFilter>

                <div class="px-5">
                    <ItemsTable
                        :items="sortedData.data"
                        @getItem="retrieveItem"
                    />
                </div>
            </div>
        </div> 

    </AuthenticatedLayout>

</template>