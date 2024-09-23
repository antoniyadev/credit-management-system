<template>
    <form @submit.prevent="storePayment(payment.credit_id, payment.amount)">
        <!-- Credit -->
        <div class="mt-4">
            <label for="credit" class="block text-sm font-medium text-gray-700">
                Credit
            </label>
            <select
                id="credit"
                v-model="payment.credit_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option value="" selected>-- Choose credit --</option>
                <option v-for="credit in creditsForPayment" :value="credit.id">
                    {{ credit.serial_number }}
                </option>
            </select>

            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.credit_id">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Amount -->
        <div class="mt-4">
            <label
                for="payment-amount"
                class="block text-sm font-medium text-gray-700"
            >
                Amount
            </label>
            <input
                id="payment-amount"
                v-model="payment.amount"
                type="number"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.amount">
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
import { useRoute } from "vue-router";
import useCredits from "@/composables/credits";

const payment = reactive({
    credit_id: "",
    amount: "",
});

const {
    credit,
    getCredit,
    creditsForPayment,
    getCreditsForPayment,
    storePayment,
    isLoading,
    validationErrors,
} = useCredits();

const route = useRoute();

onMounted(() => {
    getCreditsForPayment();
    if (route.params.credit_id) {
        getCredit(route.params.credit_id);
        payment.credit_id = route.params.credit_id;
    }
});
</script>
