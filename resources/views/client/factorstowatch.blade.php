@extends('layouts.client.index')

@section('page-css')
    <style>
        td:nth-child(1) {
            width: 10%;
        }

        td:nth-child(2) {
            width: 30%;
        }

        td:nth-child(3) {
            width: 10%;
            text-align: center !important;
        }

        td:nth-child(4) {
            width: 10%;
            text-align: center !important;
        }

        td:nth-child(5) {
            width: 10%;
            text-align: center !important;
        }

        td:nth-child(6) {
            width: 10%;
            text-align: center !important;
        }

        td:nth-child(7) {
            width: 10%;
            text-align: center !important;
        }

        td:nth-child(8) {
            width: 10%;
            text-align: center !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12 shadow px-5 py-4 my-5">

            <form action="#" class="row" onsubmit="getFileContent(event)">
                <div class="col-md-3 my-1">
                    <label for="">Location</label>
                    <select name="" id="location" class="form-control js-example-basic-single w-100">
                        <option value="us">USA</option>
                        <option value="ex_us">EX-USA</option>
                    </select>
                </div>
                <div class="col-md-3 my-1">
                    <label for="">Frequency</label>
                    <select name="" id="frequency" class="form-control js-example-basic-single w-100">
                        <option value="monthly" selected>Monthly</option>
                        <option value="daily">Daily</option>
                    </select>
                </div>
                <div class="col-md-3 my-1">
                    <label for="">Weighting</label>
                    <select name="" id="weight" class="form-control js-example-basic-single w-100">
                        <option value="vw_cap">Value Weighted-Cap</option>
                        <option value="vw">Value Weighted</option>
                        <option value="ew">Equal Weighted</option>
                    </select>
                </div>
                <div class="col-md-3 my-1">
                    <label for="">Time Period</label>
                    <select name="period" id="period" class="form-control js-example-basic-single w-100">
                        <option value="Last_Year">Last Year</option>
                        <option value="Last_5_Years">Last 5 Years</option>
                        <option value="Last_10_Years">Last 10 Years</option>
                        <option value="Full_Sample">Full Sample</option>
                    </select>
                </div>
                <div class="col-12 justify-content-center my-4">
                    <button type="submit" class="btn btn-primary rounded rounded-pill p-2 d-block mx-auto px-4"
                        style="font-weight: 200;border: 1px solid black; color: black; background: transparent;"
                        id="analyze">Analyze
                    </button>
                    <div class="d-none" id="loader">
                        <div class="spinner-border text-primary mx-auto d-block" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <p>
                    All the statistics on this page are annualized and the ranking of factors is based on Sharpe ratio.
                </p>
            </form>
        </div>
        <div class="col-md-12 shadow px-5 py-4 my-5">
            <table class="w-100">
                <tbody id="my-table">
                    <tr>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Ranking</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Factor</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Mean Return</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Volatility</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Sharpe Ratio</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Information Ratio</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Beta</td>
                        <td class="border ps-2 bg-purple text-light fw-bolder">Alpha</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">1</td>
                        <td class="border ps-2 ">Assets turnover</td>
                        <td class="border ps-2 ">0.1226</td>
                        <td class="border ps-2 ">0.0456</td>
                        <td class="border ps-2 ">2.6886</td>
                        <td class="border ps-2 ">2.9173</td>
                        <td class="border ps-2 ">-0.0453</td>
                        <td class="border ps-2 ">0.011</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">2</td>
                        <td class="border ps-2 ">Operating leverage</td>
                        <td class="border ps-2 ">0.112</td>
                        <td class="border ps-2 ">0.0545</td>
                        <td class="border ps-2 ">2.055</td>
                        <td class="border ps-2 ">1.7536</td>
                        <td class="border ps-2 ">0.1103</td>
                        <td class="border ps-2 ">0.0075</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">3</td>
                        <td class="border ps-2 ">Abnormal corporate investment</td>
                        <td class="border ps-2 ">0.0569</td>
                        <td class="border ps-2 ">0.0286</td>
                        <td class="border ps-2 ">1.9895</td>
                        <td class="border ps-2 ">2.5271</td>
                        <td class="border ps-2 ">-0.059</td>
                        <td class="border ps-2 ">0.0057</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">4</td>
                        <td class="border ps-2 ">Change sales minus change SG&amp;A</td>
                        <td class="border ps-2 ">0.0718</td>
                        <td class="border ps-2 ">0.0361</td>
                        <td class="border ps-2 ">1.9889</td>
                        <td class="border ps-2 ">2.0012</td>
                        <td class="border ps-2 ">-0.002</td>
                        <td class="border ps-2 ">0.006</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">5</td>
                        <td class="border ps-2 ">Tax expense surprise</td>
                        <td class="border ps-2 ">0.0557</td>
                        <td class="border ps-2 ">0.0307</td>
                        <td class="border ps-2 ">1.8143</td>
                        <td class="border ps-2 ">1.7654</td>
                        <td class="border ps-2 ">0.0081</td>
                        <td class="border ps-2 ">0.0045</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">6</td>
                        <td class="border ps-2 ">Altman Z-score</td>
                        <td class="border ps-2 ">0.0827</td>
                        <td class="border ps-2 ">0.0622</td>
                        <td class="border ps-2 ">1.3296</td>
                        <td class="border ps-2 ">1.6207</td>
                        <td class="border ps-2 ">-0.0813</td>
                        <td class="border ps-2 ">0.0082</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">7</td>
                        <td class="border ps-2 ">Years 16-20 lagged returns- annual</td>
                        <td class="border ps-2 ">0.0784</td>
                        <td class="border ps-2 ">0.0594</td>
                        <td class="border ps-2 ">1.3199</td>
                        <td class="border ps-2 ">1.5594</td>
                        <td class="border ps-2 ">-0.0656</td>
                        <td class="border ps-2 ">0.0076</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">8</td>
                        <td class="border ps-2 ">Gross profits-to-lagged assets</td>
                        <td class="border ps-2 ">0.1339</td>
                        <td class="border ps-2 ">0.1018</td>
                        <td class="border ps-2 ">1.3153</td>
                        <td class="border ps-2 ">1.2758</td>
                        <td class="border ps-2 ">0.0209</td>
                        <td class="border ps-2 ">0.0108</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">9</td>
                        <td class="border ps-2 ">Years 2-5 lagged returns- annual</td>
                        <td class="border ps-2 ">0.1422</td>
                        <td class="border ps-2 ">0.1102</td>
                        <td class="border ps-2 ">1.2904</td>
                        <td class="border ps-2 ">1.0547</td>
                        <td class="border ps-2 ">0.1466</td>
                        <td class="border ps-2 ">0.0095</td>
                    </tr>
                    <tr>
                        <td class="border ps-2 ">10</td>
                        <td class="border ps-2 ">Gross profits-to-assets</td>
                        <td class="border ps-2 ">0.124</td>
                        <td class="border ps-2 ">0.0974</td>
                        <td class="border ps-2 ">1.2731</td>
                        <td class="border ps-2 ">1.2664</td>
                        <td class="border ps-2 ">0.0032</td>
                        <td class="border ps-2 ">0.0103</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div class="col-md-12 shadow">
            <div id="main" style="width: 100%; height: 700px;"></div>
        </div> --}}
    </div>
