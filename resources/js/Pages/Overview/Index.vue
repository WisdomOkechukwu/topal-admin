<template>
    <div class="row mt-4">
    <!-- <Chart :options="options" :series="series" /> -->
    <Transactions :options="transaction_options" :series="transaction_series" :transaction_dropdown="transaction_dropdown" :url="url"/>
    <Loans :options="loan_options" :series="loan_series" :url="url"/>
    <Savings :options="saving_options" :series="saving_series" :url="url"/>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h5 class="text-capitalize">Recent Transactions</h5>
                </div>
                <div class="card-body p-3">
                    <!-- Table -->
                    <Recent :transactions="transactions" />
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
    import Recent from './Recent.vue';
    import Transactions from './Charts/Transactions.vue';
    import Savings from './Charts/Savings.vue';
    import Loans from './Charts/Loans.vue';

    const props = defineProps({
        'transaction_options': Object,
        'transaction_series': Array,
        'loan_options': Object,
        'loan_series': Array,
        'saving_options': Object,
        'saving_series': Array,
        'transactions': Object,
        'transaction_dropdown': Object,
        'url': String,
    })
</script>

<style>

</style>
