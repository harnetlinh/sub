<template>
    <div class="relative py-16 bg-gradient-to-br from-sky-50 to-gray-200">
        <div class="p-4 sm:ml-64">
            <h1
                class="mb-4 text-3xl font-extrabold text-gray-400 dark:text-white md:text-5xl lg:text-3xl"
            >
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400"
                    >{{ this.title }}.</span
                >
            </h1>
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button
                        type="button"
                        @click="isUpload = true"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        Upload file
                    </button>
                    <button
                        type="button"
                        @click="isNewFolder = true"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        New Folder
                    </button>
                    <button
                        type="button"
                        @click="deleteFileCloud"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        Trash
                    </button>
                    <button
                        type="button"
                        @click="deleteFileCloud"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        Rename
                    </button>
                    <button
                        type="button"
                        @click="deleteFileCloud"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        Copy to
                    </button>
                    <button
                        type="button"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >
                        <a :href="urlOfficial"> Official Site </a>
                    </button>
                </div>
                <div class="flex items-center">
                    <div class="relative mb-3" data-te-input-wrapper-init>
                        <input
                            type="search"
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleSearch2"
                            placeholder="Type query"
                        />
                        <label
                            for="exampleSearch2"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                            >Search</label
                        >
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="relative overflow-x-auto">
                <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">CheckBox</th>
                            <th scope="col" class="px-6 py-3">File Name</th>
                            <th scope="col" class="px-6 py-3">Size</th>
                            <th scope="col" class="px-6 py-3">Date Modified</th>
                        </tr>
                    </thead>
                    <tbody v-for="product in products" :key="product.id">
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <input
                                        id="default-checkbox"
                                        type="checkbox"
                                        :value="product.path"
                                        v-model="selectedItems"
                                        class=""
                                    />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <router-link
                                    :to="{
                                        name: 'detailDrive',
                                        params: { id: product.path },
                                    }"
                                >
                                    {{ product.path }}
                                </router-link>
                            </td>
                            <td class="px-6 py-4">{{ product.file_size }}</td>
                            <td class="px-6 py-4">
                                {{ product.last_modified }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div
        v-show="isUpload"
        class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
    >
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl">Model Title</h3>
                <svg
                    @click="isUpload = false"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-red-900 cursor-pointer"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>
            <div class="mt-4">
                <form
                    v-on:submit.prevent="uploadFileCloud"
                    enctype="multipart/form-data"
                    class="mb-4 text-sm"
                    action="post"
                >
                    <div>
                        <label
                            for="file"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Upload file</label
                        >
                        <input
                            type="file"
                            name="file"
                            id="file"
                            placeholder="••••••••"
                            v-on:change="onChange"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>
                    <br />
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Upload file to cloud
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div
        v-show="isNewFolder"
        class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
    >
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl">New Folder</h3>
                <svg
                    @click="isNewFolder = false"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-red-900 cursor-pointer"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>
            <div class="mt-4">
                <form
                    v-on:submit.prevent="newFolder"
                    enctype="multipart/form-data"
                    class="mb-4 text-sm"
                    action="post"
                >
                    <div>
                        <label
                            for="file"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >New Folder</label
                        >
                        <input
                            type="text"
                            name="folder"
                            id="folder"
                            :value="folder"
                            v-model="folder"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>
                    <br />
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        New folder
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script >
import axios from "axios";

export default {
    name: "singleDrive",
    data() {
        return {
            title: "",
            cloud: "",
            isUpload: false,
            isNewFolder: false,
            file: "",
            folder: "",
            id: null,
            urlOfficial: "https://drive.google.com/drive/folders",
            products: [],
            selectedItems: [],
        };
    },
    created() {
        this.id = this.$route.params.id;
        this.cloud = this.$route.params.cloud;
        this.showDrive();
        this.showFileCloud();
    },
    // watch:{
    //     '$route.params.id': function(sideId){
    //         this.id = sideId;
    //         console.log(this.id)
    //     },
    // },
    mounted() {
    },
    methods: {
        async showDrive() {
            const { data } = await axios.get(
                `http://127.0.0.1:8000/get-single-drive/${this.cloud}/${this.id}`
            );
            this.title = data.data.title;
        },
        async showFileCloud() {
            const { data } = await axios.get(
                `http://127.0.0.1:8000/get-all-file-cloud/${this.cloud}`
            );
            this.products = data.data;
        },
        onChange(e) {
            this.file = e.target.files[0];
        },
        async uploadFileCloud() {
            let data = new FormData();
            data.append("file", this.file);
            await axios.post(`http://127.0.0.1:8000/file-upload-cloud/${this.cloud}`, data);
            location.reload();
        },
        async newFolder() {
            let data = { key: this.folder };
            await axios.post(`http://127.0.0.1:8000/new-folder/${this.cloud}`, data);
            location.reload();
        },
        async deleteFileCloud() {
            await axios.delete(
                `http://127.0.0.1:8000/file-delete-cloud/${this.cloud}/${this.selectedItems}`
            );
            location.reload();
        },
    },
};
</script>
