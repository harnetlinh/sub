<template>
    <div class="relative py-16 bg-gradient-to-br from-sky-50 to-gray-200">
        <div class="p-4 sm:ml-64">
              
            
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">

        </div>
    </div>
</template>

<script>
export default {
    name: "listCloud",
    data() {
        return {
            msg: "Welcome to Your Vue.js App",
        };
    },
    methods: {
        loginAuth() {
            window.location.href = `http://127.0.0.1:8000/google/login`;
        },
    },
};
</script>
