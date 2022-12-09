<template>
    <app-layout>
        <div class="container ml-44 mr-44">
            <div class="min-w-full border rounded lg:grid lg:grid-cols-3">
                <div class="border-r border-gray-300 lg:col-span-1">
                    <div class="mx-3 my-3">
                        <div class="relative text-gray-600">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input v-model="search" @keyup="searchFriends" type="search"
                                class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none" name="search"
                                placeholder="Search" required />
                        </div>
                    </div>


                    <ul v-if="(search.length > 0)" class="overflow-auto h-[32rem]">
                        <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Amigos</h2>
                        <template v-if="(userChats.length > 0)">
                            <li v-for="(usuario, index ) in userChats" :key="index">


                                <UserChatsVue :username="usuario.nick_name" :image="usuario.profile_photo_url" />


                            </li>
                        </template>
                        <template v-else>
                            <div class="my-2 mb-2 ml-2 text-sm text-gray-600">
                                No se encontraron amigos
                            </div>
                        </template>

                    </ul>

                    <ul class="overflow-auto h-[32rem]">
                        <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Chats</h2>
                        <li v-for="(Chat, index ) in chats" :key="index">


                            <UserChatsVue
                                :username="Chat.user_recive.id == $page.props.user.id ? Chat.user_sent.nick_name : Chat.user_recive.nick_name"
                                :image="Chat.user_recive.id == $page.props.user.id ? Chat.user_sent.profile_photo_url : Chat.user_recive.profile_photo_url"
                                :message="Chat.messages" />

                                

                        </li>
                    </ul>
                </div>
                <div class="hidden lg:col-span-2 lg:block">
                    <chat-vue></chat-vue>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import UserChatsVue from '../../Components_bySergio/UserChats.vue';
import ChatVue from '../../Components_bySergio/Chat.vue';
export default {
    data() {
        return {
            search: '',
            userChats: [],

        }
    },
    components: {
        AppLayout,
        UserChatsVue,
        ChatVue,
    },
    props: ["chats"],
    methods: {
        async searchFriends() {
            if (this.search.length > 0) {
                await axios.get("/search_user_from_chat/" + this.search)
                    .then(response => {
                        this.userChats = response.data
                    })
            } else {
                this.userChats = []

            }

        },
    },
}
</script>

<style>

</style>