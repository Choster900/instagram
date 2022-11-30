<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link :href="'/'">
        <img src="https://i.ytimg.com/vi/l0eC04yHYPk/maxresdefault.jpg" alt="logo_alternativo">
    </Link>
</template>

<script>

import rutaImage from '../../images/logo4.jpg'

export default {
    data(){
        return{
            rutaImage: rutaImage
        }
    }
}
</script>

<style scoped>
img{
    width: 200px;
}
</style>

