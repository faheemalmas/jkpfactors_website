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

    <section>
        <h1>Benchmarks</h1>
        @if (isset($error))
            <div>{{ $error }}</div>
        @endif

        @php
            use Carbon\Carbon;
        @endphp
        @if (isset($benchmarks))
            <table class="w-100">
                <thead>
                    <tr>
                        <td style="text-transform: uppercase;" scope="col">Model Name</td>
                        <td style="text-transform: uppercase;" scope="col">User Name</td>
                        <td style="text-transform: uppercase;" scope="col">Email</td>
                        <td style="text-transform: uppercase;" scope="col">Submission Timestamp</td>
                        <td style="text-transform: uppercase;" scope="col">Sharpe</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($benchmarks as $benchmark)
                        <tr>
                            <td data-label="Model Name">{{ $benchmark['model_name'] }}</td>
                            <td data-label="User Name">{{ $benchmark['user_name'] }}</td>
                            <td data-label="Email">{{ $benchmark['email'] }}</td>
                            <td data-label="Submission Timestamp">
                                {{ Carbon::createFromTimestamp($benchmark['submission_timestamp'])->format('d-m-Y H:i:s') }}    
                            </td>
                            <td data-label="Sharpe">{{ $benchmark['sharpe'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif


        {{-- @if (isset($benchmarks))
        <table>
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Submission Timestamp</th>
                    <th>Sharpe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($benchmarks as $benchmark)
                    <tr>
                        <td>{{ $benchmark['model_name'] }}</td>
                        <td>{{ $benchmark['user_name'] }}</td>
                        <td>{{ $benchmark['email'] }}</td>
                        <td>{{ $benchmark['submission_timestamp'] }}</td>
                        <td>{{ $benchmark['sharpe'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif --}}
    </section>
@endsection
