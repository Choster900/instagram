<template>
    <div class="max-w-sm sm:max-w-md md:max-w-lg w-full">


        <button @click="changeStateShowCreatePost"
            class="w-full mt-5 text-center bg-blue-500 rounded text-white py-2 outline-none focus:outline-none hover:bg-blue-600">Agregar
            publicacion
        </button>


        <div v-if="(post.length > 0)">
            <post-component-vue v-for="(publicaciones, i) in post" :key="i" :post="publicaciones"/>
        </div>
        <div v-else class="text-3x1 text-center mt-4">No hay publicaciones</div>


        
        <ModalVue :show="showModal" @close="changeStateShowCreatePost">
            <div class="p-5">
                <div class="">
                    <input v-model="text" type="text"
                        class="w-full outline-none focus:outline-none p-2 rounded appearance-none border-none"
                        placeholder="En que estas pensando">

                    <div class="my-5">
                        <img class="rounded-lg" v-if="url" :src="url"
                            style="max-width: 100%; max-height: 400px; margin: 0 auto;">
                    </div>
                    <div class="flex justify-end">
                        <button @click="selecImage"
                            class="outline-none focus:outline-none inline-flex items-center rounded-full cursor-pointer bg-blue-500 p-2">
                            <svg class="text-white h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>

                        </button>
                        <input @change="fileChange" type="file" name="image" id="image"
                            accept="image/gif,image/jpeg,image/png,image/jpg,image" style="display: none ;">
                    </div>
                    <div class="text-red-500 pd-2 mt-5">
                        {{ error_img }}
                    </div>
                </div>
                <button v-if="(text.length > 0 && img != null)" @click="createPost"
                    class="w-full mt-5 text-center bg-blue-500 rounded text-white py-2 outline-none focus:outline-none hover:bg-blue-600">
                    Publicar
                </button>
            </div>
        </ModalVue>


    </div>
</template>

<script>

import PostComponentVue from '../Components_bySergio/PostComponent.vue';
import ModalVue from '../Components/Modal.vue';
export default {
    data() {
        return {//estas son las variables
            showModal: false,
            url: null,
            img: null,
            text: '',
            post: [],
            error_img: null,
        }
    },
    components: {
        PostComponentVue,
        ModalVue
    },
    methods: {
        async getPost() {
            await axios.get("/list-post").then(response => {
                this.post = response.data
            })
        },
        changeStateShowCreatePost() {
            this.showModal = !this.showModal
        },
        fileChange(e) {
            let file = e.target.files[0]
            this.img = file
            this.url = URL.createObjectURL(file)

        },
        selecImage() {
            document.getElementById("image").click()
        },
        async createPost() {

            const formData = new FormData()
            formData.append('image', this.img)
            formData.append('text', this.text)

            await axios.post('/create-post', formData, {

                headers: {
                    'Content-Type': 'multipart/form-data'//sin esto no se puede envari la iamgen
                }

            }).then((res) => {
                this.post.unshift(res.data)
                this.resentForm()
            }).catch(Error => {
                if (Error.response.status === 422) {
                    this.error_img = Error.response.data.message
                    setTimeout(() => {
                        this.error_img = null
                    }, 5000);
                }
            })
        },
        resentForm() {//reseteando formulario
            this.showModal = false
            this.url = null
            this.img = null
            this.text = ''
        }
    },
    created(){
        this.getPost()
    }
}

</script>