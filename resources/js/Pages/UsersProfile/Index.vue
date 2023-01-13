<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
     <app-layout>


          <div class="w-7/12">
               <div class="flex justify-center pb-10">
                    <img :src="userProfile.profile_photo_url" class="h-40 w-40 rounded-full object-cover"
                         :alt="userProfile.nick_name" />
                    <div class="ml-10">
                         <div class="flex items-center">
                              <h2 class="block leading-relaxed font-light text-gray-700 text-3xl">
                                   {{ userProfile.nick_name }}
                              </h2>
                              <Link class="
                cursor-pointer
                h-7
                px-3
                ml-3
                outline-none
                border-transparent
                text-center
                rounded
                border
                bg-blue-500
                hover:bg-blue-600
                text-white
                bg-transparent
                font-semibold
              ">
                              Enviar mensaje</Link>
                              <Link class="
                cursor-pointer
                h-7
                px-3
                ml-3
                focus:outline-none
                hover:border-transparent
                text-center
                rounded
                border border-gray-400
                hover:bg-blue-500 hover:text-white
                bg-transparent
                text-gray-500
                font-semibold
              ">
                              Editar perfil</Link>
                         </div>
                         <ul class="flex justify-content-around items-center">
                              <li>
                                   <span class="block text-base flex"><span class="font-bold mr-2">{{ postCount }}
                                        </span>
                                        publicaciones</span>
                              </li>
                              <li>
                                   <span class="cursor-pointer block text-base flex ml-5"><span
                                             class="font-bold mr-2">{{ followers }} </span>
                                        seguidores</span>
                              </li>
                              <li>
                                   <span class="cursor-pointer block text-base flex ml-5"><span
                                             class="font-bold mr-2">{{ followed }} </span>
                                        seguidos</span>
                              </li>
                         </ul>
                         <br />
                         <div class="">
                              <h1 class="text-base font-bold font-light">
                                   {{ userProfile.nick_name }}
                              </h1>
                              <h3 class="text-sm font-light">{{ userProfile.name }}</h3>
                              <span class="text-base">{{ userProfile.presentacion }}</span>
                              <a class="block text-base text-blue-500 mt-2" target="_blank"
                                   :href="userProfile.web_site">{{
                                        userProfile.web_site
                                   }}</a>
                         </div>
                    </div>
               </div>
               <!-- <div class="border-b border-gray-300">
                <article v-for="(post, i) in publicaciones_de_usuario" :key="i" class="mt-5 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-10">
                    <image-post v-for="(post,index) in posts" :key="index" :post="post" @show="changeStateModalPost"></image-post> -->

               <!-- <div class="cursor-pointer relative" style="width:300px; height:300px">
                        <img :src="post.image_path" alt="" class="foto w-full h-wll object-cover">
                    </div>
                </article>
            </div> -->

               <section class="container px-6 py-4 mx-auto">
                    <div class="grid gap-6 mb-8 md:grid-cols-1 lg:grid-cols-3">
                         <div v-for="(post, i) in publicaciones_de_usuario" :key="i" class="flex items-center ">
                              <img @click="mostrando_modal(post)" :src="post.image_path" alt=""
                                   class="foto w-full h-wll object-cover rounded-lg cursor-pointer hover:bg-sky-700"
                                   style="width: 300px; height: 300px;">
                         </div>
                    </div>
               </section>

          </div>

          <ModalPostVue :show="showModalPost" :publicacion="unicPost" @mostrandoElModal="changeStateModalPost" />

     </app-layout>
</template>
<script>

import ModalPostVue from '../../Components_bySergio/ModalPost.vue';

export default {
     data() {
          return {
               showModalPost: false,
               unicPost: [],
          }
     },
     components: {
          ModalPostVue,
     },
     props: [
          "userProfile",
          "followers",
          "followed",
          "postCount",
          "publicaciones_de_usuario",
     ],
     methods: {
          changeStateModalPost() {
               this.showModalPost = !this.showModalPost

          },
          mostrando_modal(post) {
               this.unicPost = post
               this.changeStateModalPost();
          }
     }
};
</script>
