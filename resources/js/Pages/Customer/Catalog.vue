<template>
    <div class="container-fluid mt-4">
        <div class="row align-items-center">
            <div class="col-lg-4 col-sm-8">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active " :class="transactions &&('btn btn-primary text-white')"
                                @click.prevent="UserTransactions(customer.id)">
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" :class="savings &&('btn btn-primary text-white')"
                                @click.prevent="UserSavings(customer.id)">
                                Savings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" :class="loans &&('btn btn-primary text-white')"
                                @click.prevent="UserLoans(customer.id)">
                                Loans
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="d-flex flex-row-reverse">
                    <div class="p-2 mr-2">
                        <button @click.prevent="SendDate(customer.id)" class="btn btn-info">Search</button>
                    </div>
                    <div class="p-2 mr-2">
                        <input v-model="date" type="date" class="form-control" placeholder="Date">
                    </div>
                    <div class="p-2 mr-2">
                        <select v-if="savings" v-model="status" class="form-select" aria-label="Default select example">
                            <option value="">Select Status</option>
                            <option value="0">Active</option>
                            <option value="1">Completed</option>
                        </select>

                        <select v-if="loans" v-model="status" class="form-select" aria-label="Default select example">
                            <option value="">Select Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="2">Cancelled</option>
                        </select>

                        <select v-if="transactions" v-model="status" class="form-select" aria-label="Default select example">
                            <option value="">Select Status</option>
                            <option value="savings">Savings</option>
                            <option value="loan">Loan</option>
                            <option value="wallet_topup">Wallet Top Up</option>
                            <option value="debit">Debit</option>
                            <option value="data">Data</option>
                        </select>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6 v-if="savings">Savings</h6>
                        <h6 v-if="loans">Loans</h6>
                        <h6 v-if="transactions">Transactions</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div v-if="savings">
                                <SavingsTable v-if="tableData" :savings="tableData" :customer="customer" />
                                <SavingsTable v-else :savings="savings" :customer="customer" />
                            </div>

                            <div v-if="transactions">
                                <TransactionsTable v-if="tableData" :transactions="tableData" :customer="customer"/>
                                <TransactionsTable v-else :transactions="transactions" :customer="customer"/>
                            </div>

                            <div v-if="loans">
                                <LoansTable v-if="tableData" :loans = "tableData" :customer="customer"/>
                                <LoansTable v-else :loans = "loans" :customer="customer"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import LoansTable from './LoansTable.vue';
import SavingsTable from './SavingsTable.vue';
import TransactionsTable from './TransactionsTable.vue';
import { computed, ref } from 'vue';
    const props = defineProps({
        'transactions':Object,
        'savings':Object,
        'loans':Object,
        'customer': Object,
    })

    const UserTransactions = (id) => {
        router.get(`/customer/transactions/${id}`);
    }

    const UserLoans = (id) => {
        router.get(`/customer/loans/${id}`);
    }

    const UserSavings = (id) => {
        router.get(`/customer/savings/${id}`);
    }

    const status = ref('');
    const date = ref('');
    const tableData = computed(()=> {
        if(status.value && props.savings){
            return props.savings.filter((saving) => saving.status.toLowerCase() == status.value.toLowerCase());
        }

        if(status.value && props.loans){
            return props.loans.filter((loan) => loan.status == status.value);
        }

        if(status.value && props.transactions){
            return props.transactions.filter((transaction) => transaction.type.toLowerCase() == status.value.toLowerCase());
        }
    })

    const SendDate = (id) => {
        if(date.value && props.savings){
            router.get(`/customer/savings/${id}?status=${status.value}&date=${date.value}`)
        }

        if(date.value && props.loans){
            router.get(`/customer/loans/${id}?status=${status.value}&date=${date.value}`)
        }

        if(date.value && props.transactions){
            router.get(`/customer/transactions/${id}?status=${status.value}&date=${date.value}`)
        }
    }
</script>

<style>
.nav-link{
    cursor: pointer;
}
</style>
