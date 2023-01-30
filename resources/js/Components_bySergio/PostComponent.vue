<template>
    <!-- component -->
    <div class="bg-gray-100 mt-4">
        <div class="bg-white border rounded-sm max-w-xl2">
            <div class="flex items-center px-4 py-3">
                <img class="h-8 w-8 rounded-full" :src="post.user.profile_photo_url" :alt="post.user.name" />
                <div class="ml-3">
                    <a :href="'/profile/' + post.user.nick_name">
                        <span class="text-sm font-semibold antialiased block leading-tight">{{
                            post.user.nick_name
                        }}</span>
                        <span class="text-gray-600 text-xs block">{{
                            getDifferentTime(post.created_at)
                        }}</span>
                    </a>
                </div>
            </div>
            <img :src="post.image_path" />
           
            <div class="flex items-center justify-between mx-4 mt-3 mb-2">
                <div class="flex gap-5">
                    <span class="cursor-pointer" @click="giveLikeOrDislike">
                        <svg height="25" stroke="red" width="25" class="w-6 h-6 hover:fill-red-500" viewBox="0 0 23 23"
                            :class="post.likes.find(like => like.user_id === $page.props.user.id) ? 'fill-red-500' : 'fill-white'">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </span>
                    <span class="cursor-pointer" @click="setDataPost">
                        <svg fill="#262626" height="24" viewBox="0 0 48 48" width="24">
                            <path clip-rule="evenodd"
                                d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </span>

                </div>
                <div class="flex">
                    <svg fill="#262626" height="24" viewBox="0 0 48 48" width="24">
                        <path
                            d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="font-semibold text-sm mx-4 mt-2">
                {{ post.countLikes }} likes
            </div>
            <div class="font-black text-sm mx-4 mt-2">{{ post.description }}</div>

            <CommentsVue :comment="post.description" :nick_name="post.user.nick_name"
                :urlImage="post.user.profile_photo_url" />

            <div class="font-semibold text-sm mx-4 mt-2 mb-4">
                <a class="text-gray-400 text-sm cursor-pointer font-semibold">{{ post.countComments }} comments</a>
            </div>
            <div class="px-6 pt-4 pb-3">
                <div class="flex items-start">
                    <input v-model="textComment" class="w-full resize-none outline-none appearance-none"
                        aria-label="Agrega un comentario..." placeholder="Agrega un comentario..." autocomplete="off"
                        autocorrect="off" style="height: 36px" />
                    <button v-if="textComment.length > 0" @click="makeComment($page.props.user.id)"
                        class="mb-2 focus:outline-none border-none bg-transparent text-blue-600">
                        Publicar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CommentsVue from "./Comments.vue";
import moment from "moment";
import axios from "axios";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        CommentsVue,
    },

    data() {
        return {
            textComment: "",
        };
    },

    props: ["post"], //estas props son las propiedades que nosotros recivimos

    methods: {
        getDifferentTime(date) {
            return moment(date).toNow(true);
        },
        setDataPost() {
            this.$emit("dataPost", this.post); //revisando el codigo le paso solo la informacion nada mas la que seleccionoa
        },
        async giveLikeOrDislike() {
            await axios.post("/like-post", { post_id: this.post.id }).then((res) => {
                this.post.likes = res.data.tableLikes;
                console.log(res);
                if (res.data.like) {
                    this.post.countLikes++;
                } else {
                    this.post.countLikes--;
                }
            });
        },
        async makeComment(userId) {
            await axios
                .post("/comment", {
                    post_id: this.post.id,
                    user_id: userId,
                    comment: this.textComment,
                })
                .then((res) => {
                    this.post.comments.push(res.data);
                    this.post.countComments++;
                    this.textComment = "";
                });
        },
    },
    created() {
        console.log(this.post.likes);
        // console.log($page.props.auth.roles[0]);
    },
};
</script>
