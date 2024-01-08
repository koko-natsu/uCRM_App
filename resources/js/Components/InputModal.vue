<script setup>
import { watch, ref } from 'vue';
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    }
})

const emit = defineEmits(['close'])
const closeable = ref(props.closeable);

const close = () => {
    if(closeable.value) {
        emit('close')
    }
}

const closeOnEscape = (e) => {
    if(e.key === 'Escape' && props.show) {
        close()
    }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show"  class="modal-mask scrollbar-hide flex fixed z-[9998] rounded-lg inset-20 whitespace-nowrap overflow-auto">

                <div class="fixed inset-0 transform transition-all bg-black/30" @click="close">
                    <div class="absolute inset-0" />
                </div>

                <div class="modal-container w-full m-auto">
                    <div class="bg-white rounded-lg shadow-xl transform transition-all sm:w-full sm:mx-auto px-10 py-5">
                        <div class="flex justify-end">
                            <button
                                class="modal-default-button"
                                @click="close"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                </svg>
                            </button>
                        </div>
        
                        <div class="modal-header font-bold text-xl">
                            <slot name="header"></slot>
                        </div>
        
                        <div class="modal-body">
                            <slot name="body"></slot>
                        </div>
                    </div> 
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.modal-mask {
    transition: opacity 0.2 ease;
}

.modal-container {
  transition: all 0.5s ease;
}

.modal-body {
    margin: 20px 0;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.05);
  transform: scale(1.05);
}

/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>