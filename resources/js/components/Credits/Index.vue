<template>
    <div class="p-6 overflow-hidden overflow-x-auto bg-white border-gray-200">
        <div
            class="min-w-full align-middle"
            v-if="credits.data !== undefined && credits.data.length !== 0"
        >
            <table
                id="credits-table"
                class="min-w-full border divide-y divide-gray-200"
            >
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Serial Number</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <div
                                class="flex flex-row items-center justify-between cursor-pointer"
                                @click="updateOrdering('recipient_name')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'recipient_name',
                                    }"
                                >
                                    Recipient
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn ===
                                                    'recipient_name',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn ===
                                                    'recipient_name',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn ===
                                                    'recipient_name',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn ===
                                                    'recipient_name',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Term In Months</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Monthly Installment</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Amount</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Remaining Balance</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <div
                                class="flex flex-row items-center justify-between cursor-pointer"
                                @click="updateOrdering('created_at')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'created_at',
                                    }"
                                >
                                    Created at
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn === 'created_at',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn === 'created_at',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn === 'created_at',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn === 'created_at',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Actions</span
                            >
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr v-for="credit in credits.data">
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.serial_number }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.recipient_name }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.term_in_months }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.monthly_installment }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.amount }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.remaining_balance }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ credit.created_at }}
                        </td>
                        <td class="w-40" v-show="credit.remaining_balance > 0">
                            <router-link
                                class="add-payment-{{credit_id}} p-2 m-2 font-bold text-white bg-green-500 rounded hover:bg-green-700"
                                :to="{
                                    name: 'payments.create',
                                    params: { credit_id: credit.id },
                                }"
                                >Add payment</router-link
                            >
                        </td>
                    </tr>
                </tbody>
            </table>

            <TailwindPagination
                :data="credits"
                @pagination-change-page="getCredits"
                class="mt-4"
            />
        </div>
        <div v-else>No credits found</div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { TailwindPagination } from "laravel-vue-pagination";
import useCredits from "@/composables/credits";

const orderColumn = ref("created_at");
const orderDirection = ref("desc");
const { credits, getCredits } = useCredits();
onMounted(() => {
    getCredits();
});
const updateOrdering = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === "asc" ? "desc" : "asc";
    getCredits(1, orderColumn.value, orderDirection.value);
};
</script>
