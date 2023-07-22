<script setup>
defineEmits(['getItem',])

defineProps({
    items: {
        type: Object,
    }
})
</script>

<template>
    <table class="table-auto w-full whitespace-normal rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="border-r-2 text-center px-10 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                <th class="border-r-2 text-center py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ステータス</th>
                <th class="text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Memo</th>
                <th class="text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items.data" :key="item.id">
                <td class="px-4 py-3 bg-white text-center border-r-2">{{ item.data.attributes.name }}</td>
                <td class="px-4 py-3 bg-white text-end border-r-2">{{ item.data.attributes.price.toLocaleString() }}</td>
                <td v-if="item.data.attributes.is_selling" class="px-4 py-3 bg-white text-center border-r-2">販売可</td>
                <td v-else class="px-4 py-3 bg-white text-center border-r-2">再入荷中</td>
                <td class="px-4 py-3 bg-white text-end border-r-2">{{ item.data.attributes.memo }}</td>
                <td class="px-4 py-3 bg-white text-center">
                    <button @click="$emit('getItem', item.data.item_id)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>