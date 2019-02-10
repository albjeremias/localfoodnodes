<template>
    <div class="col-12 col-lg-6 justify-content-center">
        <h3 v-show="!loading" class="text-center mb-0">{{ parseInt(total).toLocaleString('sv') }} {{ currency }}</h3>
        <div v-show="!loading" class="text-center">{{ trans.out }} {{ year }}</div>
        <i v-show="loading" class="fa fa-spinner fa-spin loader"></i>
        <div v-show="!loading" id="costs-chart" class="chart" style="height:300px; width: 100%;"></div>
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
                google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var dataTable = google.visualization.arrayToDataTable(dataArray);

                    var options = {
                        pieHole: 0.4,
                        tooltip: { trigger: 'selection' },
                        legend: {
                            textStyle: {
                                fontName: 'Raleway',
                                fontSize: '12'
                            }
                        },
                        slices: {
                            0: { color: '#d36262' },
                            1: { color: '#cd4e4e' },
                            2: { color: '#c73a3a' },
                            3: { color: '#b53333' },
                            4: { color: '#a52323' },
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('costs-chart'));
                    chart.draw(dataTable, options);
                }
            }
        }
    }
</script>
