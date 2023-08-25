<template>
    <table class="table align-items-center justify-content-center mb-0">
        <thead>

            <tr>
                <th class="text-uppercase text-xs font-weight-bolder ">
                    Name
                </th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    Loan Type</th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    Status</th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    Duration</th>
                <th class="text-uppercase text-xs font-weight-bolder  ps-2">
                    Expiration Date</th>
                <th class="text-uppercase text-xs font-weight-bolder  ps-2"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="loan in loans" :key="loan.id">
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="../../../assets/img/team-2.jpg"
                                class="avatar avatar-sm rounded-circle me-2 ">
                        </div>
                        <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{ loan.name }}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <h6 class="mb-0 text-sm">{{ loan.loan_type }}</h6>
                </td>
                <td>
                    <h6 v-if="loan.status == 0" class="mb-0 text-sm text-warning">Pending</h6>
                    <h6 v-else-if="loan.status == 1" class="mb-0 text-sm text-success">Active</h6>
                    <h6 v-else-if="loan.status == 2" class="mb-0 text-sm text-danger">Declined</h6>
                    <h6 v-else class="mb-0 text-sm text-info">Completed</h6>
                </td>
                <td>
                    <h6 class="mb-0 text-sm">{{ loan.duration }}</h6>
                </td>

                <td class="align-middle">
                    <h6 class="mb-0 text-sm">{{ loan.expiration_date }}</h6>
                </td>
                <td class="align-middle">
                    <!-- <h6 class="mb-0 text-sm">21 July 2023</h6> -->
                    <button @click.prevent="showLoans(loan.id)" class="btn btn-primary">
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
        'loans':Object,
        'customer': Object
    })

    const showLoans = (id) => {
        router.get(`/loans/show/${id}`)
    }



</script>

<style>

</style>
