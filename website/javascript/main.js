
function getRandomIntInclusive(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 *
 * Main menu graph top anime graph.
 *
 */
var ctx = document.getElementById("topAnimeGraph").getContext('2d');


mainMenuTopAnimeChart();

function mainMenuTopAnimeChart(dataTagsArray) {
    var mainMenuTopAnimeNames = [];
    var mainMenuTopAnimeViews = [];
    var mainMenuTopAnimeIds = [];
    var mainMenuTopAnimeRatings = [];

    var promise = Promise.resolve();
    $.each(dataTagsArray, function (k, i) {
        promise = promise.then(function () {
            myChart.update();
            mainMenuTopAnimeNames[k] = i.name;
            mainMenuTopAnimeViews[k] = i.views;
            mainMenuTopAnimeIds[k] = i.animeId;
            mainMenuTopAnimeRatings[k] = i.rating;
            return new Promise(function (resolve) {
                setTimeout(resolve, 150);
            });
        });
    });


    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: mainMenuTopAnimeNames,
            datasets: [
                {
                    label: 'Rating',
                    type: "line",
                    data: mainMenuTopAnimeRatings,

                    borderWidth: 2,
                    // maxBarThickness: 200,
                    // xAxisID: 'views-x-axis',
                    yAxisID: 'right-y-axis',
                    fill: false,
                    pointHoverRadius: 8,
                    pointRadius: 5,
                    backgroundColor: 'rgb(201, 22, 60)',
                    borderColor: 'rgb(255, 99, 132)',


                },
                {
                    label: 'Views',
                    data: mainMenuTopAnimeViews,
                    backgroundColor: 'rgba(50, 180, 227)',
                    borderColor: 'rgba(0, 138, 230, 1)',
                },
                {
                    label: 'animeId',
                    data: mainMenuTopAnimeIds,
                    hidden: true,

                }
            ]
        },
        options: {
            hover: {
                onHover: function (e) {
                    var point = this.getElementAtEvent(e);
                    if (point.length) e.target.style.cursor = 'pointer';
                    else e.target.style.cursor = 'default';
                }
            },
            legend: {
                labels: {
                    filter: function (item, chart) {
                        // Remove legend item.
                        return !item.text.includes('animeId');
                    },
                    fontSize: 15,
                }
            },

            scales: {
                xAxes: [{
                    stacked: true,
                    id: 'views-x-axis',
                    ticks: {
                        fontSize: 14,
                    }
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
                        stepSize: 100
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Views',
                        fontSize: 30,
                    },
                }, {
                    type: 'linear',
                    id: 'right-y-axis',
                    display: true,
                    position: 'right',
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Rating',
                        fontSize: 30,
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
            }
        },
    })
}

/**
 *
 * Anime users ratings graph.
 *
 */
