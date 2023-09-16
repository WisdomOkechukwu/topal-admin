<template>
    <div class="row mt-2">
        <Transactions :options="transaction_options" :series="transaction_series" :transaction_dropdown="transaction_dropdown" :url="url"/>

    </div>

    <div class="row mt-2">
        <Loans :options="loan_options" :series="loan_series" :url="url"/>
    </div>

    <div class="row mt-2">
        <Savings :options="saving_options" :series="saving_series" :url="url"/>
    </div>
</template>

<script setup>
    import {
      onUpdated,
        ref,
    } from 'vue';
    import Loans from './Charts/Loans.vue';
    import Transactions from './Charts/Transactions.vue';
    import Savings from './Charts/Savings.vue';

    const props = defineProps({
        'transaction_options': Object,
        'transaction_series': Array,
        'loan_options': Object,
        'loan_series': Array,
        'saving_options': Object,
        'saving_series': Array,
        'transaction_dropdown':Object,
        'url': String,
    })

    var type = ref('area');
    var status = ref('')
    var date = ref({
        month: new Date().getMonth(),
        year: new Date().getFullYear()
    });

    onUpdated(() => {
        if(date.value){

        }
    })
</script>

<style>

</style>
