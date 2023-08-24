<template>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-row-reverse">
                    <div class="p-2 mr-2">
                        <select v-model="status" class="form-select" aria-label="Default select example">
                            <option value="">Select Status</option>
                            <option value="0">Active</option>
                            <option value="1">Suspended</option>
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
                        <h6>All Customers{{ showToastNotification }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <Table v-if="tableData" :customers ="tableData" />
                            <Table v-else :customers ="customers" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { usePage } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { computed, ref } from 'vue';
    import Table from './Table.vue';
    const props = defineProps({
        'customers': Object
    })

    const page = usePage();
    const showToastNotification = computed(() =>{
        if(page.props.flash.success){
            fireSuccessNotification('success',page.props.flash.success)
        }
        if(page.props.flash.error){
            fireSuccessNotification('error',page.props.flash.error)
        }
    })

    const fireSuccessNotification = (type,message) =>{
         const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

            Toast.fire({
                icon: type,
                title: message
            })
    }

    const user = ref('');
    const status = ref('');
    const tableData = computed(()=> {
        const name_sort = props.customers.filter( (customer) => customer.name.toLowerCase().includes(user.value.toLowerCase()));
        if(!status.value){
            return name_sort;
        }
        return name_sort.filter((stat) => stat.status == status.value);
    })
</script>

<style>

</style>
