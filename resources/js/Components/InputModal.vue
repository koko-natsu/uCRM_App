<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close'])

const close = () => {
    emit('close')
}

</script>

<template>
    <Transition name="modal">
        <div v-if="show"  class="modal-mask flex fixed z-[9998] top-0 left-0 w-full h-full bg-black/30">
            <div class="modal-container w-1/2 bg-white m-auto p-10 rounded-lg shadow-indigo-500/50 ease-ln duration-300">
                <div class="flex justify-end">
                    <button
                        class="modal-default-button"
                        @click="close">
                        <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></button>
                </div>

                <div class="modal-header font-bold text-xl">
                    <slot name="header">

                    </slot>
                </div>

                <div class="modal-body">
                    <slot name="body"></slot>
                </div>

            </div>
        </div>
    </Transition>
</template>

<style scoped>
.modal-mask {
    transition: opacity 0.35 ease;
}

.modal-container {
  transition: all 0.3s ease;
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
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>