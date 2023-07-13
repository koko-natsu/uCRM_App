<script setup>
defineProps({
    items: Object,
})

</script>

<template>
    <table class="table-auto w-full whitespace-normal">
        <thead>
            <tr>
                <!-- <th class="border-r-2 text-center py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ID</th> -->
                <th class="border-r-2 text-center px-10 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                <th class="border-r-2 text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                <th class="border-r-2 text-center py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ステータス</th>
                <th class="text-center px-4 py-3 tracking-wider font-medium text-gray-900 text-sm bg-gray-100">link</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items.data" :key="item.id">
                <!-- <td class="px-4 py-3 bg-white text-center border-r-2">{{ item.data.item_id }}</td> -->
                <td class="px-4 py-3 bg-white text-center border-r-2">{{ item.data.attributes.name }}</td>
                <td class="px-4 py-3 bg-white text-end border-r-2">{{ item.data.attributes.price.toLocaleString() }}</td>
                <td v-if="item.data.attributes.is_selling" class="px-4 py-3 bg-white text-center border-r-2">販売可</td>
                <td v-else class="px-4 py-3 bg-white text-center border-r-2">再入荷中</td>
                <td class="px-4 py-3 bg-white text-center">
                    <button class="border-2 px-3 py-1 rounded-xl font-bold">
                        link
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>