<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ItemsTable from '@/Components/ItemsTable.vue';
import InputError from '@/Components/InputError.vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';


const props = defineProps({
    items: Object,
})

const data = reactive({
    items: props.items,
    errors: {},
})

const form = reactive({
    item_id:null,
    name: null,
    price: null,
    memo: null,
    is_selling: '1',
})

const storeItem = () => {
    axios.post('/api/items', form)
        .then(res => {
            data.items = res.data
        })
        .catch(error => {
            data.errors = error.response.data.errors
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
        })
        .catch(error => {

        })
}

const updateItem = item_id => {
    axios.patch(`/api/items/${item_id}`, form)
        .then(res => {
            data.items = res.data
        })
        .catch(error => {
            data.errors = error.response.data.errors
        })
}

const removeItem = item_id => {
    if(confirm("Do you really want to remove?")) {
        axios.delete(`/api/items/${item_id}`)
            .then(res => {
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
        <div class="flex flex-wrap justify-between w-full p-10 mx-auto overflow-auto">
            
            <div class="w-3/5 px-5">
                <div class="relative flex justify-end">
                    <input type="text" class="w-1/2 rounded-lg mb-5" placeholder="Search Item">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 512 512" class="absolute top-2.5 right-3"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                </div>
                <ItemsTable 
                    :items="data.items"
                    @getItem="retrieveItem"></ItemsTable>/>
            </div>

            <!-- Form -->
            <div class="flex flex-col w-2/5 border p-10 rounded-xl">
                <label name="name" class="text-white">Item Name</label>
                <input class="m-5 mt-2 rounded-lg" type="text" v-model="form.name" placeholder="Add Item Name">
                <InputError 
                    v-for="msg in data.errors.name"
                    :message="msg">
                </InputError>
                <label name="price" class="text-white">Price</label>
                <input class="m-5 mt-2 rounded-lg" type="number" v-model="form.price" placeholder="Add Price">
                <InputError 
                    v-for="msg in data.errors.price"
                    :message="msg">
                </InputError>
                <label name="is_selling" class="text-white">Status</label>
                <div>
                    <input class="m-4 mr-2" type="radio" value="1" v-model="form.is_selling" id="selling">
                    <label for="selling" class="text-white">販売可</label>
                    <input  class="m-4 mr-2" type="radio" value="0" v-model="form.is_selling" id="not_selling">
                    <label for="not_selling" class="text-white">売切れ</label>
                </div>
                <label name="memo" class="text-white">Memo</label>
                <textarea class="m-5 mt-2 rounded-lg resize-none" type="text" v-model="form.memo" placeholder="Add Memo">
                </textarea>
                <InputError 
                    v-for="msg in data.errors.memo"
                    :message="msg">
                </InputError>
                
                <div v-if="form.item_id" class="text-right mr-5">
                    <button 
                        class="text-white border rounded-lg p-2 mr-5"
                        @click="removeItem(form.item_id)">
                        Remove
                    </button>

                    <button class="text-white border rounded-lg p-2"
                        @click="updateItem(form.item_id);
                        form.item_id='';
                        form.name='';
                        form.price='';
                        form.memo='';
                        data.errors={}">Update</button>
                </div>

                <div v-else class="text-right mr-5">
                    <button class="text-white border rounded-lg p-2"
                        @click="storeItem();
                        form.name='';
                        form.price='';
                        form.memo='';
                        data.errors={}">Submit</button>
                </div>
            </div>


        </div> 

    </AuthenticatedLayout>

</template>