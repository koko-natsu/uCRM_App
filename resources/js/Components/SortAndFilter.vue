<script setup>
import { ref, computed,watch, reactive } from 'vue';


const props = defineProps({
    data: Object,
    columns: Object,
})

const items = reactive({ data: props.data.data })
const emit = defineEmits(['retrieveSortedData'])

const sortKey = ref('')
const searchQuery = ref('')

// { key: 1, key: 1, key: 1 }の型に変換
const sortOrders = ref(
    Object.fromEntries(
        Object.entries(Object.keys(props.columns)).map(([i, key]) => [key, 1]),
    )
)

const sortBy = key => {
    sortKey.value = key
    sortOrders.value[key] *= -1
}

const filteredData = computed(() => {
    let data      = items.data
    let key       = sortKey.value
    let filterKey = searchQuery.value.toLowerCase()
    let order     = sortOrders.value[key]

    if(key) {
        data = data.slice().sort((a, b) => {
            a = a.data.attributes[key]
            b = b.data.attributes[key]
            return (a === b ? 0 : a > b ? 1 : -1) * order
        })
    }

    if(filterKey) {
        // FIXME: 検索システムの改善
        // row['data']['attributes']を使用すると、データの全ての属性に検索をかけてしまい、
        // 検索条件と意図しない結果が表示される。検索Keyを指定し配列で渡した方がよい
        data = data.filter((row) => {
            return Object.keys(row['data']['attributes']).some((key) => {
                return String(row['data']['attributes'][key]).toLowerCase().indexOf(filterKey) > -1
            })
        })
    }

    return data;
})

watch(sortOrders.value, () => {
    emit('retrieveSortedData', filteredData.value)
}, { immediate: true })

watch(
    () => searchQuery.value,
    (query) => {
        emit('retrieveSortedData', filteredData.value)
})
</script>

<template>
    <div class="flex justify-between items-center px-8 pb-3">
        <div class="flex">
            <div v-for="value, key in columns"
                class="relative flex items-center bg-[#ecf0fb] rounded-full px-3 mr-2"
                :class="{ active: sortKey == key}"
                @click="sortBy(key)">
                <small class="w-14 px-2text-[#717377]">
                    {{ value }}
                </small>
                <span class="arrow"
                    :class="sortOrders[key] > 0 ? 'asc' : 'dsc'"/>
            </div>

            <div class="relative flex justify-end w-1/2 fill-slate-500 ml-8">
                <input type="text"
                    class="text-xs pr-10 rounded-md border-none bg-[#ecf0fb]"
                    placeholder="Search Item"
                    v-model="searchQuery"
                />
                <svg xmlns="http://www.w3.org/2000/svg" height=".8em" viewBox="0 0 512 512" class="absolute top-2.5 right-3"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
            </div>
        </div>

        <small class="font-bold text-[#717377]">
            <slot></slot>
        </small>
    </div>
</template>

<style>
div.active {
    background-color: #dddee0;
}

.arrow.active {
    opacity: 1;
}

.arrow {
  display: inline-block;
  vertical-align: middle;
  width: 0;
  height: 0;
  margin-left: 5px;
  opacity: 0.66;
}

.arrow.asc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 4px solid #0f0f0f;
}

.arrow.dsc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #0c0b0b;
}
</style>