var animeUsersRatingStatsChart = document.getElementById("animeUsersRatingStatsChart").getContext('2d');
var animeUsersAgeStatsChart = document.getElementById("animeUsersAgeStatsChart").getContext('2d');
var animeUserRatingsStatsGraph = 0;
var animeUserStatsAgeChart = 0;
function animeUsersRatingsStatsGraph(dataTagsArray) {
    if (!animeUserRatingsStatsGraph == 0) {
        animeUserRatingsStatsGraph.destroy();
        // animeUsersRatingStatsChart = document.getElementById("animeUsersRatingStatsChart").getContext('2d');
    }
    if (!animeUserStatsAgeChart == 0) {
        animeUserStatsAgeChart.destroy();
        // animeUsersRatingStatsChart = document.getElementById("animeUsersRatingStatsChart").getContext('2d');
    }
    var animeUsersRatingsStatsGraphMaleRatings = [];
    var animeUsersRatingsStatsGraphFemaleRatings = [];
    var animeUsersRatinsStatsGraphAverageRatings = [];
    var animeRatingsAboveZero = 0;
    var animeRatingsAboveZeroSum = 0;
    $.each(dataTagsArray, function (k, i) {

        if (i.rating > 0) {
            animeRatingsAboveZero++;
            animeRatingsAboveZeroSum += i.rating;
            if (i.gender == "Male") {
                animeUsersRatingsStatsGraphMaleRatings.push(i.rating);
            }
            else if (i.gender == "Female") {
                animeUsersRatingsStatsGraphFemaleRatings.push(i.rating);
            }

        }
    });

    //Sets the average rating type element with the average calculated rating.
    var averageRating = Math.round(((animeRatingsAboveZeroSum / animeRatingsAboveZero) + Number.EPSILON) * 100) / 100;
    document.getElementById('averageRatingType').innerHTML = averageRating;

    //Initialized the male ratings array.
    animeMaleRatingsCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    //Initialized the female ratings array.
    var animeFemaleRatingsCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    //Initialized the female ratings array.
    var animeAverageRatingsCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    //Filtring data for the rating anime users graph.
    $.each(animeUsersRatingsStatsGraphMaleRatings, function (k, i) {
        if (i > 0 && i <= 1.4) {
            animeMaleRatingsCounts[0]++;
        }
        else if (i >= 1.5 && i <= 2.4) {
            animeMaleRatingsCounts[1]++;
        }
        else if (i >= 2.5 && i <= 3.4) {
            animeMaleRatingsCounts[2]++;
        }
        else if (i >= 3.5 && i <= 4.4) {
            animeMaleRatingsCounts[3]++;
        }
        else if (i >= 4.5 && i <= 5.4) {
            animeMaleRatingsCounts[4]++;
        }
        else if (i >= 5.5 && i <= 6.4) {
            animeMaleRatingsCounts[5]++;
        }
        else if (i >= 6.5 && i <= 7.4) {
            animeMaleRatingsCounts[6]++;
        }
        else if (i >= 7.5 && i <= 8.4) {
            animeMaleRatingsCounts[7]++;
        }
        else if (i >= 8.5 && i <= 9.4) {
            animeMaleRatingsCounts[8]++;
        }
        else if (i >= 9.5 && i <= 10.4) {
            animeMaleRatingsCounts[9]++;
        }
    });
    $.each(animeUsersRatingsStatsGraphFemaleRatings, function (k, i) {
        if (i > 0 && i <= 1.4) {
            animeFemaleRatingsCounts[0]++;
        }
        else if (i >= 1.5 && i <= 2.4) {
            animeFemaleRatingsCounts[1]++;
        }
        else if (i >= 2.5 && i <= 3.4) {
            animeFemaleRatingsCounts[2]++;
        }
        else if (i >= 3.5 && i <= 4.4) {
            animeFemaleRatingsCounts[3]++;
        }
        else if (i >= 4.5 && i <= 5.4) {
            animeFemaleRatingsCounts[4]++;
        }
        else if (i >= 5.5 && i <= 6.4) {
            animeFemaleRatingsCounts[5]++;
        }
        else if (i >= 6.5 && i <= 7.4) {
            animeFemaleRatingsCounts[6]++;
        }
        else if (i >= 7.5 && i <= 8.4) {
            animeFemaleRatingsCounts[7]++;
        }
        else if (i >= 8.5 && i <= 9.4) {
            animeFemaleRatingsCounts[8]++;
        }
        else if (i >= 9.5 && i <= 10.4) {
            animeFemaleRatingsCounts[9]++;
        }
    });
    for (let arrayIndex = 0; arrayIndex < animeMaleRatingsCounts.length; arrayIndex++) {
        var maleCount = animeMaleRatingsCounts[arrayIndex];
        var femaleCount = animeFemaleRatingsCounts[arrayIndex];
        var totalCount = maleCount + femaleCount;
        if (maleCount > 0 || femaleCount > 0) {
            animeAverageRatingsCounts[arrayIndex] = (totalCount / 2);

        }
    }





    animeUserRatingsStatsGraph = new Chart(animeUsersRatingStatsChart, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            datasets: [{
                data: animeMaleRatingsCounts,
                label: "Male",
                borderColor: 'rgba(6, 155, 209)',
                borderWidth: 5,
                fill: false
            }, {
                data: animeFemaleRatingsCounts,
                label: "Female",
                borderColor: 'rgba(245, 144, 165)',
                borderWidth: 5,
                fill: false
            }, {
                data: animeAverageRatingsCounts,
                label: "Average",
                borderWidth: 5,
                borderColor: 'rgba(121, 121, 121)',
                borderDash: [10, 5],
                fill: false
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                legend: {
                    display: true,
                    labels: {
                        fontSize: 15,
                    }
                },
                yAxes: [{
                    ticks: {
                        // padding: 100,
                        stepSize: 0.1,
                        maxTicksLimit: 10,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Times Rated',
                        fontSize: 20,
                    }
                }],
                xAxes: [{
                    position: 'bottom',
                    ticks: {
                        // maxTicksLimit: ,
                        stepSize: 0.1,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Scores',
                        fontSize: 20,
                    }
                }]
            },
            title: {
                display: true,
                text: 'Score distribution by gender.',
                fontSize: 20,
            },
            animation: {
                duration: 2000,
            },
            hover: {
                onHover: function (e) {
                    var point = this.getElementAtEvent(e);
                    if (point.length) e.target.style.cursor = 'pointer';
                    else e.target.style.cursor = 'default';
                }
            },
        }
    });


    var animeUsersAgesStatsGraphMaleRatings = [];
    var animeUsersAgesStatsGraphFemaleRatings = [];
    var animeUsersAgesStatsGraphAverageRatings = [];
    var viewerAgesSum = 0;
    var viewersAges = 0;
    $.each(dataTagsArray, function (k, i) {
        viewersAges++;
        viewerAgesSum += i.age;
        if (i.gender == "Male") {
            animeUsersAgesStatsGraphMaleRatings.push(i.age);
        }
        else if (i.gender == "Female") {
            animeUsersAgesStatsGraphFemaleRatings.push(i.age);
        }
    });

    //Sets the average viewers age type element with the average calculated age.
    var averageViewersAge = Math.round(((viewerAgesSum / viewersAges) + Number.EPSILON) * 100) / 100;
    document.getElementById('averageViewerAgeType').innerHTML = averageViewersAge;

    // document.getElementById('episodesCountType').innerHTML = retrievedData[0].episodes;
    //Initialized the male ratings array.
    var animeMaleAgesCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    //Initialized the female ratings array.
    var animeFemaleAgesCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    //Initialized the female ratings array.
    var animeAverageAgesCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    //Filtring data for the rating anime users graph.
    $.each(animeUsersAgesStatsGraphMaleRatings, function (k, i) {
        if (i <= 4) {
            animeMaleAgesCounts[0]++;
        }
        else if (i >= 5 && i <= 9) {
            animeMaleAgesCounts[1]++;
        }
        else if (i >= 10 && i <= 14) {
            animeMaleAgesCounts[2]++;
        }
        else if (i >= 15 && i <= 19) {
            animeMaleAgesCounts[3]++;
        }
        else if (i >= 20 && i <= 24) {
            animeMaleAgesCounts[4]++;
        }
        else if (i >= 25 && i <= 29) {
            animeMaleAgesCounts[5]++;
        }
        else if (i >= 30 && i <= 34) {
            animeMaleAgesCounts[6]++;
        }
        else if (i >= 35 && i <= 39) {
            animeMaleAgesCounts[7]++;
        }
        else if (i >= 40 && i <= 44) {
            animeMaleAgesCounts[8]++;
        }
        else if (i >= 45 && i <= 49) {
            animeMaleAgesCounts[9]++;
        }
        else if (i >= 50 && i <= 54) {
            animeMaleAgesCounts[10]++;
        }
        else if (i >= 55 && i <= 59) {
            animeMaleAgesCounts[11]++;
        }
        else if (i >= 60 && i <= 64) {
            animeMaleAgesCounts[12]++;
        }
        else if (i >= 65 && i <= 69) {
            animeMaleAgesCounts[13]++;
        }
        else if (i >= 70) {
            animeMaleAgesCounts[14]++;
        }
    });
    $.each(animeUsersAgesStatsGraphFemaleRatings, function (k, i) {
        if (i <= 4) {
            animeFemaleAgesCounts[0]++;
        }
        else if (i >= 5 && i <= 9) {
            animeFemaleAgesCounts[1]++;
        }
        else if (i >= 10 && i <= 14) {
            animeFemaleAgesCounts[2]++;
        }
        else if (i >= 15 && i <= 19) {
            animeFemaleAgesCounts[3]++;
        }
        else if (i >= 20 && i <= 24) {
            animeFemaleAgesCounts[4]++;
        }
        else if (i >= 25 && i <= 29) {
            animeFemaleAgesCounts[5]++;
        }
        else if (i >= 30 && i <= 34) {
            animeFemaleAgesCounts[6]++;
        }
        else if (i >= 35 && i <= 39) {
            animeFemaleAgesCounts[7]++;
        }
        else if (i >= 40 && i <= 44) {
            animeFemaleAgesCounts[8]++;
        }
        else if (i >= 45 && i <= 49) {
            animeFemaleAgesCounts[9]++;
        }
        else if (i >= 50 && i <= 54) {
            animeFemaleAgesCounts[10]++;
        }
        else if (i >= 55 && i <= 59) {
            animeFemaleAgesCounts[11]++;
        }
        else if (i >= 60 && i <= 64) {
            animeFemaleAgesCounts[12]++;
        }
        else if (i >= 65 && i <= 69) {
            animeFemaleAgesCounts[13]++;
        }
        else if (i >= 70) {
            animeFemaleAgesCounts[14]++;
        }
    });
    for (let arrayIndex = 0; arrayIndex < animeMaleAgesCounts.length; arrayIndex++) {
        var maleCount = animeMaleAgesCounts[arrayIndex];
        var femaleCount = animeFemaleAgesCounts[arrayIndex];
        var totalCount = maleCount + femaleCount;
        if (maleCount > 0 || femaleCount > 0) {
            animeAverageAgesCounts[arrayIndex] = (totalCount / 2);

        }
    }
    animeUserStatsAgeChart = new Chart(animeUsersAgeStatsChart, {
        type: 'line',
        data: {
            labels: ["0-4", "5-9", "10-14", "15-19", "20-24", "25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "65-69", ">70"],
            datasets: [{
                data: animeMaleAgesCounts,
                label: "Male",
                borderColor: 'rgba(6, 155, 209)',
                borderWidth: 5,
                fill: false
            }, {
                data: animeFemaleAgesCounts,
                label: "Female",
                borderColor: 'rgba(245, 144, 165)',
                borderWidth: 5,
                fill: false
            }, {
                data: animeAverageAgesCounts,
                label: "Average",
                borderWidth: 5,
                borderColor: 'rgba(121, 121, 121)',
                borderDash: [10, 5],
                fill: false
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                labels: {
                    fontSize: 15,
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        // padding: 100,
                        stepSize: 10,
                        maxTicksLimit: 10,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount',
                        fontSize: 20,
                    }
                }],
                xAxes: [{
                    position: 'bottom',
                    ticks: {
                        // maxTicksLimit: ,
                        stepSize: 0.1,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Age categories',
                        fontSize: 20,
                    }
                }]
            },
            title: {
                display: true,
                text: 'Age distribution by gender.',
                fontSize: 20,
            },
            animation: {
                duration: 2000,
            },
            hover: {
                onHover: function (e) {
                    var point = this.getElementAtEvent(e);
                    if (point.length) e.target.style.cursor = 'pointer';
                    else e.target.style.cursor = 'default';
                }
            },
        }
    })
}


