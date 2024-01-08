import { reactive } from "vue";

export const form = reactive({
    customer_id: null,
    items:       {},
    errors:      {},
})

export const deleteFormContent = () => {
    form.customer_id = null
    form.items       = {}
    form.errors      = {}
}