<template>
    <form @submit.prevent="storeRecipient(recipient)">
        <!-- Name -->
        <div class="mt-4">
            <label
                for="recipient-name"
                class="block text-sm font-medium text-gray-700"
            >
                Name
            </label>
            <input
                id="recipient-name"
                v-model="recipient.name"
                type="text"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.name">
                    {{ message }}
                </div>
            </div>
        </div>
        <!-- Email -->
        <div class="mt-4">
            <label
                for="recipient-email"
                class="block text-sm font-medium text-gray-700"
            >
                Email
            </label>
            <input
                id="recipient-email"
                v-model="recipient.email"
                type="email"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.email">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4">
            <button
                :disabled="isLoading"
                class="inline-flex items-center px-3 py-2 text-sm text-white uppercase bg-indigo-600 rounded-md disabled:opacity-75 disabled:cursor-not-allowed"
            >
                <span
                    v-show="isLoading"
                    class="inline-block w-4 h-4 mr-2 border-t-2 border-b-2 border-l-2 border-r-2 rounded-full animate-spin border-t-white border-r-white border-b-white border-l-blue-600"
                ></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { onMounted, reactive } from "vue";
import useRecipients from "@/composables/recipients";

const recipient = reactive({
    name: "",
    email: "",
});

const { storeRecipient, isLoading, validationErrors } = useRecipients();
</script>
