<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    purchases: Array,
})
</script>

<template>
    <Head title="Purchase" />
    <AuthenticatedLayout>

    </AuthenticatedLayout>
</template>