<template>
    <div class="calendar">
        <div class="calendar-header">
            <i class="fa fa-fw fa-chevron-left" @click="subtractMonth"></i>
            <h4 class="text-center">{{month + ' - ' + year}}</h4>
            <i class="fa fa-fw fa-chevron-right" @click="addMonth"></i>
        </div>
        <div class="weekdays">
            <div class="d-inline-block weekday" v-for="day in days">{{ day }}</div>
        </div>
        <div class="dates">
            <div class="p-2 day d-inline-block bg-black-54" v-for="blank in firstDayOfMonth"><span>{{ blank }}</span></div>
            <div class="p-2 day d-inline-block bg-black-38" v-for="date in daysInMonth"
                :class="{'current-day': date == initialDate && month == initialMonth && year == initialYear}">
                <span>{{ date }}</span>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [],
        components: { },
        data: function() {
            return {
                today: moment(),
                dateContext: moment(),
                days: ['S', 'M', 'T', 'W', 'T', 'F', 'S']
            }
        },
        computed: {
            year: function () {
                var t = this;
                return t.dateContext.format('Y');
            },
            month: function () {
                var t = this;
                return t.dateContext.format('MMMM');
            },
            daysInMonth: function () {
                var t = this;
                return t.dateContext.daysInMonth();
            },
            currentDate: function () {
                var t = this;
                return t.dateContext.get('date');
            },
            firstDayOfMonth: function () {
                var t = this;
                var firstDay = moment(t.dateContext).subtract((t.currentDate - 1), 'days');
                return firstDay.weekday();
            },
            initialDate: function () {
                var t = this;
                return t.today.get('date');
            },
            initialMonth: function () {
                var t = this;
                return t.today.format('MMMM');
            },
            initialYear: function () {
                var t = this;
                return t.today.format('Y');
            }
        },
        beforeMount () {
        },
        mounted() {
        },
        watch: {
        },
        methods: {
            addMonth: function () {
                var t = this;
                t.dateContext = moment(t.dateContext).add(1, 'month');
            },
            subtractMonth: function () {
                var t = this;
                t.dateContext = moment(t.dateContext).subtract(1, 'month');
            }
        },
    }
</script>


<style>
    .day {
        width: 50px;
        height: 50px;
    }

    .calendar {
        width: 350px;
    }

    .weekdays {
        width: 350px;
    }

    .weekday {
        width: 50px;
        text-align: center;
    }
</style>
