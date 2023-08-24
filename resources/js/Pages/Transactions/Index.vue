<template>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-row-reverse">
                    <div class="p-2 mr-2">
                        <button @click.prevent="SendDate" class="btn btn-info">Search</button>
                    </div>
                    <div class="p-2 mr-2">
                        <input v-model="date" type="date" class="form-control" placeholder="Date">
                    </div>
                    <div class="p-2 mr-2">
                        <select v-model="status" class="form-select" aria-label="Default select example">
                            <option value="">Select Status</option>
                            <option value="savings">Savings</option>
                            <option value="loan">Loan</option>
                            <option value="wallet_topup">Wallet Top Up</option>
                            <option value="debit">Debit</option>
                            <option value="data">Data</option>
                        </select>
                    </div>

                    <div class="p-2 mr-2">
                        <input v-model="user" type="text" class="form-control" placeholder="search user">
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6></h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <Table v-if="tableData" :transactions ="tableData" />
                            <Table v-else :transactions ="transactions" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, ref } from 'vue';
    import Table from './Table.vue';
    const props = defineProps({
        'transactions': Object
    })

    const user = ref('');
    const date = ref('');
    const status = ref('');
    const tableData = computed(()=> {
        const name_sort = props.transactions.filter( (transaction) => transaction.name.toLowerCase().includes(user.value.toLowerCase()));
        if(!status.value){
            return name_sort;
        }
        return name_sort.filter((stat) => stat.type.toLowerCase() === status.value.toLowerCase());
    })

    const SendDate = () => {
        if(date.value){
            router.get(`/transactions?name=${user.value}&status=${status.value}&date=${date.value}`)
        }
    }
</script>

<style>

</style>
