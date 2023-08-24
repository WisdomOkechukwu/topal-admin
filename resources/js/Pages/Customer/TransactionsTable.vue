<template>
    <table class="table align-items-center justify-content-center mb-0">
        <thead>

            <tr>
                <th class="text-uppercase text-xs font-weight-bolder ">
                    Name
                </th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    Transaction</th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    Date</th>
                <th class="text-uppercase text-xs font-weight-bolder  ps-2"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="transaction in transactions" :key="transaction.id">
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="../../../assets/img/team-2.jpg"
                                class="avatar avatar-sm rounded-circle me-2 ">
                        </div>
                        <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{ transaction.name }}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <h6 class="mb-0 text-sm">{{ transaction.type }}</h6>
                </td>
                <td>
                    <h6 class="mb-0 text-sm">{{ transaction.date }}</h6>
                </td>

                <td class="align-middle">
                    <!-- <h6 class="mb-0 text-sm">21 July 2023</h6> -->
                    <button @click.prevent="showTransactions(transaction.id)" class="btn btn-primary">
                        view
                    </button>
                </td>

            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { router } from '@inertiajs/vue3';


    const props = defineProps({
        'transactions':Object,
        'customer': Object
    })

    const showTransactions = (id) => {
        router.get(`/transactions/show/${id}`);
    }
</script>

<style>

</style>
