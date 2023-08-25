<template>
    <div class="col-lg-4 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">Savings </h6>
                <div class="d-flex flex-row">
                    <div class="row">
                        <div class="col-4">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item" :class="type == 'area' ? 'btn btn-xs btn-primary text-white' : ''">
                                        <a class="nav-link mb-0 px-0 py-1 active " @click.prevent="type = 'area'">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 512 512">
                                                <path
                                                    d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="nav-item" :class="type == 'bar' ? 'btn btn-xs btn-primary text-white' : ''">
                                        <a class="nav-link mb-0 px-0 py-1" @click.prevent="type = 'bar'">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 448 512">
                                                <path
                                                    d="M160 80c0-26.5 21.5-48 48-48h32c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V80zM0 272c0-26.5 21.5-48 48-48H80c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V272zM368 96h32c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H368c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48z" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <select v-model="status" class="form-select" aria-label="Default select example">
                                <option>Select Status</option>
                                <option value="0">Active</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <VueDatePicker class="" v-model="date" month-picker vertical></VueDatePicker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="chart" v-if="updatedOptions">
                    <apexchart v-if="type == 'bar'" width="315" type="bar" :options="updatedOptions"
                        :series="updatedSeries">
                    </apexchart>
                    <apexchart v-else width="315" type="area" :options="updatedOptions" :series="updatedSeries">
                    </apexchart>
                </div>
                <div class="chart" v-else>
                    <apexchart v-if="type == 'bar'" width="315" type="bar" :options="options"
                        :series="series">
                    </apexchart>
                    <apexchart v-else width="315" type="area" :options="options" :series="series">
                    </apexchart>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

    const props = defineProps({
        'options': Object,
        'series': Array
    })

    const type = ref('area');
    const status = ref('')
    const updatedOptions = ref('');
    const updatedSeries = ref('');
    const date = ref({
        month: new Date().getMonth(),
        year: new Date().getFullYear()
    });

    watch(date, async() => {
        if(date.value){
            const dateFormat = `${date.value.year}-${date.value.month + 1}-1`;
            let data = await fetch(`http://localhost:8000/chart/savings-chart/${dateFormat}/${status.value}`);
            const chartData = await data.json();

            updatedOptions.value = chartData.options
            updatedSeries.value = chartData.series
        }
    })

    watch(status, async() => {
        const dateFormat = `${date.value.year}-${date.value.month + 1}-1`;
        let data = await fetch(`http://localhost:8000/chart/savings-chart/${dateFormat}/${status.value}`);
        const chartData = await data.json();

        updatedOptions.value = chartData.options
        updatedSeries.value = chartData.series
    })
</script>

<style>

</style>
