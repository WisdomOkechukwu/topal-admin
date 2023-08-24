<template>
    <div class="container-fluid py-4">
            <div class="row">
        <div class="col-lg-12">
            <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0">Transaction Information</h5>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button @click.prevent="goBack" class="btn bg-gradient-warning">Go Back</button>
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
                                {{ transaction.name }}
                            </div>
                        </li>

                        <!-- {{-- % Intrest --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Type</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ transaction.type }}
                            </div>
                        </li>

                        <!-- {{-- Status --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Date</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ transaction.date }}
                            </div>
                        </li>

                        <!-- {{-- Duration  --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Time</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ transaction.time }}
                            </div>
                        </li>

                        <!-- {{-- Expiration Date --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">amount</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ transaction.amount }}
                            </div>
                        </li>

                        <!-- {{-- Savings Date --}} -->
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">

                                <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Description</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                <!-- {{-- </div> --}} -->
                            </div>
                            <div class="d-flex align-items-center text-sm font-weight-bold">
                                {{ transaction.description }}
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

const props = defineProps({
    'transaction': Object
})

const goBack = () => {
    window.history.back();
}
</script>

<style>

</style>
