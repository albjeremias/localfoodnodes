<template>
    <div class="container my-5">

        <div class="form-group">
            <label>Interval</label>
            <select v-model="interval" class="form-control">
                <option value="once">Once</option>
                <option value="week">Weekly</option>
                <option value="2-week">Every other week</option>
                <option value="4-week">Every forth week</option>
                <option value="custom">Custom</option>
            </select>
        </div>


        <div v-if="!hideWeekdayInput.includes(interval)" class="form-group">
            <input v-model="weekday" type="radio" name="weekday" value="1"><span class="mx-2">Mon</span>
            <input v-model="weekday" type="radio" name="weekday" value="2"><span class="mx-2">Tue</span>
            <input v-model="weekday" type="radio" name="weekday" value="3"><span class="mx-2">Wed</span>
            <input v-model="weekday" type="radio" name="weekday" value="4"><span class="mx-2">Thur</span>
            <input v-model="weekday" type="radio" name="weekday" value="5"><span class="mx-2">Fri</span>
            <input v-model="weekday" type="radio" name="weekday" value="6"><span class="mx-2">Sat</span>
            <input v-model="weekday" type="radio" name="weekday" value="7"><span class="mx-2">Sun</span>
        </div>

        <div>
            <div class="form-group">
                <label>Start date</label>
                <input v-model="startDate" class="form-control" type="date">
            </div>

            <div class="form-group">
                <label>Start time</label>
                <input v-model="startTime" class="form-control" type="time">
            </div>

            <div class="form-group">
                <label>End time</label>
                <input v-model="endTime" class="form-control" type="time">
            </div>
        </div>

        <calendar></calendar>

    </div>
</template>
<style>
</style>
<script>


    import Calendar from '../../../../../modules/Calendar'

    export default {
        props: [],
        components: { Calendar },
        data: function() {
            return {
                interval: 'once',
                weekday: 1,
                startDate: '1992-05-29',
                startTime: '01:00',
                endTime: '02:00',
                hideWeekdayInput: ['once', 'custom']
            }
        },
        computed: {
        },
        beforeMount () {
        },
        mounted() {
        },
        watch: {
        },
        methods: {
        },
    }
</script>
