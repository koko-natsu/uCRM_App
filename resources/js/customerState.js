import { reactive } from "vue"

export const form = reactive({
    customer_id: null,
    name: {
        first_name: '',
        last_name: '',
    },
    kana: {
        first_name: '',
        last_name: '',
    },
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: 1,
    memo: null,
    errors: {},
})


export const deleteFormContent = () => {
    form.customer_id = null
    form.name = ''
    form.kana = ''
    form.tel = null
    form.email = null
    form.postcode = null
    form.address = null
    form.birthday = null
    form.gender = 1
    form.memo = null
    form.errors = {}
}