@endsection

@section('page-js')
    <script>
        function getFileContent(e) {
            document.getElementById('loader').classList.remove("d-none");
            document.getElementById('analyze').classList.add("d-none");
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    method: "POST",
                    url: `/factors-data-to-watch`,
                    data: {
                        "frequency": $('#frequency').val(),
                        "location": $('#location').val(),
                        "weight": $('#weight').val(),
                        "period": $('#period').val(),
                    }
                })
                .done(function(response) {
                    console.log("new app", response.factorsData);
                    showTable(response.factorsData);
                    updateChart(response);
                    document.getElementById('loader').classList.add("d-none");
                    document.getElementById('analyze').classList.remove("d-none");
                }).fail(function(error) {
                    alert('fail')
                });

        }

        function showTable(response) {
            table = document.getElementById("my-table");
            table.innerHTML = "";
            response.forEach((element, key) => {
                let row = "";
                element.forEach(element2 => {
                    row +=
                        `<td class="border ps-2 ${key == 0?'bg-purple text-light fw-bolder':''}" >${element2}</td>`;
                })
                table.innerHTML += `<tr>${row}</tr>`
            });
        }

        function updateChart(response) {
            console.log("new res", response.factorsData);

            var data = response.factorsData;

            data = data.filter(item => item[1] !== 'Factor');
            var xAxisData = data.map(item => item[1]);
            var seriesData = [];
            var seriesNames = ['Mean Return', 'Volatility', 'Sharpe Ratio', 'Information Ratio', 'Beta', 'Alpha'];

            seriesNames.forEach(() => seriesData.push([]));

            data.forEach(item => {
                item.slice(2).forEach((value, index) => {
                    seriesData[index].push(parseFloat(
                        value));
                });
            });

            var option = {
                xAxis: {
                    type: 'category',
                    data: xAxisData,
                    axisLabel: {
                        interval: 0,
                        rotate: 10
                    }
                },
                yAxis: {
                    type: 'value',
                    name: 'Value',
                    interval: 0.1,
                },
                series: seriesData.map((data, index) => ({
                    name: seriesNames[index],
                    type: 'bar',
                    data: data
                })),
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: seriesNames
                }
            };

            myChart.setOption(option, true);
        }

        // var response = {
        //     factorsData: [
        //         ['1', 'Assets turnover', '0.1226', '0.0456', '2.6886', '-0.4214', '-0.0453', '0.011'],
        //     ]
        // };

        var app = {};

        var chartDom = document.getElementById('main');
        var myChart = echarts.init(chartDom);
        var option;

        app.config = {
            rotate: 90,
            align: 'left',
            verticalAlign: 'middle',
            position: 'insideBottom',
            distance: 15,
            onChange: function() {
                myChart.setOption({
                    series: [{
                            label: labelOption
                        },
                        {
                            label: labelOption
                        },
                        {
                            label: labelOption
                        },
                        {
                            label: labelOption
                        },
                    ]
                });
            }
        };
        const labelOption = {
            show: false,
            position: app.config.position,
            distance: app.config.distance,
            align: app.config.align,
            verticalAlign: app.config.verticalAlign,
            rotate: app.config.rotate,
            formatter: '{c}  {name|{a}}',
            fontSize: 9,
            rich: {
                name: {}
            }
        };
        option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['Mean Return', 'Volatility', 'Sharpe Ratio', 'Information Ratio', 'Beta', 'Alpha']
            },
            toolbox: {
                show: true,
                orient: 'vertical',
                left: 'right',
                top: 'center',
            },
            xAxis: [{
                type: 'category',
                axisTick: {
                    show: false
                },
                data: ['Assets turnover', 'Operating leverage', 'Abnormal corporate investment',
                    'Change sales minus change SG&A', 'Tax expense surprise', 'Altman Z-score',
                    'Years 16-20 lagged returns- annual', 'Gross profits-to-lagged assets',
                    'Years 2-5 lagged returns- annual', 'Gross profits-to-assets'
                ],
                axisLabel: {
                    rotate: 10,
                    interval: 0
                }
            }],
            yAxis: [{
                type: 'value',
                interval: 0.1,
            }],
            series: [{
                    name: 'Mean Return',
                    type: 'bar',
                    barGap: 0,
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [0.1226, 0.112, 0.0569, 0.0718, 0.0557, 0.0827, 0.0784, 0.1339, 0.1422, 0.124]
                },
                {
                    name: 'Volatility',
                    type: 'bar',
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [0.0456, 0.0545, 0.0286, 0.0361, 0.0307, 0.0622, 0.0594, 0.1018, 0.1102, 0.0974]
                },
                {
                    name: 'Sharpe Ratio',
                    type: 'bar',
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [2.6886, 2.055, 1.9895, 1.9889, 1.8143, 1.3296, 1.3199, 1.3153, 1.2904, 1.2731]
                },
                {
                    name: 'Information Ratio',
                    type: 'bar',
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [-0.4214, -0.5525, -0.8129, -0.7572, -0.8713, -0.6179, -0.6529, -0.3292, -0.3049, -0.3824]
                },
                {
                    name: 'Beta',
                    type: 'bar',
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [-0.0453, 0.1103, -0.059, -0.002, 0.0081, -0.0813, -0.0656, 0.0209, 0.1466, 0.0032]
                },
                {
                    name: 'Alpha',
                    type: 'bar',
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: [0.011, 0.0075, 0.0057, 0.006, 0.0045, 0.0082, 0.0076, 0.0108, 0.0095, 0.0103]
                },
            ]
        };

        option && myChart.setOption(option);
    </script>
@endsection
