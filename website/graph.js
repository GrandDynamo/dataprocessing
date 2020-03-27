export default class Graph {

    constructor() {
        console.log("teee");
    }
}
class Graph {
    constructor() {
        this.test();
        console.log("yeee");
    }
   test() {
        var ctx = document.getElementById("myChart").getContext('2d');


        var topAnimeNames = [];
        var topAnimeViews = [];
        var topAnimeRatings = [];
        var topAnimeTotalEpisodes = [];

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: topAnimeNames,
                datasets: [
                    // {
                    //     type: "line",
                    //     label: 'Rating',
                    //     fill: false,
                    //     backgroundColor: 'rgb(255, 99, 132)',
                    //     borderColor: 'rgb(255, 99, 132)',
                    //     data: topAnimeRatings,
                    //     yAxisID: 'right-y-axis',

                    // },
                    // {
                    //     type: "bar",
                    //     label: 'Male',
                    //     fill: false,
                    //     backgroundColor: 'rgb(255, 99, 132)',
                    //     borderColor: 'rgb(255, 99, 132)',
                    //     data: topAnimeTotalEpisodes,
                    //     xAxisID: 'views-x-axis',
                    //     yAxisID: 'views-y-axis',


                    // },
                    {
                        label: 'Views',
                        type: "line",
                        data: topAnimeViews,
                        backgroundColor: 'rgba(107, 196, 255, 1)',
                        borderColor: 'rgba(0, 138, 230, 1)',
                        borderWidth: 2,
                        // maxBarThickness: 200
                        xAxisID: 'views-x-axis',
                        yAxisID: 'views-y-axis',
                        fill: false,

                    },
                    {
                        label: 'Episodes',
                        data: topAnimeTotalEpisodes,
                        backgroundColor: 'rgba(107, 196, 255, 1)',
                        borderColor: 'rgba(0, 138, 230, 1)',
                    },
                    {
                        label: 'TotalViews',
                        data: topAnimeViews,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                    }
                ]
            },
            options: {
                scales: {
                    xAxes: [{
                        stacked: true,
                        id: 'views-x-axis'
                    }
                    ],
                    yAxes: [{
                        stacked: true,
                        id: 'views-y-axis',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            // suggestedMax: 10,
                            suggestedMin: 0,
                            // stepSize: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Views'
                        },
                    }, {
                        type: 'linear',
                        id: 'right-y-axis',
                        display: true,
                        position: 'right',
                        stacked: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Rating'
                        },
                        gridLines: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            suggestedMax: 10,
                            // suggestedMin: 9,
                            stepSize: 1
                        }
                    }]
                    // xAxes: [{ stacked: true }],
                    // yAxes: [{ stacked: true }]
                }
            },
        })

    }

}
