<script setup>
import { reactive } from 'vue'

const form = reactive({
    item_id:null,
    name: null,
    price: null,
    memo: null,
    is_selling: '1',
    errors: {},
})

</script>

<template>
    <div class="flex flex-col">
        <label name="name">Item Name</label>
        <input class="m-5 mt-2 rounded-lg" type="text" v-model="form.name">
        <InputError 
            v-for="msg in form.errors.name"
            :message="msg">
        </InputError>
        <label name="price">Price</label>
        <input class="m-5 mt-2 rounded-lg" type="number" v-model="form.price">
        <InputError 
            v-for="msg in form.errors.price"
            :message="msg">
        </InputError>
        <label name="is_selling" class="">Status</label>
        <div>
            <input class="m-4 mr-2" type="radio" value="1" v-model="form.is_selling" id="selling">
            <label for="selling" class="">販売可</label>
            <input  class="m-4 mr-2" type="radio" value="0" v-model="form.is_selling" id="not_selling">
            <label for="not_selling" class="">売切れ</label>
        </div>
        <label name="memo" class="">Memo</label>
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