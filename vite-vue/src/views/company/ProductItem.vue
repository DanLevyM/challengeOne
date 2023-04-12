<template>
    <button class="buttonAction"><i class="bi bi-trash text-danger" @click.prevent="$emit('delete')"></i></button>
    <button class="buttonAction"><i class="bi bi-pencil-square text-warning"></i></button>
</template>

<script>
export default {
    name: 'productItem'
}
</script>