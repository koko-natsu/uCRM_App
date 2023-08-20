import { reactive, ref } from "vue";

export const form = reactive({
    item_id:null,
    name: null,
    price: null,
    memo: null,
    is_selling: '1',
    errors: {},
})

export const deleteFormContent = () => {
    form.item_id='';
    form.name='';
    form.price='';
    form.memo='';
    form.errors={};
}
