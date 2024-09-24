<template>
    <form @submit.prevent="storeCredit(credit)">
        <!-- Recipient -->
        <div class="mt-4">
            <label
                for="credit-recipient"
                class="block text-sm font-medium text-gray-700"
            >
                Recipient
            </label>
            <select
                id="credit-recipient"
                v-model="credit.recipient_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option value="" selected>-- Choose recipient --</option>
                <option v-for="recipient in recipients" :value="recipient.id">
                    {{ recipient.name }}
                </option>
            </select>

            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.recipient_id">
                    {{ message }}
                </div>
            </div>

            <div class="mt-3">
                <router-link
                    :to="{ name: 'recipients.create' }"
                    class="p-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700"
                >
                    Add new recipient
                </router-link>
            </div>
        </div>

        <!-- Amount -->
        <div class="mt-4">
            <label
                for="credit-amount"
                class="block text-sm font-medium text-gray-700"
            >
                Amount
            </label>
            <input
                id="credit-amount"
                v-model="credit.amount"
                type="number"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.amount">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Term In Months -->
        <div class="mt-4">
            <label
                for="term-in-months"
                class="block text-sm font-medium text-gray-700"
            >
                Term in months
            </label>
            <input
                id="term-in-months"
                v-model="credit.term_in_months"
                type="number"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.term_in_months">
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
import useCredits from "@/composables/credits";
import { useRoute } from "vue-router";

const credit = reactive({
    recipient_id: "",
    amount: "",
    term_in_months: "",
});

const { recipient, getRecipient, recipients, getRecipients, storeRecipients } =
    useRecipients();
const { storeCredit, validationErrors, isLoading } = useCredits();
const route = useRoute();

onMounted(() => {
    getRecipients();
    if (route.query.recipient_id) {
        credit.recipient_id = route.query.recipient_id;
    }
});
</script>
