<template>
    <a v-if=" message.length > 0"
          class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
        <img class="object-cover w-10 h-10 rounded-full" :src="image" />
        <div class="w-full pb-2">
            <div class="flex justify-between">
                <span class="block ml-2 font-semibold text-gray-600"> {{ username }} </span>
                <span v-if="message" class="block ml-2 text-sm text-gray-600">{{ getDifferentTime(message[0].send_date)
                }}</span>
            </div>
            <span v-if="message" class="block ml-2 text-sm text-gray-600">{{ message[0].message }}</span>
        </div>
    </a>

    <a v-else
        class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
        <div class="w-full pb-2">
            No hay mensajes
        </div>
    </a>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            name: 'John Doe'
        }
    },
    props:{
        username: {
            type: String,
            required: false
        },
        image: {
            type: String,
            required: false
        },
        message: {
            type: Array,
            required: false
        },
    },
    /* props: 
    {
    "username":{

        },
     "image",
     "message"
    } */
    methods: {
        getDifferentTime(date) {
            return moment(date).toNow(true);
        },
    }
}
</script>

<style>

</style>