var ctxDoughnut = document.getElementById("genderComparisonChart").getContext('2d');

// genderAnimeChart();
var genderComparisonChart = 0;
function genderAnimeChart(dataTagsArray) {
    var genderAnimeChartMales = 0;
    var genderAnimeChartFemales = 0;
    if (!genderComparisonChart == 0) {
        genderComparisonChart.destroy();
    }

    genderAnimeChartMales = dataTagsArray[0].male;
    genderAnimeChartFemales = dataTagsArray[0].female;

    genderComparisonChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: '',
                data: [genderAnimeChartMales, genderAnimeChartFemales],
                backgroundColor: [
                    'rgba(6, 155, 209)',
                    'rgba(249, 191, 203)',
                ],
                borderColor: [
                    'rgba(6, 121, 209)',
                    'rgba(245, 144, 165)',
                ],
                borderWidth: 3
            }]
        },
        options: {
            legend: {
                display: true,
                labels: {
                    fontSize: 15,
                }
            },
            //cutoutPercentage: 40,
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
            },
            title: {
                display: true,
                text: 'Viewers distribution by gender.',
                fontSize: 20,
            },
            hover: {
                onHover: function (e) {
                    var point = this.getElementAtEvent(e);
                    if (point.length) e.target.style.cursor = 'pointer';
                    else e.target.style.cursor = 'default';
                }
            },
        }
    });
}

