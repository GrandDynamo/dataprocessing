export{graph};
class graph {
    constructor() {
        this.test();
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
        function getRandomIntInclusive(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        retrieveData();
        function retrieveData() {
            $.ajax(
                {
                    url: "http://localhost/dataprocessing/api/v1/topAnime/12",
                    success: function (data) {
                        var array = data['name'];
                        var interval = 100; // how much time should the delay between two iterations be (in milliseconds)?
                        //Slows down graph buildup for nice looking effect.
                        var promise = Promise.resolve();
                        $.each(data, function (k, i, o) {
                            promise = promise.then(function () {
                                console.log(i['name']);
                                console.log(i['views']);
                                console.log(i['rating']);
                                console.log(i['episodes']);
                                topAnimeNames.push(i['name']);
                                topAnimeViews.push(i['views']);
                                topAnimeRatings.push(i['rating']);
                                topAnimeTotalEpisodes.push(i['episodes']);
                                myChart.update();
                                return new Promise(function (resolve) {
                                    setTimeout(resolve, interval);
                                });
                            });
                            // });
                        });
                        promise.then(function () {
                            console.log('Loop finished.');
                        });
                    }
                }
            );

        }
        /**
         * Retrieves label and data info when clicked on bar.
         */
        document.getElementById("myChart").onclick = function (evt) {
            var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
            var firstPoint = activePoints[0];
            var label = myChart.data.labels[firstPoint._index];
            var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
            console.log(label + ": " + value);
        };
    }


}