<script setup>
import { ref } from 'vue';

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    }
})

const processing = ref(false)
const emit = defineEmits(['submitEvent'])

const handleClick = event => {
    if(processing.value) return
    processing.value - true
    event.preventDefault()
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            emit('submitEvent')
            resolve();
        }, 500)
    })
    .then(() => {
        processing.value = false
    })
}

</script>

<template>
    <button :disabled="$props.disabled || processing" @click="handleClick">
        <slot></slot>
    </button>
</template>