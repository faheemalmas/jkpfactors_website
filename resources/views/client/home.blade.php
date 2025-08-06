@extends('layouts.client.index')
@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container {
            z-index: 2050 !important;
        }

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

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        table thead tr {
            background-color: black !important;
            color: white !important;
        }

        table th,
        table td {
            padding: .625em;
            text-align: center;
            overflow: hidden;
        }

        table th {
            font-size: .85em !important;
            letter-spacing: .1em !important;
            text-transform: uppercase !important;
        }

        @media screen and (max-width: 780px) {
            table {
                border: 0;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: .625em;
            }

            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: .8em;
                text-align: right;
            }

            table td::before {
                /*
                                                                                                            * aria-label has no advantage, it won't be read inside a table
                                                                                                            content: attr(aria-label);
                                                                                                            */
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table td:last-child {
                border-bottom: 0;
            }
        }


        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: black !important;
            color: white
        }

        .select2-container--default .select2-results__option--disabled {
            font-size: 20px !important;
            color: black !important;
            /* font-weight: 800 !important; */
            border-bottom: 1px solid black !important;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px !important;
        }

        @media screen and (max-width: 768px) {
            .table-overflow {
                overflow: scroll;
            }
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endsection

@section('content')
    <!-- Start Hero Section -->
    <section>
        <div class="main">
            <div class="container">
                <p class="my-3 container raleway-font text-dark main-container-text">
                    This website is based on the article <a
                        href="https://onlinelibrary.wiley.com/doi/full/10.1111/jofi.13249">“Is There a Replication Crisis in
                        Finance?”</a> (Jensen, Kelly, and Pedersen, Journal of Finance 2023).
                    This paper constructs 153 characteristics/factors clustered into 13 themes (see cluster diagram <a
                        href="/graph">here</a> ) in
                    93 countries. This website provides access to the data and a number of other resources.

                    Please site our paper if you are using this data. You can access the BibTex
                    <a class="copyButton raleway-font text-dark position-relative">here.<span
                            class="tooltip">Copied!</span></a>
                    <code style="display: none">
                        @article{JensenKellyPedersen2023, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; author = {Jensen, Theis Ingerslev and Kelly, Bryan
                        and
                        Pedersen, Lasse Heje}, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; title = {Is There a Replication Crisis in Finance?},
                        <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; journal = {The Journal of Finance}, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; volume = {78}, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; number = {5}, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; pages = {246-2518}, <br>
                        &nbsp; &nbsp; &nbsp; &nbsp; year = {2023} <br>
                        }
                    </code>
                </p>

                <div class="mt-5">
                    <div class="text-center mb-4"
                        style="font-size:20px; color:#000; margin-bottom:20px; font-family: 'DM Serif Display' !important;">
                        <span class="text-center fs-5"
                            style="border-bottom:solid 2px #000; padding-bottom: 3px;">Authors</span>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-12">
                                    <h2 class="text-center" style="font-size: 20px;font-weight: 300;">
                                        <a class="author raleway-font" style="color: darkorange;; font-size: 20px;"
                                            href="https://www.tijensen.com/">Theis I.
                                            Jensen</a>
                                    </h2>
                                </div>
                                <div class="col-12">
                                    <p class="text-center author-dec mb-2">Yale</p>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="col-12">
                                    <h2 class="text-center" style="font-size: 20px;font-weight: 300;">
                                        <a class="author raleway-font" style="color: darkorange;; font-size: 20px;"
                                            href="https://www.bryankellyacademic.org/">Bryan Kelly</a>
                                    </h2>
                                </div>
                                <div class="col-12">
                                    <p class="text-center author-dec mb-2">
                                        Yale, AQR Capital, and NBER
                                    </p>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="col-12">
                                    <h2 class="text-center" style="font-size: 20px;font-weight: 300;">
                                        <a class="author raleway-font" style="color: darkorange;; font-size: 20px;"
                                            href="https://www.lhpedersen.com/">Lasse H.
                                            Pedersen</a>
                                    </h2>
                                </div>
                                <div class="col-12">
                                    <p class="text-center author-dec mb-2">Copenhagen Business School and AQR Capital</p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <h2 class="text-center mt-4" style="font-family: 'DM Serif Display' !important;">
                    Factors to watch
                </h2> --}}
                <div class="text-center mt-4 "
                    style="font-size:20px; color:#000; margin-bottom:20px; font-family: 'DM Serif Display' !important;">
                    <span class="text-center fs-5" style="border-bottom:solid 2px #000; padding-bottom: 3px;">Factors to
                        Watch</span>
                </div>
                <p class="container raleway-font text-dark main-container-text text-center">
                    Below is a list of top performing capped value weighted factors in US over the last year. <br> For more
                    information, click <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">here</a>.
                </p>

                <div class="container">
                    {{-- <div class="col-md-12 shadow px-5 py-4 mb-5">
                        <form action="#" class="row" onsubmit="getFileContent(event)">
                            <div class="col-md-3 my-1" style="z-index: 1;">
                                <label for="">Location</label>
                                <select name="" id="location" class=" js-example-basic-single form-control w-100">
                                    <option value="us">USA</option>
                                    <option value="ex_us">EX-USA</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: 1;">
                                <label for="">Frequency</label>
                                <select name="" id="frequency" class="js-example-basic-single form-control w-100">
                                    <option value="monthly">Monthly</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: 1;">
                                <label for="">Weighting</label>
                                <select name="" id="weight" class=" js-example-basic-single form-control w-100">
                                    <option value="vw_cap">Value Weighted-Cap</option>
                                    <option value="vw">Value Weighted</option>
                                    <option value="ew">Equal Weighted</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: 1;">
                                <label for="">Time Period</label>
                                <select name="period" id="period" class="js-example-basic-single form-control w-100">
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
                        </form>
                    </div> --}}
                    <div class="col-md-12 px-5 my-2" id="child-container">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <td style="text-transform: uppercase;" scope="col">Ranking
                                    </td>
                                    <td style="text-transform: uppercase;" scope="col">Factor
                                    </td>
                                    {{-- <td style="text-transform: uppercase;" scope="col">Average
                                        Returns (Ann. %)
                                    </td>
                                    <td style="text-transform: uppercase;" scope="col">
                                        Volatility (Ann. %)</td> --}}
                                    <td style="text-transform: uppercase;" scope="col">Sharpe
                                        Ratio</td>
                                    {{-- <td style="text-transform: uppercase;" scope="col">Info.
                                        Ratio</td>
                                    <td style="text-transform: uppercase;" scope="col">Alpha
                                        (Ann. %)</td>
                                    <td style="text-transform: uppercase;" scope="col">Beta
                                    </td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Ranking">1</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Asset turnover
                                    </td>
                                    {{-- <td data-label="Average Returns (Ann. %)">0.1226</td>
                                    <td data-label="Volatility (Ann. %)">0.0456</td> --}}
                                    <td data-label="Sharpe Ratio">2.69</td>
                                    {{-- <td data-label="Info. Ratio">2.9173</td>
                                    <td data-label="Alpha (Ann. %)">-0.0453</td>
                                    <td data-label="Beta">0.011</td> --}}
                                </tr>
                                <tr>
                                    <td data-label="Ranking">2</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Operating leverage
                                    </td>
                                    {{-- <td data-label="Average Returns (Ann. %)">0.112</td>
                                    <td data-label="Volatility (Ann. %)">0.0545</td> --}}
                                    <td data-label="Sharpe Ratio">2.06</td>
                                    {{-- <td data-label="Info. Ratio">1.7536</td>
                                    <td data-label="Alpha (Ann. %)">0.1103</td>
                                    <td data-label="Beta">0.0075</td> --}}
                                </tr>
                                <tr>
                                    <td data-label="Ranking">3</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Change sales minus
                                        change SG&A
                                    </td>
                                    {{-- <td data-label="Average Returns (Ann. %)">0.0569</td>
                                    <td data-label="Volatility (Ann. %)">0.0286</td> --}}
                                    <td data-label="Sharpe Ratio">1.99</td>
                                    {{-- <td data-label="Info. Ratio">2.5271</td>
                                    <td data-label="Alpha (Ann. %)">-0.059</td>
                                    <td data-label="Beta">0.0057</td> --}}
                                </tr>
                                <tr>
                                    <td data-label="Ranking">4</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Abnormal corporate
                                        investment</td>
                                    {{-- <td data-label="Average Returns (Ann. %)">0.0718</td>
                                    <td data-label="Volatility (Ann. %)">0.0361</td> --}}
                                    <td data-label="Sharpe Ratio">1.99</td>
                                    {{-- <td data-label="Info. Ratio">2.0012</td>
                                    <td data-label="Alpha (Ann. %)">-0.002</td>
                                    <td data-label="Beta">0.006</td> --}}
                                </tr>
                                <tr>
                                    <td data-label="Ranking">5</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Tax expense
                                        surprise</td>
                                    {{-- <td data-label="Average Returns (Ann. %)">0.0557</td> --}}
                                    {{-- <td data-label="Volatility (Ann. %)">0.0307</td> --}}
                                    <td data-label="Sharpe Ratio">1.81</td>
                                    {{-- <td data-label="Info. Ratio">1.7654</td>
                                    <td data-label="Alpha (Ann. %)">0.0081</td>
                                    <td data-label="Beta">0.0045</td> --}}
                                </tr>
                                {{-- <tr>
                                    <td data-label="Ranking">6</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Altman Z-score</td>
                                    <td data-label="Average Returns (Ann. %)">0.0827</td>
                                    <td data-label="Volatility (Ann. %)">0.0622</td>
                                    <td data-label="Sharpe Ratio">1.3296</td>
                                    <td data-label="Info. Ratio">1.6207</td>
                                    <td data-label="Alpha (Ann. %)">-0.0813</td>
                                    <td data-label="Beta">0.0082</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">7</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Years 16-20 lagged
                                        returns- annual</td>
                                    <td data-label="Average Returns (Ann. %)">0.0784</td>
                                    <td data-label="Volatility (Ann. %)">0.0594</td>
                                    <td data-label="Sharpe Ratio">1.3199</td>
                                    <td data-label="Info. Ratio">1.5594</td>
                                    <td data-label="Alpha (Ann. %)">-0.0656</td>
                                    <td data-label="Beta">0.0076</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">8</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Gross
                                        profits-to-lagged assets
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.1339</td>
                                    <td data-label="Volatility (Ann. %)">0.1018</td>
                                    <td data-label="Sharpe Ratio">1.3153</td>
                                    <td data-label="Info. Ratio">1.2758</td>
                                    <td data-label="Alpha (Ann. %)">0.0209</td>
                                    <td data-label="Beta">0.0108</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">9</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Years 2-5 lagged
                                        returns- annual
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.1422</td>
                                    <td data-label="Volatility (Ann. %)">0.1102</td>
                                    <td data-label="Sharpe Ratio">1.2904</td>
                                    <td data-label="Info. Ratio">1.0547</td>
                                    <td data-label="Alpha (Ann. %)">0.1466</td>
                                    <td data-label="Beta">0.0095</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">10</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Gross
                                        profits-to-assets</td>
                                    <td data-label="Average Returns (Ann. %)">0.124</td>
                                    <td data-label="Volatility (Ann. %)">0.0974</td>
                                    <td data-label="Sharpe Ratio">1.2731</td>
                                    <td data-label="Info. Ratio">1.2664</td>
                                    <td data-label="Alpha (Ann. %)">0.0032</td>
                                    <td data-label="Beta">0.0103</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <div class="container">
                    <div class="col-md-12 shadow px-5 py-4 mb-5">
                        <form action="#" class="row" onsubmit="getFileContent(event)">
                            <div class="col-md-3 my-1" style="z-index: -1;">
                                <label for="">Location</label>
                                <select name="" id="location" class=" js-example-basic-single form-control w-100">
                                    <option value="us">USA</option>
                                    <option value="ex_us">EX-USA</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: -1;">
                                <label for="">Frequency</label>
                                <select name="" id="frequency" class="js-example-basic-single form-control w-100">
                                    <option value="monthly">Monthly</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: -1;">
                                <label for="">Weighting</label>
                                <select name="" id="weight" class=" js-example-basic-single form-control w-100">
                                    <option value="vw_cap">Value Weighted-Cap</option>
                                    <option value="vw">Value Weighted</option>
                                    <option value="ew">Equal Weighted</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-1" style="z-index: -1;">
                                <label for="">Time Period</label>
                                <select name="period" id="period" class="js-example-basic-single form-control w-100">
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
                        </form>
                    </div>
                    <div class="col-md-12 shadow px-5 py-4 my-5" id="parent-container">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <td style="text-transform: uppercase;" scope="col">Ranking
                                    </td>
                                    <td style="text-transform: uppercase;" scope="col">Factor
                                    </td>
                                    <td style="text-transform: uppercase;" scope="col">Average
                                        Returns (Ann. %)
                                    </td>
                                    <td style="text-transform: uppercase;" scope="col">
                                        Volatility (Ann. %)</td>
                                    <td style="text-transform: uppercase;" scope="col">Sharpe
                                        Ratio</td>
                                    <td style="text-transform: uppercase;" scope="col">Info.
                                        Ratio</td>
                                    <td style="text-transform: uppercase;" scope="col">Alpha
                                        (Ann. %)</td>
                                    <td style="text-transform: uppercase;" scope="col">Beta
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Ranking">1</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Assets turnover
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.1226</td>
                                    <td data-label="Volatility (Ann. %)">0.0456</td>
                                    <td data-label="Sharpe Ratio">2.6886</td>
                                    <td data-label="Info. Ratio">2.9173</td>
                                    <td data-label="Alpha (Ann. %)">-0.0453</td>
                                    <td data-label="Beta">0.011</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">2</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Operating leverage
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.112</td>
                                    <td data-label="Volatility (Ann. %)">0.0545</td>
                                    <td data-label="Sharpe Ratio">2.055</td>
                                    <td data-label="Info. Ratio">1.7536</td>
                                    <td data-label="Alpha (Ann. %)">0.1103</td>
                                    <td data-label="Beta">0.0075</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">3</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Change sales minus
                                        change SG&A
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.0569</td>
                                    <td data-label="Volatility (Ann. %)">0.0286</td>
                                    <td data-label="Sharpe Ratio">1.9895</td>
                                    <td data-label="Info. Ratio">2.5271</td>
                                    <td data-label="Alpha (Ann. %)">-0.059</td>
                                    <td data-label="Beta">0.0057</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">4</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Abnormal corporate
                                        investment</td>
                                    <td data-label="Average Returns (Ann. %)">0.0718</td>
                                    <td data-label="Volatility (Ann. %)">0.0361</td>
                                    <td data-label="Sharpe Ratio">1.9889</td>
                                    <td data-label="Info. Ratio">2.0012</td>
                                    <td data-label="Alpha (Ann. %)">-0.002</td>
                                    <td data-label="Beta">0.006</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">5</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Tax expense
                                        surprise</td>
                                    <td data-label="Average Returns (Ann. %)">0.0557</td>
                                    <td data-label="Volatility (Ann. %)">0.0307</td>
                                    <td data-label="Sharpe Ratio">1.8143</td>
                                    <td data-label="Info. Ratio">1.7654</td>
                                    <td data-label="Alpha (Ann. %)">0.0081</td>
                                    <td data-label="Beta">0.0045</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">6</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Altman Z-score</td>
                                    <td data-label="Average Returns (Ann. %)">0.0827</td>
                                    <td data-label="Volatility (Ann. %)">0.0622</td>
                                    <td data-label="Sharpe Ratio">1.3296</td>
                                    <td data-label="Info. Ratio">1.6207</td>
                                    <td data-label="Alpha (Ann. %)">-0.0813</td>
                                    <td data-label="Beta">0.0082</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">7</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Years 16-20 lagged
                                        returns- annual</td>
                                    <td data-label="Average Returns (Ann. %)">0.0784</td>
                                    <td data-label="Volatility (Ann. %)">0.0594</td>
                                    <td data-label="Sharpe Ratio">1.3199</td>
                                    <td data-label="Info. Ratio">1.5594</td>
                                    <td data-label="Alpha (Ann. %)">-0.0656</td>
                                    <td data-label="Beta">0.0076</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">8</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Gross
                                        profits-to-lagged assets
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.1339</td>
                                    <td data-label="Volatility (Ann. %)">0.1018</td>
                                    <td data-label="Sharpe Ratio">1.3153</td>
                                    <td data-label="Info. Ratio">1.2758</td>
                                    <td data-label="Alpha (Ann. %)">0.0209</td>
                                    <td data-label="Beta">0.0108</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">9</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Years 2-5 lagged
                                        returns- annual
                                    </td>
                                    <td data-label="Average Returns (Ann. %)">0.1422</td>
                                    <td data-label="Volatility (Ann. %)">0.1102</td>
                                    <td data-label="Sharpe Ratio">1.2904</td>
                                    <td data-label="Info. Ratio">1.0547</td>
                                    <td data-label="Alpha (Ann. %)">0.1466</td>
                                    <td data-label="Beta">0.0095</td>
                                </tr>
                                <tr>
                                    <td data-label="Ranking">10</td>
                                    <td style="text-transform: uppercase;" data-label="Factor">Gross
                                        profits-to-assets</td>
                                    <td data-label="Average Returns (Ann. %)">0.124</td>
                                    <td data-label="Volatility (Ann. %)">0.0974</td>
                                    <td data-label="Sharpe Ratio">1.2731</td>
                                    <td data-label="Info. Ratio">1.2664</td>
                                    <td data-label="Alpha (Ann. %)">0.0032</td>
                                    <td data-label="Beta">0.0103</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}


                <div class="row align-items-center mt-5">
                    <div class="col-md-12">
                        <div class="intro-excerpt">
                            <div>
                                <p style="line-height: 25px;" class="text-dark">
                                    The content of this website is updated regularly as new data becomes available. The
                                    latest update
                                    includes data through December 2024.
                                    {{-- <div class="copyButton" style="opacity: 0;"> 📋<span class="tooltip">Copied!</span></div> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" style="width: 99vw;margin: auto;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-md-12 shadow px-5 py-4 mb-5">
                                <form action="#" class="row" onsubmit="getFileContent(event)">
                                    <div class="col-md-4 my-1">
                                        <label for="">Location</label>
                                        <select name="" id="location"
                                            class=" js-example-basic-single form-control w-100">
                                            <option value="us">USA</option>
                                            <option value="ex_us">EX-USA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 my-1 d-none">
                                        <label for="">Frequency</label>
                                        <select name="" id="frequency"
                                            class="js-example-basic-single form-control w-100">
                                            <option value="monthly" selected>Monthly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 my-1">
                                        <label for="">Weighting</label>
                                        <select name="" id="weight"
                                            class=" js-example-basic-single form-control w-100">
                                            <option value="vw_cap">Value Weighted-Cap</option>
                                            <option value="vw">Value Weighted</option>
                                            <option value="ew">Equal Weighted</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 my-1">
                                        <label for="">Time Period</label>
                                        <select name="period" id="period"
                                            class="js-example-basic-single form-control w-100">
                                            <option value="Last_Year">Last Year</option>
                                            <option value="Last_5_Years">Last 5 Years</option>
                                            <option value="Last_10_Years">Last 10 Years</option>
                                            <option value="Full_Sample">Full Sample</option>
                                        </select>
                                    </div>
                                    <div class="col-12 justify-content-center my-4">
                                        <button type="submit"
                                            class="btn btn-primary rounded rounded-pill p-2 d-block mx-auto px-4"
                                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;"
                                            id="analyze">Analyze
                                        </button>
                                        <div class="d-none" id="loader">
                                            <div class="spinner-border text-primary mx-auto d-block" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 shadow px-5 py-4 my-5" id="parent-container">
                                <table class="w-100">
                                    <thead>
                                        <tr>
                                            <td style="text-transform: uppercase;" scope="col">Ranking
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">Factor
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">Average
                                                Returns (Ann. %)
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">
                                                Volatility (Ann. %)</td>
                                            <td style="text-transform: uppercase;" scope="col">Sharpe
                                                Ratio</td>
                                            <td style="text-transform: uppercase;" scope="col">Info.
                                                Ratio</td>
                                            <td style="text-transform: uppercase;" scope="col">Alpha
                                                (Ann. %)</td>
                                            <td style="text-transform: uppercase;" scope="col">Beta
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Ranking">1</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Assets turnover
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.12</td>
                                            <td data-label="Volatility (Ann. %)">0.04</td>
                                            <td data-label="Sharpe Ratio">2.68</td>
                                            <td data-label="Info. Ratio">2.91</td>
                                            <td data-label="Alpha (Ann. %)">-0.04</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">2</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Operating leverage
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.11</td>
                                            <td data-label="Volatility (Ann. %)">0.05</td>
                                            <td data-label="Sharpe Ratio">2.05</td>
                                            <td data-label="Info. Ratio">1.75</td>
                                            <td data-label="Alpha (Ann. %)">0.11</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">3</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Change sales minus
                                                change SG&A
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.06</td>
                                            <td data-label="Volatility (Ann. %)">0.03</td>
                                            <td data-label="Sharpe Ratio">1.99</td>
                                            <td data-label="Info. Ratio">2.53</td>
                                            <td data-label="Alpha (Ann. %)">-0.06</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">4</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Abnormal corporate
                                                investment</td>
                                            <td data-label="Average Returns (Ann. %)">0.07</td>
                                            <td data-label="Volatility (Ann. %)">0.04</td>
                                            <td data-label="Sharpe Ratio">1.99</td>
                                            <td data-label="Info. Ratio">2.00</td>
                                            <td data-label="Alpha (Ann. %)">-0.00</td>
                                            <td data-label="Beta">0.00</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">5</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Tax expense
                                                surprise</td>
                                            <td data-label="Average Returns (Ann. %)">0.06</td>
                                            <td data-label="Volatility (Ann. %)">0.03</td>
                                            <td data-label="Sharpe Ratio">1.81</td>
                                            <td data-label="Info. Ratio">1.76</td>
                                            <td data-label="Alpha (Ann. %)">0.01</td>
                                            <td data-label="Beta">0.00</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">6</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Altman Z-score</td>
                                            <td data-label="Average Returns (Ann. %)">0.08</td>
                                            <td data-label="Volatility (Ann. %)">0.06</td>
                                            <td data-label="Sharpe Ratio">1.33</td>
                                            <td data-label="Info. Ratio">1.62</td>
                                            <td data-label="Alpha (Ann. %)">-0.08</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">7</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Years 16-20 lagged
                                                returns- annual</td>
                                            <td data-label="Average Returns (Ann. %)">0.08</td>
                                            <td data-label="Volatility (Ann. %)">0.06</td>
                                            <td data-label="Sharpe Ratio">1.32</td>
                                            <td data-label="Info. Ratio">1.56</td>
                                            <td data-label="Alpha (Ann. %)">-0.07</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">8</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Gross
                                                profits-to-lagged assets
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.13</td>
                                            <td data-label="Volatility (Ann. %)">0.10</td>
                                            <td data-label="Sharpe Ratio">1.32</td>
                                            <td data-label="Info. Ratio">1.28</td>
                                            <td data-label="Alpha (Ann. %)">0.02</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">9</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Years 2-5 lagged
                                                returns- annual
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.14</td>
                                            <td data-label="Volatility (Ann. %)">0.11</td>
                                            <td data-label="Sharpe Ratio">1.29</td>
                                            <td data-label="Info. Ratio">1.05</td>
                                            <td data-label="Alpha (Ann. %)">0.14</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">10</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Gross
                                                profits-to-assets</td>
                                            <td data-label="Average Returns (Ann. %)">0.12</td>
                                            <td data-label="Volatility (Ann. %)">0.10</td>
                                            <td data-label="Sharpe Ratio">1.27</td>
                                            <td data-label="Info. Ratio">1.26</td>
                                            <td data-label="Alpha (Ann. %)">0.00</td>
                                            <td data-label="Beta">0.01</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="container">
                            <div class="col-md-12 shadow px-5 py-4 mb-5">
                                <form action="#" class="row" onsubmit="getFileContent(event)">
                                    <div class="col-md-3 my-1">
                                        <label for="">Location</label>
                                        <select name="" id=""
                                            class=" js-example-basic-single form-control w-100">
                                            <option value="us">USA</option>
                                            <option value="ex_us">EX-USA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 my-1">
                                        <label for="">Frequency</label>
                                        <select name="" id=""
                                            class="js-example-basic-single form-control w-100">
                                            <option value="monthly">Monthly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 my-1">
                                        <label for="">Weighting</label>
                                        <select name="" id=""
                                            class=" js-example-basic-single form-control w-100">
                                            <option value="vw_cap">Value Weighted-Cap</option>
                                            <option value="vw">Value Weighted</option>
                                            <option value="ew">Equal Weighted</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 my-1">
                                        <label for="">Time Period</label>
                                        <select name="period" id=""
                                            class="js-example-basic-single form-control w-100">
                                            <option value="Last_Year">Last Year</option>
                                            <option value="Last_5_Years">Last 5 Years</option>
                                            <option value="Last_10_Years">Last 10 Years</option>
                                            <option value="Full_Sample">Full Sample</option>
                                        </select>
                                    </div>
                                    <div class="col-12 justify-content-center my-4">
                                        <button type="submit"
                                            class="btn btn-primary rounded rounded-pill p-2 d-block mx-auto px-4"
                                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;"
                                            id="analyze_home">Analyze
                                        </button>
                                        <div class="d-none" id="loader">
                                            <div class="spinner-border text-primary mx-auto d-block" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 shadow px-5 py-4 my-5" id="parent-container">
                                <table class="w-100">
                                    <thead>
                                        <tr>
                                            <td style="text-transform: uppercase;" scope="col">Ranking
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">Factor
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">Average
                                                Returns (Ann. %)
                                            </td>
                                            <td style="text-transform: uppercase;" scope="col">
                                                Volatility (Ann. %)</td>
                                            <td style="text-transform: uppercase;" scope="col">Sharpe
                                                Ratio</td>
                                            <td style="text-transform: uppercase;" scope="col">Info.
                                                Ratio</td>
                                            <td style="text-transform: uppercase;" scope="col">Alpha
                                                (Ann. %)</td>
                                            <td style="text-transform: uppercase;" scope="col">Beta
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Ranking">1</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Assets turnover
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.1226</td>
                                            <td data-label="Volatility (Ann. %)">0.0456</td>
                                            <td data-label="Sharpe Ratio">2.6886</td>
                                            <td data-label="Info. Ratio">2.9173</td>
                                            <td data-label="Alpha (Ann. %)">-0.0453</td>
                                            <td data-label="Beta">0.011</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">2</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Operating leverage
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.112</td>
                                            <td data-label="Volatility (Ann. %)">0.0545</td>
                                            <td data-label="Sharpe Ratio">2.055</td>
                                            <td data-label="Info. Ratio">1.7536</td>
                                            <td data-label="Alpha (Ann. %)">0.1103</td>
                                            <td data-label="Beta">0.0075</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">3</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Change sales minus
                                                change SG&A
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.0569</td>
                                            <td data-label="Volatility (Ann. %)">0.0286</td>
                                            <td data-label="Sharpe Ratio">1.9895</td>
                                            <td data-label="Info. Ratio">2.5271</td>
                                            <td data-label="Alpha (Ann. %)">-0.059</td>
                                            <td data-label="Beta">0.0057</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">4</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Abnormal corporate
                                                investment</td>
                                            <td data-label="Average Returns (Ann. %)">0.0718</td>
                                            <td data-label="Volatility (Ann. %)">0.0361</td>
                                            <td data-label="Sharpe Ratio">1.9889</td>
                                            <td data-label="Info. Ratio">2.0012</td>
                                            <td data-label="Alpha (Ann. %)">-0.002</td>
                                            <td data-label="Beta">0.006</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">5</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Tax expense
                                                surprise</td>
                                            <td data-label="Average Returns (Ann. %)">0.0557</td>
                                            <td data-label="Volatility (Ann. %)">0.0307</td>
                                            <td data-label="Sharpe Ratio">1.8143</td>
                                            <td data-label="Info. Ratio">1.7654</td>
                                            <td data-label="Alpha (Ann. %)">0.0081</td>
                                            <td data-label="Beta">0.0045</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">6</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Altman Z-score</td>
                                            <td data-label="Average Returns (Ann. %)">0.0827</td>
                                            <td data-label="Volatility (Ann. %)">0.0622</td>
                                            <td data-label="Sharpe Ratio">1.3296</td>
                                            <td data-label="Info. Ratio">1.6207</td>
                                            <td data-label="Alpha (Ann. %)">-0.0813</td>
                                            <td data-label="Beta">0.0082</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">7</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Years 16-20 lagged
                                                returns- annual</td>
                                            <td data-label="Average Returns (Ann. %)">0.0784</td>
                                            <td data-label="Volatility (Ann. %)">0.0594</td>
                                            <td data-label="Sharpe Ratio">1.3199</td>
                                            <td data-label="Info. Ratio">1.5594</td>
                                            <td data-label="Alpha (Ann. %)">-0.0656</td>
                                            <td data-label="Beta">0.0076</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">8</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Gross
                                                profits-to-lagged assets
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.1339</td>
                                            <td data-label="Volatility (Ann. %)">0.1018</td>
                                            <td data-label="Sharpe Ratio">1.3153</td>
                                            <td data-label="Info. Ratio">1.2758</td>
                                            <td data-label="Alpha (Ann. %)">0.0209</td>
                                            <td data-label="Beta">0.0108</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">9</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Years 2-5 lagged
                                                returns- annual
                                            </td>
                                            <td data-label="Average Returns (Ann. %)">0.1422</td>
                                            <td data-label="Volatility (Ann. %)">0.1102</td>
                                            <td data-label="Sharpe Ratio">1.2904</td>
                                            <td data-label="Info. Ratio">1.0547</td>
                                            <td data-label="Alpha (Ann. %)">0.1466</td>
                                            <td data-label="Beta">0.0095</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Ranking">10</td>
                                            <td style="text-transform: uppercase;" data-label="Factor">Gross
                                                profits-to-assets</td>
                                            <td data-label="Average Returns (Ann. %)">0.124</td>
                                            <td data-label="Volatility (Ann. %)">0.0974</td>
                                            <td data-label="Sharpe Ratio">1.2731</td>
                                            <td data-label="Info. Ratio">1.2664</td>
                                            <td data-label="Alpha (Ann. %)">0.0032</td>
                                            <td data-label="Beta">0.0103</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="new-section">
        <div class="md-modal md-effect-12">
            <div class="md-content my-5">
                <div id="main" style="width: 100%; height: 600px;"></div>

                <div>
                    <div class="md-close">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-overlay"></div>
    </section>


    <section class="" style="display: none;">
        <div class="container pb-4">
            <h4 class="fs-5">
                News
            </h4>
            <ul>
                <li>
                    3/2024. New Paper: <a href="#">In Search of the True Greenium,</a> with Marc Eckildsen, Markus
                    Lbert, and Lasse Heje Pedersen
                </li>
                <li>
                    1/2024. <a href="#">Is There a Replication Crisis?</a> wins The Journal of Finance,
                    Dinensional
                    Fund Advisors Prize distinguished paper.
                </li>
                <li>
                    1/2024. <a href="#">Is There a Replication Crisis?</a> wins The Journal of Finance,
                    Dinensional
                    Fund Advisors Prize distinguished paper.
                </li>
            </ul>
        </div>
    </section>
@endsection

@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.copyButton').forEach(button => {
                button.addEventListener('click', function() {
                    const codeToCopy = this.nextElementSibling.innerText;

                    navigator.clipboard.writeText(codeToCopy).then(() => {
                        const copiedTooltip = document.createElement('span');
                        copiedTooltip.textContent = 'Copied!';
                        copiedTooltip.style.position = 'absolute';
                        copiedTooltip.style.backgroundColor = 'black';
                        copiedTooltip.style.color = 'white';
                        copiedTooltip.style.borderRadius = '4px';
                        copiedTooltip.style.padding = '5px';
                        copiedTooltip.style.top = '-10px';
                        copiedTooltip.style.left = '100%';
                        copiedTooltip.style.zIndex = '1000';
                        copiedTooltip.style.fontSize = '0.8rem';

                        button.appendChild(copiedTooltip);

                        setTimeout(() => {
                            button.removeChild(copiedTooltip);
                        }, 1000);
                    }).catch(err => console.error('Failed to copy:', err));
                });
            });


        });

        function giveMain() {
            // e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    method: "POST",
                    url: `/factors-data-to-watch`,
                    data: {
                        "frequency": "monthly",
                        "location": "us",
                        "weight": "vw_cap",
                        "period": "Last_Year",
                    }
                })
                .done(function(response) {
                    showTable(response.factorsData);
                    console.log(response.factorsData);
                    showStateTable(response.factorsData);
                    updateChart(response);
                }).fail(function(error) {
                    alert('fail')
                });

        }
        giveMain()

        function showStateTable(response) {
            if (!Array.isArray(response) || response.length === 0) {
                console.error('Invalid response structure');
                return;
            }

            const header = response[0];
            const indicesToInclude = [0, 1, 4]; // Indices for 'Ranking', 'Factors', and 'Sharpe Ratio'

            let table = `
                <div>
                    <table class="w-100">
                        <thead>
                            <tr>
                                ${indicesToInclude.map(index => `<td style="text-transform: uppercase;" scope="col">${header[index]}</td>`).join('')}
                            </tr>
                        </thead>
                        <tbody id="my-table-2">
                        </tbody>
                    </table>
                </div>`;

            document.getElementById('child-container').innerHTML = table;

            const tbody = document.getElementById("my-table-2");
            response.slice(1, 6).forEach((element, key) => {
                let row = `
                    <tr>
                        ${element.filter((_, index) => indicesToInclude.includes(index))
                                .map((item, index) => {
                                    const headerIndex = indicesToInclude[index];
                                    if (headerIndex === 4 && !isNaN(parseFloat(item))) {
                                        item = parseFloat(item).toFixed(2);
                                    }
                                    return ` <td style = "text-transform: uppercase;" data-label = "${header[headerIndex]}"> ${item} </td>`;}).join('')} </tr>`;
                tbody.innerHTML += row;
        });
        }

        // function showStateTable(response) {
        //     if (!Array.isArray(response) || response.length === 0) {
        //         console.error('Invalid response structure');
        //         return;
        //     }

        //     const header = response[0];
        //     const indicesToInclude = [0, 1, 4]; // Indices for 'Ranking', 'Factors', and 'Sharpe Ratio'

        //     let table = `
    //             <div>
    //                 <table class="w-100">
    //                     <thead>
    //                         <tr>
    //                             ${indicesToInclude.map(index => `<td style="text-transform: uppercase;" scope="col">${header[index]}</td>`).join('')}
    //                         </tr>
    //                     </thead>
    //                     <tbody id="my-table-2">
    //                     </tbody>
    //                 </table>
    //             </div>`;

        //     document.getElementById('child-container').innerHTML = table;

        //     const tbody = document.getElementById("my-table-2");
        //     response.slice(1).forEach((element, key) => {
        //         let row = `
    //                 <tr>
    //                     ${element.filter((_, index) => indicesToInclude.includes(index))
    //                             .map((item, index) => {
    //                                 const headerIndex = indicesToInclude[index];
    //                                 return `<td style="text-transform: uppercase;" data-label="${header[headerIndex]}">${item}</td>`;
    //                             }).join('')}
    //                 </tr>`;
        //         tbody.innerHTML += row;
        //     });
        // }




        function getFileContent(e) {
            document.getElementById('loader').classList.remove("d-none");
            document.getElementById('analyze').classList.add("d-none");
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // console.log( $('#frequency').val(),);
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
            if (!Array.isArray(response) || response.length === 0) {
                console.error('Invalid response structure');
                return;
            }

            const header = response[0];

            let table = `
                        <div>
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        ${header.map(item => `<td style="text-transform: uppercase;" scope="col">${item}</td>`).join('')}
                                    </tr>
                                </thead>
                                <tbody id="my-table">
                                </tbody>
                            </table>
                        </div>`;

            document.getElementById('parent-container').innerHTML = table;

            const tbody = document.getElementById("my-table");
            response.slice(1).forEach((element, key) => {
                let row = `
            <tr>
                ${element.map((item, index) => `<td style="text-transform: uppercase;" data-label="${header[index]}">${ item.indexOf(".") > -1 ? (Math.round(item * 100) / 100).toFixed(2):item}</td>`).join('')}
            </tr>`;
                tbody.innerHTML += row;
            });
        }

        function updateChart(response) {
            // console.log("new res", response.factorsData);

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
