<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ItemsTable from '@/Components/ItemsTable.vue';
import axios from 'axios';
import InputModal from '@/Components/InputModal.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { form, deleteFormContent } from '@/itemState'


const props = defineProps({
    items:{
        type: Object,
    },
})

const showInputModal = ref(false)
const modalHeader = ref('')

const data = reactive({
    items: props.items,
})

const storeItem = () => {
    axios.post('/api/items', form)
        .then(res => {
            showInputModal.value = false
            data.items = res.data
            deleteFormContent()
        })
        .catch(error => {
            form.errors = error.response.data.errors
        })
}

const retrieveItem = item_id => {
    axios.get(`/api/items/${item_id}`)
        .then(res => {
            form.item_id = res.data.data.item_id
            form.name = res.data.data.attributes.name
            form.price = res.data.data.attributes.price
            form.memo = res.data.data.attributes.memo
            form.is_selling = res.data.data.attributes.is_selling
            showInputModal.value = true
            modalHeader.value = 'Edit Item'
        })
        .catch(error => {
        })
}

const updateItem = item_id => {
    axios.patch(`/api/items/${item_id}`, form)
        .then(res => {
            showInputModal.value = false
            data.items = res.data
            deleteFormContent()
        })
        .catch(error => {
            form.errors = error.response.form.errors
        })
}

const removeItem = item_id => {
    if(confirm("Do you really want to remove?")) {
        axios.delete(`/api/items/${item_id}`)
            .then(res => {
                showInputModal.value = false
                data.items = res.data
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
            <InputModal
                :show="showInputModal"
                @close="showInputModal = false;
                deleteFormContent()">
                <template #header>
                    {{ modalHeader }}
                </template>

                <template #body>
                    <div class="flex flex-col">
                        <label name="name">商品名</label>
                        <input class="m-5 mt-2 rounded-lg" type="text" v-model="form.name">
                        <InputError 
                            v-for="msg in form.errors.name"
                            :message="msg">
                        </InputError>
                        <label name="price">金額</label>
                        <input class="m-5 mt-2 rounded-lg" type="number" v-model="form.price">
                        <InputError 
                            v-for="msg in form.errors.price"
                            :message="msg">
                        </InputError>
                        <label name="is_selling" class="">ステータス</label>
                        <div>
                            <input class="m-4 mr-2" type="radio" value="1" v-model="form.is_selling" id="selling">
                            <label for="selling" class="">販売可</label>
                            <input  class="m-4 mr-2" type="radio" value="0" v-model="form.is_selling" id="not_selling">
                            <label for="not_selling" class="">売切れ</label>
                        </div>
                        <label name="memo" class="">メモ</label>
                        <textarea class="m-5 mt-2 rounded-lg resize-none" type="text" v-model="form.memo">
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


        <div class="flex flex-wrap w-full p-5">
            <div class="flex flex-col w-1/5 p-2 bg-red-50">
                <strong>Sort</strong>
                
            </div>

            <div class="grow px-5 m-auto">
                
                <!-- Search Bar -->
                <div class="flex items-center justify-between w-full mb-5">
                    <div class="relative flex justify-end w-1/2 fill-blue-600">
                        <input type="text" class="w-full rounded-lg border-none" placeholder="Search Item">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 512 512" class="absolute top-2.5 right-3"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                    </div>
    
                    <div>
                        <button 
                            class="bg-white font-bold ml-10 px-5 py-2 border rounded-xl"
                            @click="showInputModal = true; modalHeader = 'Create Item'">New</button>
                    </div>
                </div>

                <ItemsTable 
                    :items="data.items"
                    @getItem="retrieveItem" />
            </div>

        </div> 

    </AuthenticatedLayout>

</template>