/**
 * 
 * Click event handler main top anime chart.
 * 
 */
document.getElementById("topAnimeGraph").onclick = function (evt) {
    var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
    var firstPoint = activePoints[0];
    //Check of click wel op een bar was.
    if (firstPoint == undefined) { return; }

    var label = myChart.data.labels[firstPoint._index];
    var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
    triggerSlideStats();
    var selectedAnimeId = myChart.data.datasets[2].data[activePoints[0]._index];
    getGenderComparisonData(selectedAnimeId);
    getAnimeUsersStats(selectedAnimeId);
    getAnimeData(selectedAnimeId);
    console.log("Clicked Anime ID: ", myChart.data.datasets[2].data[activePoints[0]._index]);
};

$("#arrowDownButton").click(function () {
    triggerSlideStats();
})
function triggerSlideStats() {
    if ($("#animeStatistics").first().is(":hidden")) {

        $("#animeStatistics").slideDown("slow");
        $("#topAnimeChart").slideUp(800);
        $(".topStatsValue").fadeIn(3000);
        $("#animeTitle").fadeIn(2000);
    } else {
        $("#topAnimeChart").slideDown(600);
        setTimeout(() => {
            $("#animeStatistics").hide();
            $(".topStatsValue").hide();
            $("#animeTitle").hide();
        }, 610);

    }
}

