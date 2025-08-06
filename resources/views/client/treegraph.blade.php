@extends('layouts.client.index')
@section('page-css')
    <style>
        .copyButton {
            cursor: pointer;
        }

        .tooltip {
            width: 20px;
            height: 20px;
        }

        code {
            color: #040c53 !important;
        }
    </style>

    <style>
        .thebtn {
            display: block;
            margin: 5% auto 0;

            background: transparent;
            border: 2px solid #444;
            padding: 5px 10px;
        }

        .md-close {
            position: absolute;
            top: -30px;
            right: 20px;
            cursor: pointer;
        }

        .md-modal {
            margin: auto;
            position: fixed;
            top: 5%;
            left: 0;
            right: 0;
            bottom: 5%;
            width: 80%;
            min-width: 320px;
            height: auto;
            z-index: 2000;
            visibility: hidden;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
            background-color: white;
            opacity: 1;
            box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.45);
            -webkit-box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.45);
            -moz-box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.45);
            border-radius: 10px;
        }

        .md-show {
            visibility: visible;
        }

        .md-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            visibility: hidden;
            top: 0;
            left: 0;
            z-index: 1000;
            opacity: 0;
            background: rgba(#e4f0e3, 0.8);
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .md-show .md-overlay {
            opacity: 1;
            visibility: visible;
        }

        .md-effect-12 .md-content {
            -webkit-transform: scale(0.8);
            -moz-transform: scale(0.8);
            -ms-transform: scale(0.8);
            transform: scale(0.8);
            opacity: 0;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .md-show.md-effect-12 .md-overlay {
            background-color: #e4f0e3;
        }

        .md-effect-12 .md-content h3,
        .md-effect-12 .md-content {
            background: transparent;
        }

        .md-show.md-effect-12 .md-content {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    </style>
@endsection

@section('content')
<section>
    <div class="container-fluid">
        <div id="main" style="width: 100%; height: 4000px;"></div>
    </div>
</section>
@endsection

@section('page-js')

    <script>
        var ROOT_PATH = 'https://jkpfactors.com';

        var chartDom = document.getElementById('main');
        var myChart = echarts.init(chartDom);
        var option;

        myChart.showLoading();
        $.get(ROOT_PATH + '/assets/data/flare.json', function(data) {
            myChart.hideLoading();
            data.children.forEach(function(datum, index) {
                index % 2 === 0 && (datum.collapsed = false);
            });
            myChart.setOption(
                (option = {
                    tooltip: {
                        trigger: 'item',
                        triggerOn: 'mousemove'
                    },
                    series: [{
                        type: 'tree',
                        data: [data],
                        top: '1%',
                        // right: '10px',
                        bottom: '1%',
                        // left: '40px',
                        symbolSize: 7,
                        label: {
                            position: 'left',
                            verticalAlign: 'middle',
                            align: 'right',
                            fontSize: 9
                        },
                        leaves: {
                            label: {
                                position: 'right',
                                verticalAlign: 'middle',
                                align: 'left'
                            }
                        },
                        emphasis: {
                            focus: 'descendant'
                        },
                        expandAndCollapse: false,
                        animationDuration: 550,
                        animationDurationUpdate: 750
                    }]
                })
            );
        });

        option && myChart.setOption(option);
    </script>

    <script>
        $(function() {

            $('.md-trigger').on('click', function() {
                $('.md-modal').addClass('md-show');
            });

            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            });

        });
    </script>
@endsection
