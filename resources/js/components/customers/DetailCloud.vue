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
                    <div v-if="type && type.startsWith('image/')">
                        <img :src="file" alt="Image" />
                    </div>
                    <div v-else-if="type === 'application/pdf'">
                        <iframe :src="file" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                    <div v-else>
                        <p>Preview is not available for this file type.</p>
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
    path: '/detail/:cloud/:id',
    data() {
        return {
            type: null,
            file: null,
            id: null,
            selectedItems: [],
        }
    },
    created() {
        this.cloud = this.$route.params.cloud;
        this.id = this.$route.params.id;
        this.showFileDetails();
    },
    methods: {
        async showFileDetails() {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/get-file-details/${this.cloud}/${this.id}`);
                const { type, file } = response.data;
                this.type = type;
                this.file = file;
            } catch (error) {
                console.error("Error fetching file details: " + error);
            }
        },

        async downLoadFile() {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/file-down-load-cloud/${this.cloud}/${this.id}`, {
                    responseType: 'blob',
                });
                const url = URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', this.id);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error("Error downloading file: " + error);
            }
        },
        async deleteFileCloud() {
            try {
                await axios.delete(`http://127.0.0.1:8000/file-delete-cloud/${this.selectedItems}`);
                location.reload();
            } catch (error) {
                console.error("Error deleting file: " + error);
            }
        }
    }
}
</script>
