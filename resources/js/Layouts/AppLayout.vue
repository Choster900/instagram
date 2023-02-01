<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components_bySergio/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import AuthenticationCardLogo from "@/Components_bySergio/AuthenticationCardLogo.vue";
import { def } from "@vue/shared";
import axios from "axios";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    Inertia.post(route("logout"));
};
</script>

<template>
    <div>

        <Head :title="title" />
        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-300">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center w-28">
                                <Link :href="route('dashboard')">
                                <AuthenticationCardLogo />
                                </Link>
                            </div>

                            <!-- Buscando usuarios Dropdown -->
                            <div class="ml-96 relative mt-1">

                                <div class="pt-2 relative mx-auto text-gray-600">
                                    <input v-model="buscando" @input="buscarUsuario"
                                        class="border-2 border-gray-300 bg-white w-100 h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                                        type="search" placeholder="Buscar amigos" />

                                    <span class="absolute right-0 top-0 mt-5 mr-4">
                                        <svg class="text-gray-600 h-4 w-4 fill-current"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px"
                                            y="0px" viewBox="0 0 56.966 56.966" style="
                                                        enable-background: new 0
                                                            0 56.966 56.966;
                                                    " xml:space="preserve" width="512px" height="512px">
                                            <path
                                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                                        </svg>
                                    </span>
                                </div>

                                <div v-if="activo" class="drop-shadow-2xl bg-white rounded-md">
                                    <div v-if="usuarios.length > 0">
                                        <Link class="flex items-center py-2 px-3 hover:bg-gray-100"
                                            v-for="(usuario, i) in usuarios" :key="i" :href="
                                                '/profile/' +
                                                usuario.nick_name
                                            ">
                                        <img :src="
                                            usuario.profile_photo_url
                                        " class="rounded-full w-9 h-9 object-cover" />
                                        <div class="ml-2">
                                            <span class="block font-bold text-gray-700 text-sm">{{
                                                usuario.nick_name
                                            }}</span>
                                            <span class="block font-light text-gray-400 text-sm">{{
                                                usuario.name
                                            }}</span>
                                        </div>

                                        </Link>
                                    </div>

                                    <Link class="flex items-center py-2 px-3 hover:bg-gray-100" v-else>
                                    <p class="text-center font-semibold text-sm">No se encontraron amigos</p>
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- settings Dropdown -->
                            <div class="ml-3 relative">
                                <Link class="flex items-center py-2 px-3" href="x">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 -rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                                </Link>
                            </div>
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="
                                            $page.props.jetstream
                                                .managesProfilePhotos
                                        "
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="
                                                $page.props.user
                                                    .profile_photo_url
                                            " :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                <img :src="
                                                    $page.props.user
                                                        .profile_photo_url
                                                " class="h-10 w-10 rounded-full" alt="" />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <DropdownLink :href="
                                            '/profile/' +
                                            $page.props.user.nick_name
                                        ">
                                            perfil
                                        </DropdownLink>

                                        <DropdownLink :href="route('profile.show')">
                                            Configuracion
                                        </DropdownLink>

                                        <DropdownLink v-if="
                                            $page.props.jetstream
                                                .hasApiFeatures
                                        " :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-100" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <!-- Page Content -->
            <main>
                <div class="max-w-7x1 min-w-7x1 mx-auto py-14">
                    <div class="flex justify-center">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            usuarios: [],
            buscando: "",
            activo: false
        };
    },
    methods: {
        async buscarUsuario() {
            await axios.get("/search/" + this.buscando).then((response) => {
                this.usuarios = response.data;
            });
        },
    },
    watch: {
        buscando(nuevoValor, valorAnterior) {
            this.buscando.length > 0 ? this.activo = true : this.activo = false
            console.log("El nombre pasó de ser %s a %s", valorAnterior, nuevoValor);
        }
    }
};
</script>
