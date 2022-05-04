<template>
    <div>
        <h1>Hello Laravel Vue </h1>
        <p>{{ status }}</p>
        <p>{{ currentDate }}</p>
    </div>
  
</template>

<script>
import { APIService } from "@/apiService.js";
const apiService = new APIService();

export default {
    name: 'TestingData',
    data() {
        return {
            status: '',
            currentDate: ''
        }
    },
    mounted() {
        this.getTestingData();
    },
    methods: {
        getTestingData() {
            apiService.getTestingData()
            .then(result => {
                this.status = result.status;
                this.currentDate = result.currentDate;
            })
            .catch(error => {
                console.log(error)
            });
        },
    }
}
</script>

<style>

</style>