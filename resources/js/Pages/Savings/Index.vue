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
                            <option>Select Status</option>
                            <option value="0">Active</option>
                            <option value="1">Completed</option>
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
                            <Table v-if="tableData" :savings ="tableData" />
                            <Table v-else :savings ="savings" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';
    import { computed, ref } from 'vue';
    import Table from './Table.vue';

    const props = defineProps({
        'savings': Object
    });

    const user = ref('');
    const date = ref('');
    const status = ref('');
    const tableData = computed(()=> {
        const name_sort = props.savings.filter( (saving) => saving.name.toLowerCase().includes(user.value.toLowerCase()));
        if(!status.value){
            return name_sort;
        }
        return name_sort.filter((stat) => stat.status === status.value);
    })

    const SendDate = () => {
        if(date.value){
            router.get(`/savings?name=${user.value}&status=${status.value}&date=${date.value}`)
        }
    }
</script>

<style>

</style>
