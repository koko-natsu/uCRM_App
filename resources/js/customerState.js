import { reactive } from "vue"

export const form = reactive({
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
