<template>
    <div class="col-12 col-lg-6 justify-content-center">
        <h3 v-show="!loading" class="text-center mb-0">{{ parseInt(total).toLocaleString('sv') }} {{ currency }}</h3>
        <div v-show="!loading" class="text-center">{{ trans.in }} {{ year }}</div>
        <i v-show="loading" class="fa fa-spinner fa-spin loader"></i>
        <div v-show="!loading" id="income-chart" class="chart" style="height: 300px; width: 100%;"></div>
    </div>
</template>

<script>
    export default {
        props: ['trans', 'data', 'total', 'currency', 'year'],
        data: function() {
            return {
                loading: true,
            }
        },
        watch: {
            data: {
                immediate: true,
                handler(data) {
                    if (data) {
                        this.draw(data);
                        this.loading = false;
                    }
                }
            }
        },
        methods: {
            draw(dataArray) {
                google.charts.load('current', {packages:['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var dataTable = google.visualization.arrayToDataTable(dataArray);

                    var options = {
                        tooltip: { trigger: 'selection' },
                        pieHole: 0.4,
                        legend: {
                            textStyle: {
                                fontName: 'Raleway',
                                fontSize: '12'
                            }
                        },
                        slices: {
                            0: { color: '#8ac594' },
                            1: { color: '#79bc84' },
                            2: { color: '#68b475' },
                            3: { color: '#57ab65' },
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('income-chart'));
                    chart.draw(dataTable, options);
                }
            }
        }
    }
</script>
