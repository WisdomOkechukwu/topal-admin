<template>
    <div class="container-fluid py-4">
            <div class="row">
        <div class="col-lg-3">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">{{ user.firstname }} {{ user.lastname }}</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button @click.prevent="showProfile(user.id)" class="btn bg-gradient-primary">View Profile</button>
                            <!-- {{-- View User --}} -->
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pb-0">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Email</h6>
                                <span class="text-sm">{{ user.email }}</span>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Phone Number</h6>
                                <span class="text-sm">{{user.phone}}</span>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Gender</h6>
                                <span class="text-sm">{{ user.gender }}</span>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">BVN</h6>
                                <span class="text-sm">{{ user.bvn }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">City</h6>
                                <span class="text-sm">{{ user.city }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Company Location</h6>
                                <span class="text-sm">{{ user.company_location }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Company Name</h6>
                                <span class="text-sm">{{ user.company_name }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Employee Status</h6>
                                <span class="text-sm">{{ user.employment_status }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Marital Status</h6>
                                <span class="text-sm">{{ user.marital_status }}</span>
                            </div>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Residential Address</h6>
                                <span class="text-sm">{{ user.residential_address }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Saving Information</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button @click.prevent="goBack" class="btn bg-gradient-warning m-2">Back</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <!-- {{-- <h6 class="text-uppercase text-body text-sm font-weight-bolder my-3">Yesterday</h6> --}} -->
                    <ul class="list-group">
                        <!-- {{-- name --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Name</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ user.firstname }} {{ user.lastname }}
                            </div>
                        </li>

                        <!-- {{-- % Intrest --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">% Intrest</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.interest }} %
                            </div>
                        </li>

                        <!-- {{-- Status --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Status</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.status }}
                            </div>
                        </li>

                        <!-- {{-- Duration  --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Duration</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.duration }} months
                            </div>
                        </li>

                        <!-- {{-- Expiration Date --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Expiration Date</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.expiration }}
                            </div>
                        </li>

                        <!-- {{-- saving Date --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Saving Date</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.date }}
                            </div>
                        </li>

                        <!-- {{-- saving Time --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Saving Time</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.time }}
                            </div>
                        </li>

                        <!-- {{-- Entry Amount --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Entry Amount </h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.entry }}
                            </div>
                        </li>

                        <!-- {{-- Intrest Incured --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Interest Accrued</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                               {{ saving.accrued }}
                            </div>
                        </li>

                        <!-- {{-- Saving Description --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Saving Description</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.description }}
                            </div>
                        </li>

                        <!-- {{-- Duration Left --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Duration Left</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}}
                                {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ saving.duration_left }}
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>
    </div>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        'user':Object,
        'saving':Object
    })

    const showProfile = (id) => {
        router.get(`/customer/show/${id}`)
    }

    const goBack = () => {
        window.history.back();
    }


</script>

<style>

</style>