var contentType = "json";
var ajv = new Ajv({ coerceTypes: 'array' });

/**
 * 
 * This section retrieves all json data from the API.
 *  
*/
//Retrieve Top anime data
getTopAnimeData();
function getTopAnimeData() {
    $.ajax({
        url: "http://localhost/dataprocessing/api/v1/topanimes/10",
        type: 'GET',
        contentType: `application/${contentType}`,
        success: function (data, status, xhr) {
            var schemaLocation = null;
            var retrievedDataValidatable = data;
            var retrievedData = data;
            if (contentType === 'xml') {
                retrievedDataValidatable = (new XMLSerializer()).serializeToString(retrievedData);
                var parsedRetrievedData = xmlToJson.parse(data);
                retrievedData = Object.entries(Object.entries(parsedRetrievedData)[0][1])[2][1];
                schemaLocation = Object.entries(Object.entries(parsedRetrievedData)[0][1])[1][1];

            }
            else if (contentType === 'json') {
                schemaLocation = xhr.getResponseHeader('Link');
            }
            //The tags that need to be retrieved.
            var keyNameArray = ['name', 'views', 'animeId', 'rating', 'episodes'];

            //Main logic of calling the functions.
            executeGenderChartFunctions();
            async function executeGenderChartFunctions() {
                await validation(retrievedDataValidatable, await getSchema(schemaLocation));
                await mainMenuTopAnimeChart(await convertJSONtoGraphData(retrievedData, keyNameArray));
            }
        },
    })
}

function getAnimeData(animeId) {
    $.ajax({
        url: `http://localhost/dataprocessing/api/v1/animes/${animeId}`,
        type: 'GET',
        contentType: `application/${contentType}`,
        success: function (data, status, xhr) {
            var schemaLocation = null;
            var retrievedDataValidatable = data;
            var retrievedData = data;
            if (contentType === 'xml') {
                retrievedAnimeData2 = data;

                newNode = retrievedAnimeData2.createElement("anime");

                retrievedDataValidatable = (new XMLSerializer()).serializeToString(retrievedData);
                retrievedAnimeData2.getElementsByTagName("root")[0].appendChild(newNode);

                var parsedRetrievedData = xmlToJson.parse(retrievedAnimeData2);
                parsedRetrievedData.root.anime.pop();

                retrievedData = Object.entries(Object.entries(parsedRetrievedData)[0][1])[2][1];
                schemaLocation = Object.entries(Object.entries(parsedRetrievedData)[0][1])[1][1];

            }
            else if (contentType === 'json') {
                schemaLocation = xhr.getResponseHeader('Link');
            }
            //The tags that need to be retrieved.
            var keyNameArray = ['name', 'views', 'animeId', 'rating', 'episodes'];



            //Main logic of calling the functions.
            executeGenderChartFunctions();
            async function executeGenderChartFunctions() {
                await validation(retrievedDataValidatable, await getSchema(schemaLocation));
                await (document.getElementById('animeTitle').innerHTML = retrievedData[0].name);
                await (document.getElementById('genreType').innerHTML = retrievedData[0].genre);
                await (document.getElementById('episodesCountType').innerHTML = retrievedData[0].episodes);
            }
        },
    })
}

