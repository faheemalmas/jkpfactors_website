@extends('layouts.client.index')

@section('page-css')
    <style>
        #myCSVChart {
            height: 50vh !important;
            width: 100% !important;
            /* Overrides any other height settings from JavaScript */
        }

        .date-input:focus {
            border: none !important;
            outline: none;
        }

        .bg-purple {
            background: black !important;
        }


        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        table thead tr {
            background-color: black !important;
            color: white !important;
        }

        table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        table th,
        table td {
            padding: .625em;
            text-align: center;
            overflow: hidden;
        }

        table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
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
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table td:last-child {
                border-bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    <section>
        {{-- <h1 class="text-dark text-center">Factors Performance</h1> --}}
        <p class="text-center my-3 main-container-text">
            Make selections from the dropdown and click analyze to see monthly factor performance.
        </p>
        {{-- csv chart section --}}
        <div class="container shadow p-5 mb-5 rounded">
            <div class="row align-items-center shadow">
                <div class="col-md-10 align-self-stretch border">

                    {{-- <div id="zoomControls" class="d-none zoom-radios wrapper m-3 ps-5">
                        <span>Zoom</span>
                        <label for="new-1">
                            <input id="new-1" class="peer" type="radio" name="zoom" onclick="changeZoom(12)" />
                            <div class="icon">
                                1y
                            </div>
                        </label>
                        <label for="new-2">
                            <input id="new-2" class="peer" type="radio" name="zoom" onclick="changeZoom(60)" />
                            <div class="icon">
                                5y
                            </div>
                        </label>
                        <label for="new-3">
                            <input id="new-3" class="peer" type="radio" name="zoom" onclick="changeZoom(120)" />
                            <div class="icon">
                                10y
                            </div>
                        </label>
                        <label for="new-4">
                            <input id="new-4" class="peer" type="radio" name="zoom" onclick="changeZoom(-1)"
                                checked />
                            <div class="icon">
                                All
                            </div>
                        </label>
                    </div> --}}

                    <div id="container" style="width: 100%;height:400px;"></div>
                    {{-- <canvas id="myCSVChart" class=""></canvas> --}}
                </div>
                <div class="col-md-2 border align-self-stretch">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="#" class="row" onsubmit="getFileContent(event)">
                                <div class="col-md-12 my-1">
                                    <label for="country">Region/Country</label>
                                    <select name="country" id="country"
                                        class="form-control js-example-basic-single w-100">
                                        <option value="" disabled>Regions</option>
                                        <option value="developed">Developed Markets</option>
                                        <option value="emerging">Emerging Markets</option>
                                        <option value="frontier">Frontier Markets</option>
                                        <option value="" disabled>Countries</option>
                                        <option value="usa" selected>United States</option>
                                        <option value="arg">Argentina</option>
                                        <option value="aus">Australia</option>
                                        <option value="aut">Austria</option>
                                        <option value="bhr">Bahrain</option>
                                        <option value="bgd">Bangladesh</option>
                                        <option value="bel">Belgium</option>
                                        <option value="bra">Brazil</option>
                                        <option value="can">Canada</option>
                                        <option value="chl">Chile</option>
                                        <option value="chn">China</option>
                                        <option value="col">Colombia</option>
                                        <option value="hrv">Croatia</option>
                                        <option value="cyp">Cyprus</option>
                                        <option value="cze">Czech Republic</option>
                                        <option value="dnk">Denmark</option>
                                        <option value="egy">Egypt</option>
                                        <option value="fin">Finland</option>
                                        <option value="fra">France</option>
                                        <option value="deu">Germany</option>
                                        <option value="grc">Greece</option>
                                        <option value="hkg">Hong Kong</option>
                                        <option value="hun">Hungary</option>
                                        <option value="isl">Iceland</option>
                                        <option value="ind">India</option>
                                        <option value="idn">Indonesia</option>
                                        <option value="irn">Iran</option>
                                        <option value="irl">Ireland</option>
                                        <option value="isr">Israel</option>
                                        <option value="ita">Italy</option>
                                        <option value="jpn">Japan</option>
                                        <option value="jor">Jordan</option>
                                        <option value="ken">Kenya</option>
                                        <option value="kor">Korea</option>
                                        <option value="kwt">Kuwait</option>
                                        <option value="lux">Luxembourg</option>
                                        <option value="mys">Malaysia</option>
                                        <option value="mex">Mexico</option>
                                        <option value="mar">Morocco</option>
                                        <option value="nld">Netherlands</option>
                                        <option value="nzl">New Zealand</option>
                                        <option value="nga">Nigeria</option>
                                        <option value="nor">Norway</option>
                                        <option value="omn">Oman</option>
                                        <option value="pak">Pakistan</option>
                                        <option value="per">Peru</option>
                                        <option value="phl">Philippines</option>
                                        <option value="pol">Poland</option>
                                        <option value="prt">Portugal</option>
                                        <option value="qat">Qatar</option>
                                        <option value="rou">Romania</option>
                                        <option value="rus">Russian Federation</option>
                                        <option value="sau">Saudi Arabia</option>
                                        <option value="sgp">Singapore</option>
                                        <option value="svn">Slovenia</option>
                                        <option value="zaf">South Africa</option>
                                        <option value="esp">Spain</option>
                                        <option value="lka">Sri Lanka</option>
                                        <option value="swe">Sweden</option>
                                        <option value="che">Switzerland</option>
                                        <option value="twn">Taiwan</option>
                                        <option value="tha">Thailand</option>
                                        <option value="tto">Trinidad and Tobago</option>
                                        <option value="tur">Turkey</option>
                                        <option value="ukr">Ukraine</option>
                                        <option value="are">United Arab Emirates</option>
                                        <option value="gbr">United Kingdom</option>
                                        <option value="ven">Venezuela</option>
                                        <option value="vnm">Vietnam</option>
                                        <option value="zwe">Zimbabwe</option>
                                    </select>
                                </div>
                                <div class="col-md-12 my-1">
                                    <label for="theme">Theme/Factor</label>
                                    <select name="theme" id="theme"
                                        class="form-control js-example-basic-single w-100">
                                        <option value="" disabled>Themes</option>
                                        <option value="accruals">Accruals</option>
                                        <option value="debt_issuance">Debt Issuance</option>
                                        <option value="investment">Investment</option>
                                        <option value="low_leverage">Low Leverage</option>
                                        <option value="low_risk">Low Risk</option>
                                        <option value="momentum">Momentum</option>
                                        <option value="profit_growth">Profit Growth</option>
                                        <option value="profitability">Profitability</option>
                                        <option value="quality">Quality</option>
                                        <option value="seasonality">Seasonality</option>
                                        <option value="size">Size</option>
                                        <option value="short_term_reversal">Short-Term Reversal</option>
                                        <option value="value">Value</option>
                                        <option value="" disabled>Factors</option>
                                        <option value="capex_abn">Abnormal corporate investment</option>
                                        <option value="z_score">Altman Z-score</option>
                                        <option value="ami_126d">Amihud Measure</option>
                                        <option value="at_gr1">Asset Growth</option>
                                        <option value="tangibility">Asset tangibility</option>
                                        <option value="sale_bev">Asset turnover</option>
                                        <option value="at_me">Assets-to-market</option>
                                        <option value="at_be">Book leverage</option>
                                        <option value="bev_mev">Book-to-market enterprise value</option>
                                        <option value="be_me">Book-to-market equity</option>
                                        <option value="capx_gr1">CAPEX growth (1 year)</option>
                                        <option value="capx_gr2">CAPEX growth (2 years)</option>
                                        <option value="capx_gr3">CAPEX growth (3 years)</option>
                                        <option value="at_turnover">Capital turnover</option>
                                        <option value="ocfq_saleq_std">Cash flow volatility</option>
                                        <option value="cop_at">Cash-based operating profits-to-book assets</option>
                                        <option value="cop_atl1">Cash-based operating profits-to-lagged book assets
                                        </option>
                                        <option value="cash_at">Cash-to-assets</option>
                                        <option value="dgp_dsale">Change gross margin minus change sales</option>
                                        <option value="be_gr1a">Change in common equity</option>
                                        <option value="coa_gr1a">Change in current operating assets</option>
                                        <option value="col_gr1a">Change in current operating liabilities</option>
                                        <option value="cowc_gr1a">Change in current operating working capital</option>
                                        <option value="fnl_gr1a">Change in financial liabilities</option>
                                        <option value="lti_gr1a">Change in long-term investments</option>
                                        <option value="lnoa_gr1a">Change in long-term net operating assets</option>
                                        <option value="nfna_gr1a">Change in net financial assets</option>
                                        <option value="nncoa_gr1a">Change in net noncurrent operating assets</option>
                                        <option value="noa_gr1a">Change in net operating assets</option>
                                        <option value="ncoa_gr1a">Change in noncurrent operating assets</option>
                                        <option value="ncol_gr1a">Change in noncurrent operating liabilities</option>
                                        <option value="ocf_at_chg1">Change in operating cash flow to assets</option>
                                        <option value="niq_at_chg1">Change in quarterly return on assets</option>
                                        <option value="niq_be_chg1">Change in quarterly return on equity</option>
                                        <option value="sti_gr1a">Change in short-term investments</option>
                                        <option value="ppeinv_gr1a">Change PPE and Inventory</option>
                                        <option value="dsale_dinv">Change sales minus change Inventory</option>
                                        <option value="dsale_drec">Change sales minus change receivables</option>
                                        <option value="dsale_dsga">Change sales minus change SG&A</option>
                                        <option value="dolvol_var_126d">Coefficient of variation for dollar trading volume
                                        </option>
                                        <option value="turnover_var_126d">Coefficient of variation for share turnover
                                        </option>
                                        <option value="coskew_21d">Coskewness</option>
                                        <option value="prc_highprc_252d">Current price to high price over last year
                                        </option>
                                        <option value="debt_me">Debt-to-market</option>
                                        <option value="beta_dimson_21d">Dimson beta</option>
                                        <option value="div12m_me">Dividend yield</option>
                                        <option value="dolvol_126d">Dollar trading volume</option>
                                        <option value="betadown_252d">Downside beta</option>
                                        <option value="ni_ar1">Earnings persistence</option>
                                        <option value="earnings_variability">Earnings variability</option>
                                        <option value="ni_ivol">Earnings volatility</option>
                                        <option value="ni_me">Earnings-to-price</option>
                                        <option value="ebitda_mev">Ebitda-to-market enterprise value</option>
                                        <option value="eq_dur">Equity duration</option>
                                        <option value="eqnpo_12m">Equity net payout</option>
                                        <option value="age">Firm age</option>
                                        <option value="betabab_1260d">Frazzini-Pedersen market beta</option>
                                        <option value="fcf_me">Free cash flow-to-price</option>
                                        <option value="gp_at">Gross profits-to-assets</option>
                                        <option value="gp_atl1">Gross profits-to-lagged assets</option>
                                        <option value="debt_gr3">Growth in book debt (3 years)</option>
                                        <option value="rmax5_21d">Highest 5 days of return</option>
                                        <option value="rmax5_rvol_21d">Highest 5 days of return scaled by volatility
                                        </option>
                                        <option value="emp_gr1">Hiring rate</option>
                                        <option value="iskew_capm_21d">Idiosyncratic skewness from the CAPM</option>
                                        <option value="iskew_ff3_21d">Idiosyncratic skewness from the Fama-French 3-factor
                                            model</option>
                                        <option value="iskew_hxz4_21d">Idiosyncratic skewness from the q-factor model
                                        </option>
                                        <option value="ivol_capm_21d">Idiosyncratic volatility from the CAPM (21 days)
                                        </option>
                                        <option value="ivol_capm_252d">Idiosyncratic volatility from the CAPM (252 days)
                                        </option>
                                        <option value="ivol_ff3_21d">Idiosyncratic volatility from the Fama-French 3-factor
                                            model</option>
                                        <option value="ivol_hxz4_21d">Idiosyncratic volatility from the q-factor model
                                        </option>
                                        <option value="ival_me">Intrinsic value-to-market</option>
                                        <option value="inv_gr1a">Inventory change</option>
                                        <option value="inv_gr1">Inventory growth</option>
                                        <option value="kz_index">Kaplan-Zingales index</option>
                                        <option value="sale_emp_gr1">Labor force efficiency</option>
                                        <option value="aliq_at">Liquidity of book assets</option>
                                        <option value="aliq_mat">Liquidity of market assets</option>
                                        <option value="ret_60_12">Long-term reversal</option>
                                        <option value="beta_60m">Market Beta</option>
                                        <option value="corr_1260d">Market correlation</option>
                                        <option value="market_equity">Market Equity</option>
                                        <option value="rmax1_21d">Maximum daily return</option>
                                        <option value="mispricing_mgmt">Mispricing factor: Management</option>
                                        <option value="mispricing_perf">Mispricing factor: Performance</option>
                                        <option value="dbnetis_at">Net debt issuance</option>
                                        <option value="netdebt_me">Net debt-to-price</option>
                                        <option value="eqnetis_at">Net equity issuance</option>
                                        <option value="noa_at">Net operating assets</option>
                                        <option value="eqnpo_me">Net payout yield</option>
                                        <option value="chcsho_12m">Net stock issues</option>
                                        <option value="netis_at">Net total issuance</option>
                                        <option value="ni_inc8q">Number of consecutive quarters with earnings increases
                                        </option>
                                        <option value="zero_trades_21d">Number of zero trades with turnover as tiebreaker
                                            (1 month)</option>
                                        <option value="zero_trades_252d">Number of zero trades with turnover as tiebreaker
                                            (12 months)</option>
                                        <option value="zero_trades_126d">Number of zero trades with turnover as tiebreaker
                                            (6 months)</option>
                                        <option value="o_score">Ohlson O-score</option>
                                        <option value="oaccruals_at">Operating accruals</option>
                                        <option value="ocf_at">Operating cash flow to assets</option>
                                        <option value="ocf_me">Operating cash flow-to-market</option>
                                        <option value="opex_at">Operating leverage</option>
                                        <option value="op_at">Operating profits-to-book assets</option>
                                        <option value="ope_be">Operating profits-to-book equity</option>
                                        <option value="op_atl1">Operating profits-to-lagged book assets</option>
                                        <option value="ope_bel1">Operating profits-to-lagged book equity</option>
                                        <option value="eqpo_me">Payout yield</option>
                                        <option value="oaccruals_ni">Percent operating accruals</option>
                                        <option value="taccruals_ni">Percent total accruals</option>
                                        <option value="f_score">Pitroski F-score</option>
                                        <option value="ret_12_1">Price momentum t-12 to t-1</option>
                                        <option value="ret_12_7">Price momentum t-12 to t-7</option>
                                        <option value="ret_3_1">Price momentum t-3 to t-1</option>
                                        <option value="ret_6_1">Price momentum t-6 to t-1</option>
                                        <option value="ret_9_1">Price momentum t-9 to t-1</option>
                                        <option value="prc">Price per share</option>
                                        <option value="ebit_sale">Profit margin</option>
                                        <option value="qmj">Quality minus Junk: Composite</option>
                                        <option value="qmj_growth">Quality minus Junk: Growth</option>
                                        <option value="qmj_prof">Quality minus Junk: Profitability</option>
                                        <option value="qmj_safety">Quality minus Junk: Safety</option>
                                        <option value="niq_at">Quarterly return on assets</option>
                                        <option value="niq_be">Quarterly return on equity</option>
                                        <option value="rd5_at">R&D capital-to-book assets</option>
                                        <option value="rd_me">R&D-to-market</option>
                                        <option value="rd_sale">R&D-to-sales</option>
                                        <option value="resff3_12_1">Residual momentum t-12 to t-1</option>
                                        <option value="resff3_6_1">Residual momentum t-6 to t-1</option>
                                        <option value="ni_be">Return on equity</option>
                                        <option value="ebit_bev">Return on net operating assets</option>
                                        <option value="rvol_21d">Return volatility</option>
                                        <option value="saleq_gr1">Sales Growth (1 quarter)</option>
                                        <option value="sale_gr1">Sales Growth (1 year)</option>
                                        <option value="sale_gr3">Sales Growth (3 years)</option>
                                        <option value="sale_me">Sales-to-market</option>
                                        <option value="turnover_126d">Share turnover</option>
                                        <option value="ret_1_0">Short-term reversal</option>
                                        <option value="niq_su">Standardized earnings surprise</option>
                                        <option value="saleq_su">Standardized Revenue surprise</option>
                                        <option value="tax_gr1a">Tax expense surprise</option>
                                        <option value="pi_nix">Taxable income-to-book income</option>
                                        <option value="bidaskhl_21d">The high-low bid-ask spread</option>
                                        <option value="taccruals_at">Total accruals</option>
                                        <option value="rskew_21d">Total skewness</option>
                                        <option value="seas_1_1an">Year 1-lagged return, annual</option>
                                        <option value="seas_1_1na">Year 1-lagged return, nonannual</option>
                                        <option value="seas_2_5an">Years 2-5 lagged returns, annual</option>
                                        <option value="seas_2_5na">Years 2-5 lagged returns, nonannual</option>
                                        <option value="seas_6_10an">Years 6-10 lagged returns, annual</option>
                                        <option value="seas_6_10na">Years 6-10 lagged returns, nonannual</option>
                                        <option value="seas_11_15an">Years 11-15 lagged returns, annual</option>
                                        <option value="seas_11_15na">Years 11-15 lagged returns, nonannual</option>
                                        <option value="seas_16_20an">Years 16-20 lagged returns, annual</option>
                                        <option value="seas_16_20na">Years 16-20 lagged returns, nonannual</option>
                                    </select>
                                </div>
                                <div class="col-md-12 my-1 d-none">
                                    <label for="frequency">Data Frequency</label>
                                    <select name="" id="frequency"
                                        class="form-control js-example-basic-single w-100">
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="daily">Daily</option>
                                    </select>
                                </div>
                                <div class="col-md-12 my-1">
                                    <label for="weight">Weighting</label>
                                    <select name="weight" id="weight"
                                        class="form-control js-example-basic-single w-100">
                                        <option value="vw_cap">Capped Value Weighted (Recommended)</option>
                                        <option value="vw">Value Weighted</option>
                                        <option value="ew">Equal Weighted</option>
                                    </select>
                                </div>
                                <div class="col-12 justify-content-center my-4">
                                    <button type="submit"
                                        class="btn btn-primary rounded rounded-pill p-2 d-block mx-auto px-4"
                                        style="font-weight: 200;border: 1px solid black; color: black; background: transparent;"
                                        id="analyze">
                                        Analyze
                                    </button>
                                    <div class="d-none" id="loader">
                                        <div class="spinner-border text-primary mx-auto d-block" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="border d-flex justify-content-between p-3 mt-5 shadow rounded">
                    <div class="w-25 d-flex justify-content-between">
                        <input type="date" id="startDate" placeholder="Start Date"
                            class="date-input rounded-pill border-0 px-3" style="width: 48%">
                        <input type="date" id="endDate" placeholder="End Date"
                            class="date-input rounded-pill border-0 px-3" style="width: 48%">
                    </div>
                    <div>
                        <button onclick="filterChart()" class="btn btn-primary rounded rounded-pill p-2 px-4"
                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;">Filter</button>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="border d-flex justify-content-between p-3 mt-4 shadow rounded">
                    <table id="my-table">
                        <thead>
                            <tr>
                                <td scope="col">Statistic</td>
                                <td scope="col">Last Year</td>
                                <td scope="col">Last 5 Years</td>
                                <td scope="col">Last 10 Years
                                </td>
                                <td scope="col">Full Sample</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Statistic">Average Returns (Ann. %)</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                            <tr>
                                <td data-label="Statistic">Volatility (Ann. %)</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                            <tr>
                                <td data-label="Statistic">Sharpe Ratio</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                            <tr>
                                <td data-label="Statistic">Info. Ratio</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                            <tr>
                                <td data-label="Statistic">Alpha (Ann. %)</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                            <tr>
                                <td data-label="Statistic">Beta</td>
                                <td data-label="Last Year">0</td>
                                <td data-label="Last 5 Years">0</td>
                                <td data-label="Last 10 Years">0</td>
                                <td data-label="Full Sample">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <p>
                    For comparison of different factors, click <a class="text-dark" href="/analysis">here</a>
                </p>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

    <script>
        let myChart;
        let start;

        function getRandomColor() {
            var color = "#042D53";
            return color;
        }

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
                    url: `/get-graph-data`,
                    data: {
                        "region": $('#country').val(),
                        "theme": $('#theme').val(),
                        "frequency": $('#frequency').val(),
                        "weight": $('#weight').val(),
                    }
                })
                .done(function(response) {
                    plotGraph(response.graphData, response.marketData);
                    showTable(response.statsData);
                    document.getElementById('loader').classList.add("d-none");
                    document.getElementById('analyze').classList.remove("d-none");
                }).fail(function(error) {
                    alert('fail')
                });

        }

        function showTable(response) {
            const tableElement = document.getElementById("my-table");

            tableElement.innerHTML = "";

            const header = response[0];
            const rows = response.slice(1);

            let thead = `<thead>
                    <tr>
                        ${header.map(item => `<td scope="col">${item}</td>`).join('')}
                    </tr>
                 </thead>`;

            let tbody = '<tbody>';
            rows.forEach(row => {
                tbody += '<tr>';
                row.forEach((cell, index) => {
                    tbody +=
                        `<td data-label="${header[index]}">${(cell.indexOf(".") > -1 && cell.indexOf("%") == -1 && cell  != "Info. Ratio") ? (Math.round(cell * 100) / 100).toFixed(2):cell}</td>`;
                });
                tbody += '</tr>';
            });
            tbody += '</tbody>';

            tableElement.innerHTML = thead + tbody;
        }

        window.filterChart = function() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            if (startDate && endDate) {
                var start = moment(startDate);
                var end = moment(endDate);

                if (start.isValid() && end.isValid()) {
                    myChart.options.scales.x.min = start.toDate();
                    myChart.options.scales.x.max = end.toDate();
                    myChart.update();
                } else {
                    alert('Invalid dates. Please enter correct dates.');
                }
            } else {
                alert('Please enter both start and end dates.');
            }
        };

        function plotGraph(response, market) {
            let dates = response.data.dates;
            let values = response.data.values;

            let marketdates = market.data.dates;
            let marketvalues = market.data.values;

            var cumulativeData = [];
            var marketcumulativeData = [];


            var sum = 1; // Start with 1
            var marketsum = 0;

            values.forEach(function(point) {
                sum = point;
                cumulativeData.push(sum);
            });

            marketvalues.forEach(function(point) {
                marketsum += point;
                marketcumulativeData.push(marketsum);
            });

            Highcharts.stockChart("container", {
                title: {
                    text: "Analysis of data",
                    align: "left",
                },

                subtitle: {
                    text: "Display data for",
                    align: "left",
                },

                plotOptions: {
                    series: {
                        // pointStart: Date.UTC(1946, 0, 1),
                        // pointIntervalUnit: "month",
                        // gapSize: 3,
                    },
                },

                rangeSelector: {
                    selected: 5
                },

                // tooltip: {
                //     pointFormatter: function() {
                //         return 'Factor: ' + (this.cumulativeSum + 1);
                //     },
                //     shared: true,
                //     split: false,
                //     changeDecimals: 2,
                //     valueDecimals: 2,
                //       valuePrefix: "$",
                //       valueSuffix: " USD",
                // },

                xAxis: {
                    minRange: 3 * 24 * 36e5,
                    max: Date.UTC(2023, 0, 6),
                },
                yAxis: [
                    {
                    labels: {
                        formatter: function() {
                            return this.value + 1;
                        }
                    }
                }
            ],
                series: [{
                        name: "Factor",
                        data: cumulativeData,
                        cumulativeStart: true,
                        cumulative: true,
                        pointStart: Date.UTC(1946, 0, 1),
                        pointIntervalUnit: "month",
                        tooltip: {
                            pointFormatter: function() {
                                return 'Factor: ' + (this.cumulativeSum + 1).toFixed(2);
                            }
                        }
                    },
                    {
                        name: "Market",
                        data: marketcumulativeData,
                        cumulativeStart: true,
                        cumulative: true,
                        pointStart: Date.UTC(1946, 0, 1),
                        pointIntervalUnit: "month",
                        tooltip: {
                            pointFormatter: function() {
                                return 'Market: ' + (this.y + 1).toFixed(2);
                            }
                        }
                    }
                ],
            });
        }
    </script>
@endsection
