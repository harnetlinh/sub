<template>
    <div class="relative py-16 bg-gradient-to-br from-sky-50 to-gray-200">
        <div class="p-4 sm:ml-64">
            <h1 class="mb-4 text-3xl font-extrabold text-gray-400 dark:text-white md:text-5xl lg:text-3xl">
                <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">{{ id }}</span>
            </h1>
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button type="button" @click="downLoadFile"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        Download file
                    </button>
                    <button type="button" @click="deleteFileCloud"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        Trash
                    </button>
                </div>
            </div>
            <br />
            <br />
            <div class="relative flex  flex-col rounded-xl bg-white bg-clip-border  shadow-md">
                <div class="p-6">
                    <div v-show="type == 'jpg'">
                        <img :src="file" alt=""/>
                    </div>
                    <div v-show="type == 'png'">
                        <img :src="file" alt=""/>
                    </div>
                    <div v-show="type == 'pdf'">
                        <iframe :src="file" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                    <div v-show="type == 'docx'">
                        <iframe :src="file" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                    <div v-show="type == null">
                        <img src="https://i.pinimg.com/originals/49/d3/90/49d390ed4b730c2a927c82c62baa0e43.gif" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'detailDrive',
    data() {
        return {
            image: null,
            type: null,
            file: null,
            id: null,
            selectedItems: [],
        }
    },
    created() {
        this.id = this.$route.params.id;
        this.disPlayDrive();
    },
    // mounted() {
    //     console.log(this.type);
    // },
    methods: {
        async disPlayDrive() {
            const result = await axios.get(`http://127.0.0.1:8000/get-file-upLoad-cloud/${this.id}`);
            this.file = result.data.url;
            this.type = result.data.type;
        },
        async downLoadFile() {
            const response = await axios.get(`http://127.0.0.1:8000/file-down-load-cloud/${this.id}`, {
                responseType: 'blob',
            });
            const url = URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', this.id);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        async deleteFileCloud() {
            await axios.delete(`http://127.0.0.1:8000/file-delete-cloud/${this.selectedItems}`);
            location.reload();
        }
    }
}
</script>