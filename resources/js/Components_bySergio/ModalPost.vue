<template>

    <ModalVue :show="show" @close="changeStateShowModalPost" maxWidth="4xl">
        <div class="p-5">
            <div class="bg-white overflow-hidden shadow-none">
                <div class="grid grid-cols-3 min-w-full">

                    <div class="col-span-2 w-full">
                        <img class="w-full max-w-full min-w-full" :src="publicacion.image_path">
                    </div>

                    <div class="col-span-1 relative pl-4">
                        <header class="border-b border-grey-400">
                            <inertia-link
                                class="cursor-pointer py-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    :src="publicacion.user.profile_photo_url" />
                                <p class="block ml-2 font-bold"> {{ publicacion.user.name }} </p>
                            </inertia-link>
                        </header>

                        <div class="scroll" ref="scrollComments">

                            <comments v-for="(comment, index) in publicacion.comments" :key="index"
                                :comment="comment.comment" :nickName="comment.user.nick_name"
                                :urlImage="comment.user.profile_photo_url"></comments>

                        </div>

                        <div class="absolute bottom-0 left-0 right-0 pl-4">

                            <div class="pt-4">

                                <div class="mb-2">

                                    <div class="flex items-center justify-between mt-3 ">
                                        <div class="flex gap-5">
                                            <span class="cursor-pointer" @click="giveLikeOrDislike">
                                                <svg height="25" stroke="red" width="25" class="hover:fill-red-500"
                                                    :class="publicacion.likes.find(like => like.user_id === $page.props.user.id) ? 'fill-red-500' : 'fill-white'">
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
                                    </div>
                                    <div class="flex items-center">
                                        <span @click="likeDislike"
                                            class="mr-3 inline-flex items-center cursor-pointer"></span>
                                        <span class="mr-3 inline-flex items-center cursor-pointer"></span>
                                    </div>
                                    <span class="text-gray-600 text-sm font-bold"> {{ publicacion.countLikes }}
                                        Likes</span>
                                </div>
                                <span class="block ml-2 text-xs font-semibold text-gray-900"> {{
                                    publicacion.description
                                }} </span>
                            </div>

                            <div class="pt-4 pb-1 pr-3">
                                <div class="flex items-start">
                                    <input v-model="commentTxt" class="w-full resize-none outline-none appearance-none"
                                        aria-label="Agrega un comentario..." placeholder="Agrega un comentario..."
                                        autocomplete="off" autocorrect="off" style="height: 36px;" />
                                    <button v-if="(commentTxt.length > 0)" @click="makeComment($page.props.user.id)"
                                        class="mb-2 focus:outline-none border-none bg-transparent text-blue-600">Publicar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ModalVue>


</template>

<script>

import ModalVue from '@/Components/Modal.vue';
import Comments from './Comments.vue';

export default {
    data() {
        return {
            commentTxt: "",
        }
    },
    props: ["publicacion", "show"],
    components: {
        ModalVue,
        Comments
    },
    methods: {
        changeStateShowModalPost() {//emitiendo evento
            this.$emit("mostrandoElModal")
        },
        async giveLikeOrDislike() {

            await axios.post('/like-post', { post_id: this.publicacion.id }).then(res => {
                this.publicacion.likes = res.data.tableLikes
                console.log(res);
                if (res.data.like) {
                    this.publicacion.countLikes++
                } else {
                    this.publicacion.countLikes--
                }
            })

        },
        async makeComment(userId) {
            await axios
                .post("/comment", {
                    post_id: this.publicacion.id,
                    user_id: userId,
                    comment: this.commentTxt,
                })
                .then((res) => {
                    this.publicacion.comments.push(res.data);
                    this.publicacion.countComments++;
                    this.commentTxt = "";
                });
        },
    },
    created() {

    }

}

</script>