function getGenderComparisonData(animeId) {
    $.ajax({
        url: `http://localhost/dataprocessing/api/v1/animes/${animeId}/gendercomparison/`,
        type: 'GET',
        contentType: `application/${contentType}`,
        success: function (data, status, xhr) {
            var schemaGenderLocation = null;
            var retrievedGenderData = data;
            var retrievedGenderDataValidatable = data;
            if (contentType === 'xml') {
                retrievedGenderData = data;
                retrievedGenderData2 = data;
                //Add temp node so parsing goes right.
                newNode = retrievedGenderData.createElement("gendersDifference");

                retrievedGenderDataValidatable = (new XMLSerializer()).serializeToString(retrievedGenderData);
                retrievedGenderData2.getElementsByTagName("root")[0].appendChild(newNode);
                var parsedRetrievedGenderData = xmlToJson.parse(retrievedGenderData2);
                parsedRetrievedGenderData.root.gendersDifference.pop();
                // retrievedGenderData = parsedRetrievedGenderData;
                retrievedGenderData = Object.entries(Object.entries(parsedRetrievedGenderData)[0][1])[2][1];
                schemaGenderLocation = Object.entries(Object.entries(parsedRetrievedGenderData)[0][1])[1][1];

            }
            else if (contentType === 'json') {
                schemaGenderLocation = xhr.getResponseHeader('Link');
            }
            //The tags that need to be retrieved.
            var keyNameArray = ['totalViewers', 'male', 'female'];
            //Main logic of calling the functions.
            executeChartFunctions();
            async function executeChartFunctions() {
                await validation(retrievedGenderDataValidatable, await getSchema(schemaGenderLocation));
                await genderAnimeChart(await convertJSONtoGraphData(retrievedGenderData, keyNameArray));

            }
        },
    })
}
function getAnimeUsersStats(animeId) {
    $.ajax({
        url: `http://localhost/dataprocessing/api/v1/animes/${animeId}/users/stats/`,
        type: 'GET',
        contentType: `application/${contentType}`,
        success: function (data, status, xhr) {
            var schemaLocation = null;
            var retrievedDataValidatable = data;
            var retrievedData = data;
            if (contentType === 'xml') {
                retrievedDataValidatable = (new XMLSerializer()).serializeToString(retrievedData);
                var parsedRetrievedData = xmlToJson.parse(data);
                retrievedData = Object.entries(Object.entries(parsedRetrievedData)[0][1])[2][1];
                schemaLocation = Object.entries(Object.entries(parsedRetrievedData)[0][1])[1][1];

            }
            else if (contentType === 'json') {
                schemaLocation = xhr.getResponseHeader('Link');
            }
            //The tags that need to be retrieved.
            var keyNameArray = ['name', 'views', 'animeId', 'rating', 'episodes'];

            //Main logic of calling the functions.
            executeAnimeUsersStatsFunctions();
            async function executeAnimeUsersStatsFunctions() {
                await validation(retrievedDataValidatable, await getSchema(schemaLocation));
                await animeUsersRatingsStatsGraph(await convertJSONtoGraphData(retrievedData, keyNameArray));
            }
        },
    })
}
//Gets the schema for the JSON or XML above.
function getSchema(schemaLocation, ) {
    return ($.ajax({
        url: schemaLocation,
        type: 'GET',
        success: function (data) {
            schema = data;
        },
    }))

}

//Validation of the retrieved data.
function validation(retrievedData, schema) {
    if (contentType === 'json') {
        console.log("JSON validation");
        console.log(ajv.validate(schema, retrievedData));
        return retrievedData;
    }
    else if (contentType === 'xml') {
        console.log("XML validation");
        console.log(xmllint.validateXML({ xml: retrievedData, schema: schema }).errors);
        if (!xmllint.validateXML({ xml: retrievedData, schema: schema }).errors) {
            return retrievedData;
        }
    }
}

//Transforms retrieved data (JSON) into a single format other graphs can work with.
function convertJSONtoGraphData(validatedDataInJSON, keyNameArray) {
    var dataTagsArray = [];
    $.each(validatedDataInJSON, function (k, i) {
        dataTagsArray[k] = i;
    });
    return dataTagsArray;
}