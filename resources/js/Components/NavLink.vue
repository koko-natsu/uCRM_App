<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center p-3 text-gray-800 fill-amber-400	'
        : 'inline-flex items-center p-3 text-gray-300 fill-gray-300 transition duration-150 ease-in-out hover:-translate-y-2 hover:text-gray-500 hover:fill-gray-500'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
