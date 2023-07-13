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
</script>

<template>
    <Head title="Item" />
    <AuthenticatedLayout>
        <div class="flex flex-wrap justify-between w-full p-10 mx-auto overflow-auto">
            
            <div class="w-3/5 px-5">
                <ItemsTable :items="data.items" />
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
                <input  class="m-5 mt-2 rounded-lg" type="text" v-model="form.memo" placeholder="Memo">
                <InputError 
                    v-for="msg in data.errors.memo"
                    :message="msg">
                </InputError>
                
                <div class="text-right mr-5">
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