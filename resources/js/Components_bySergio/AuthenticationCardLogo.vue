<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link :href="'/'">
    <img :src="rutaImage" alt="logo_alternativo">
    </Link>
</template>

<script>


export default {
    data() {
        return {
            rutaImage: "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1280px-Instagram_logo.svg.png"
        }
    }
}
</script>

<style scoped>
img {
    width: 200px;
    align-items: center;
    display: block;
    margin: auto;
}
</style>

