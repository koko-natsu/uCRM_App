<script setup>
defineProps({ title: String })
defineEmits(['setModal', 'setModalHeader'])

</script>

<template>
    <button
        class="bg-[#0144dd] text-white text-sm font-bold rounded-md ml-10 px-5 py-2"
        @click="$emit('setModal', 'true');
                $emit('setModalHeader', title)">
        {{ title }}
    </button>
</template>