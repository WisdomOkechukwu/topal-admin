<template>
    <div class="row mb-5">
        <div class="col-lg-12 mt-lg-0 mt-4">

            <div class="card card-body" id="profile">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-4">
                        <div class="avatar avatar-xl position-relative">
                            <img src="../../../assets/img/team-2.jpg" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                {{ admin.firstname }} {{ admin.lastname }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                Admin
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Basic Info {{ showToastNotification }}</h5>
                </div>
                <div class="card-body pt-0">
                    <form @submit.prevent="updateAdmin(admin.id)">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <div class="input-group">
                                    <input v-model="form.first" :class="errors.first ? 'border border-danger' : ''" class="form-control" type="text"
                                        placeholder="Alec" >
                                </div>
                                    <span v-if="errors.first" class="text text-sm text-danger">{{ errors.first }}</span>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Last Name</label>
                                <div class="input-group">
                                    <input v-model="form.last" :class="errors.last ? 'border border-danger' : ''" class="form-control" type="text"
                                        placeholder="Thompson" >
                                </div>
                                <span v-if="errors.last" class="text text-sm text-danger">{{ errors.last }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <input v-model="form.email" :class="errors.email ? 'border border-danger' : ''" class="form-control" type="text"
                                        placeholder="Alec" >
                                </div>
                                <span v-if="errors.email" class="text text-sm text-danger">{{ errors.email }}</span>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Pin</label>
                                <div class="input-group">
                                    <input v-model="form.pin" :class="errors.pin ? 'border border-danger' : ''" class="form-control" type="text"
                                        placeholder="pin" >
                                </div>
                                <span v-if="errors.pin" class="text text-sm text-danger">{{ errors.pin }}</span>
                            </div>
                        </div>
                        <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0">Update Profile</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4" id="password">
                <form @submit.prevent="updateAdminPassword(admin.id)">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body pt-0">
                    <label class="form-label">New password</label>
                    <div class="form-group">
                        <input v-model="password_form.password" :class="errors.password ? 'border border-danger' : ''" class="form-control" type="password" placeholder="New password">
                        <span v-if="errors.password" class="text text-sm text-danger">{{ errors.password }}</span>
                    </div>
                    <label class="form-label">Confirm new password</label>
                    <div class="form-group">
                        <input v-model="password_form.password_confirmation" :class="errors.password ? 'border border-danger' : ''" class="form-control" type="password" placeholder="Confirm password">
                        <!-- <span v-if="errors.first" class="text text-sm text-danger">{{ errors.first }}</span> -->
                    </div>
                    <h5 class="mt-5">Password requirements</h5>
                    <p class="text-muted mb-2">
                        Please follow this guide for a strong password:
                    </p>
                    <ul class="text-muted ps-4 mb-0 float-start">
                        <li>
                            <span class="text-sm">One special characters</span>
                        </li>
                        <li>
                            <span class="text-sm">Min 8 characters</span>
                        </li>
                        <li>
                            <span class="text-sm">One number (2 are recommended)</span>
                        </li>
                    </ul>
                    <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0">Update password</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script setup>
import { router, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { computed, onMounted } from 'vue';

    const props = defineProps({
        'admin':Object,
        'errors':Object,
    })

    const form = useForm({
        first : props.admin.firstname,
        last : props.admin.lastname,
        email : props.admin.email,
        pin: props.admin.pin,
    })

    const password_form = useForm({
        password : '',
        password_confirmation : ''
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

    const updateAdmin = (id) => {
        router.put(`/profile/update/${id}`,form,{ preserveScroll: true});
    }
    const updateAdminPassword = (id) => {
        router.put(`/profile/update/password/${id}`,password_form,{ preserveScroll: true });
    }
</script>

<style>

</style>
