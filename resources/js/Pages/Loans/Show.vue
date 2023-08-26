<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">{{ user . firstname }} {{ user . lastname }}</h6>
                            </div>
                            <div class="col-6 text-end">
                                <button @click.prevent="showProfile(user.id)" class="btn bg-gradient-primary">View
                                    Profile</button>
                                <!-- {{-- View User --}} -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-0">
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Email</h6>
                                    <span class="text-sm">{{ user . email }}</span>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Phone Number</h6>
                                    <span class="text-sm">{{ user . phone }}</span>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Gender</h6>
                                    <span class="text-sm">{{ user . gender }}</span>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">BVN</h6>
                                    <span class="text-sm">{{ user . bvn }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">City</h6>
                                    <span class="text-sm">{{ user . city }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Company Location</h6>
                                    <span class="text-sm">{{ user . company_location }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Company Name</h6>
                                    <span class="text-sm">{{ user . company_name }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Employee Status</h6>
                                    <span class="text-sm">{{ user . employment_status }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Marital Status</h6>
                                    <span class="text-sm">{{ user . marital_status }}</span>
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Residential Address</h6>
                                    <span class="text-sm">{{ user . residential_address }}</span>
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
                                <h6 class="mb-0">Loan Information {{ showToastNotification }}</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <button v-if="loan.status == 0" @click.prevent="showApproveDialog(loan.id)" class="btn bg-gradient-primary m-2">Approve Loan</button>
                                <button v-if="loan.status == 0" @click.prevent="showDeclineDialog(loan.id)" class="btn bg-gradient-danger m-2">Cancel Loan</button>
                                <button @click.prevent="goBack" class="btn bg-gradient-warning m-2">Back</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <!-- {{-- <h6 class="text-uppercase text-body text-sm font-weight-bolder my-3">Yesterday</h6> --}} -->
                        <ul class="list-group">
                            <!-- {{-- name --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Name</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.name }}
                                </div>
                            </li>

                            <!-- {{-- % Intrest --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Loan Type</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.loan_type }}
                                </div>
                            </li>

                            <!-- {{-- Status --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Status</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    <h6 v-if="loan.status == 0" class="mb-0 text-sm text-warning">Pending</h6>
                                    <h6 v-if="loan.status == 1" class="mb-0 text-sm text-success">Active</h6>
                                    <h6 v-if="loan.status == 2" class="mb-0 text-sm text-danger">Declined</h6>
                                    <h6 v-if="loan.status == 3" class="mb-0 text-sm text-success">Completed</h6>
                                    <h6 v-if="loan.status == 4" class="mb-0 text-sm text-danger">Expired</h6>
                                </div>
                            </li>

                            <!-- {{-- Duration  --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Duration</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.duration }}
                                </div>
                            </li>

                            <!-- {{-- Expiration Date --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Expiration Date</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.expiration_date }}
                                </div>
                            </li>

                            <!-- {{-- Savings Date --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Loan Date</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.date }}
                                </div>
                            </li>

                            <!-- {{-- Entry Amount --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Loan Amount </h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.amount }}
                                </div>
                            </li>

                            <!-- {{-- Intrest Incured --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Interest Rate Expected ({{ loan.interest }}%):</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    NGN {{ loan.monthly_amount }}
                                </div>
                            </li>

                            <!-- {{-- Saving Description --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Loan Description</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.loan_type }}
                                </div>
                            </li>

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Amount Paid Back</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}} -->
                                    <!-- {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    NGN {{ loan.paid_back }}
                                </div>
                            </li>

                            <!-- {{-- Duration Left --}} -->
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">

                                    <!-- {{-- <div class="d-flex flex-column"> --}} -->
                                    <h6 class="mb-1 text-dark text-sm">Duration Left</h6>
                                    <!-- {{-- <span class="text-sm">26 March 2020, at 13:45 PM</span> --}}
                                {{-- </div> --}} -->
                                </div>
                                <div class="d-flex align-items-center text-sm font-weight-bold">
                                    {{ loan.duration_left }}
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
    import { router, useForm, usePage } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
import { computed } from 'vue';

    const props = defineProps({
        'user':Object,
        'loan':Object
    })

    const showProfile = (id) => {
        router.get(`/customer/show/${id}`)
    }

    const goBack = () => {
        window.history.back();
    }

    const approveLoan = (id) =>{
        console.log(id)
    }

    const cancelLoan = (id) =>{
        console.log(id)
    }
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
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

    const showApproveDialog = (loan_id) => {
        swalWithBootstrapButtons.fire({
        title: 'Input your pin to approve loan',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: false,
        confirmButtonText: 'Approve',
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
            const approveForm = useForm({
                loan_id : loan_id,
                pin: login
            })
            router.post(`/loans/approve`,approveForm,{ preserveScroll: true });
        }
        })
    }

    const showDeclineDialog = (loan_id) =>{
        swalWithBootstrapButtons.fire({
        title: 'Input your pin to decline loan',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: false,
        confirmButtonText: 'Decline',
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
            const declineForm = useForm({
                loan_id : loan_id,
                pin: login
            })
            router.post(`/loans/decline`,declineForm,{ preserveScroll: true });
        }
        })
    }

    const fireSuccessNotification = (type,message) =>{
        swalWithBootstrapButtons.fire({
            icon: type,
            title: message
        })
    }


</script>

<style>

</style>
