<template>
    <table class="table align-items-center justify-content-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-xs font-weight-bolder ">
                    Name
                </th>
                <th class="text-uppercase text-xs font-weight-bolder ps-2">
                    $ Intrest</th>
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
            <tr v-for="saving in savings" :key="saving.id">
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="../../../assets/img/team-2.jpg" class="avatar avatar-sm rounded-circle me-2 ">
                        </div>
                        <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{ saving.name }}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <h6 class="mb-0 text-sm">{{ saving.interest }}%</h6>
                </td>
                <td>
                    <div v-if="saving.status == '0'">
                        <h6 class="mb-0 text-sm text-success">Active</h6>
                    </div>

                    <div v-if="saving.status == '1'">
                        <h6 class="mb-0 text-sm text-warning">Completed</h6>
                    </div>
                </td>
                <td>
                        <h6 class="mb-0 text-sm">{{ saving.duration }} Months</h6>
                </td>

                <td class="align-middle">
                    <h6 class="mb-0 text-sm">{{ saving.expiration }}</h6>

                </td>

                <td class="align-middle">
                    <!-- <h6 class="mb-0 text-sm">21 July 2023</h6> -->
                    <button @click.prevent="showSavings(saving.id)" class="btn btn-primary">
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
        'savings':Object,
        'customer': Object
    })

    const showSavings = (id) => {
            router.get(`/savings/show/${id}`)
        }

</script>

<style>

</style>
