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

        .add-dropdown:disabled,
        .add-dropdown:disabled:hover {
            cursor: not-allowed;
            opacity: 0.5;

        }

        .plus-btn {
            width: 60px !important;
            height: 60px !important;
            margin: 22px auto auto auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
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

            td:nth-child(1) {
                color: black !important;
            }
        }


        .half-black-half-white {
            background: linear-gradient(to right, black 90%, white 10%);
            -webkit-background-clip: text;
            color: transparent;
        }

        td:first-child {
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            background: linear-gradient(to right, black 90%, white 10%);
            -webkit-background-clip: text;
            color: transparent;
        }


        td:first-child:hover,
        td:first-child:focus {
            overflow: visible;
        }

        td:first-child::before,
        td:first-child::after {
            left: 50%;
            opacity: 1;
            position: absolute;
            z-index: -100;
        }

        td:first-child:hover::before,
        td:first-child:focus::before,
        td:first-child:hover::after,
        td:first-child:focus::after {
            opacity: 1 !important;
            transform: scale(1) translateY(0) !important;
            z-index: 100 !important;
            overflow: visible !important;
        }


        td:first-child::before {
            border-style: solid;
            border-width: 1em 0.75em 0 0.75em;
            border-color: #7A7878 transparent transparent transparent;
            bottom: 100%;
            content: "";
            margin-left: 2em;
            margin-bottom: -0.8em;
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26), opacity .65s .5s;
            transform: scale(.6) translateY(-90%);
            opacity: 0;

        }

        td:first-child:hover::before,
        td:first-child:focus::before {
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
        }

        td:first-child::after {
            background: rgb(122, 120, 120);
            border-radius: .25em;
            bottom: 180%;
            color: white;
            content: attr(data-tip);
            margin-left: -16.75em;
            margin-bottom: -1em;
            padding: 1em;
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
            transform: scale(.6) translateY(50%);
            opacity: 0;
        }

        td:first-child:hover::after,
        td:first-child:focus::after {
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26);
        }

        td {
            padding: 7px;
        }

        .checkbox-margin {
            margin-left: 9%;
        }

        @media screen and (max-width: 1024px) {
            .checkbox-margin {
                margin-left: 12%;
            }
        }

        @media screen and (max-width: 768px) {
            .checkbox-margin {
                margin-left: 17%;
            }
        }

        @media screen and (max-width: 425px) {
            .checkbox-margin {
                margin-left: 30%;
            }
        }

        @media screen and (max-width: 375px) {
            .checkbox-margin {
                margin-left: 35%;
            }
        }
    </style>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
@endsection

@section('content')
    <section>
        <p class="text-center my-3 main-container-text">
            Make selections from the dropdown and click plot to compare different monthly factors.
        </p>
        <div class="container shadow p-3 mb-5 rounded">
            <div class="w-50 checkbox-margin">
                <div class="form-check form-switch row justify-content-evenly position-relative">
                    <span class="position-absolute" style="left: -110px">Raw returns</span>
                    <input class="form-check-input position-absolute" style="top: 4px;" type="checkbox" id="toggleUrlSwitch"
                        onchange="toggleUrl()">
                    <span class="position-absolute" style="right: -30px">Market-adjusted returns</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div id="zoomControls" class="d-none zoom-radios wrapper m-3 ps-5">
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
                            <input id="new-3" class="peer" type="radio" name="zoom" onclick="changeZoom(120)"
                                checked />
                            <div class="icon">
                                10y
                            </div>
                        </label>
                        <label for="new-4">
                            <input id="new-4" class="peer" type="radio" name="zoom" onclick="changeZoom(-1)" />
                            <div class="icon">
                                All
                            </div>
                        </label>
                    </div>
                    <div id="container" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="col-md-12">
                    <div class="p-3 border shadow">
                        <form action="#" class="row" onsubmit="plotGraph(event)">
                            <div id="dropdown-container">
                                <!-- Initial dropdown set -->
                                <div class="row dropdown-set" id="dropdown-set-0">
                                    <div class="col my-1">
                                        <label for="">Region/Country</label>
                                        <select name="region" id="region_0"
                                            class="form-control region js-example-basic-single w-100">
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
                                    <div class="col my-1">
                                        <label for="">Theme/Factor</label>
                                        <select name="theme" id="theme_0"
                                            class="form-control theme js-example-basic-single w-100">
                                            <option value="" disabled>Themes</option>
                                            <option value="accruals">Accruals Theme</option>
                                            <option value="debt_issuance">Debt Issuance Theme</option>
                                            <option value="investment">Investment Theme</option>
                                            <option value="low_leverage">Low Leverage Theme</option>
                                            <option value="low_risk">Low Risk Theme</option>
                                            <option value="momentum">Momentum Theme</option>
                                            <option value="profit_growth">Profit Growth Theme</option>
                                            <option value="profitability">Profitability Theme</option>
                                            <option value="quality">Quality Theme</option>
                                            <option value="seasonality">Seasonality Theme</option>
                                            <option value="size">Size Theme</option>
                                            <option value="short_term_reversal">Short-Term Reversal Theme</option>
                                            <option value="value">Value Theme</option>

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
                                            <option value="dolvol_var_126d">Coefficient of variation for dollar trading
                                                volume</option>
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
                                            <option value="iskew_ff3_21d">Idiosyncratic skewness from the Fama-French
                                                3-factor model</option>
                                            <option value="iskew_hxz4_21d">Idiosyncratic skewness from the q-factor model
                                            </option>
                                            <option value="ivol_capm_21d">Idiosyncratic volatility from the CAPM (21 days)
                                            </option>
                                            <option value="ivol_capm_252d">Idiosyncratic volatility from the CAPM (252
                                                days)
                                            </option>
                                            <option value="ivol_ff3_21d">Idiosyncratic volatility from the Fama-French
                                                3-factor model</option>
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
                                            <option value="zero_trades_21d">Number of zero trades with turnover as
                                                tiebreaker (1 month)</option>
                                            <option value="zero_trades_252d">Number of zero trades with turnover as
                                                tiebreaker (12 months)</option>
                                            <option value="zero_trades_126d">Number of zero trades with turnover as
                                                tiebreaker (6 months)</option>
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
                                    <div class="col-md-2 my-1 d-none">
                                        <label for="">Data Frequency</label>
                                        <select name="frequency" id="frequency_0"
                                            class="form-control frequency js-example-basic-single w-100">
                                            <option value="monthly" selected>Monthly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                    <div class="col my-1">
                                        <label for="">Weighting</label>
                                        <select name="weight" id="weight_0"
                                            class="form-control weight js-example-basic-single w-100">
                                            <option value="vw_cap">Capped Value Weighted (Recommended)</option>
                                            <option value="vw">Value Weighted</option>
                                            <option value="ew">Equal Weighted</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 my-1" style="align-self: center;">
                                        <button
                                            class="btn btn-primary plus-btn rounded rounded-pill mt-4 add-dropdown w-100"
                                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 justify-content-center my-4">
                                <button type="submit"
                                    class="btn btn-primary rounded rounded-pill p-2 d-block mx-auto px-4"
                                    style="font-weight: 200; border: 1px solid black; color: black; background: transparent;"
                                    style="font-size: 12px;" id="analyze">Plot
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
                <div class="container mb-5">
                    <div class="row border p-3 mt-4 shadow rounded d-none" id="yearsTableContainer">
                        <div id="yearsControls" class="d-none zoom-radios m-3 ps-5 text-center">
                            <span>Years</span>
                            <label for="year-1">
                                <input id="year-1" class="peer" type="radio" name="years"
                                    onclick="changeYears(1)" />
                                <div class="icon">1y</div>
                            </label>
                            <label for="year-2">
                                <input id="year-2" class="peer" type="radio" name="years"
                                    onclick="changeYears(5)" />
                                <div class="icon">5y</div>
                            </label>
                            <label for="year-3">
                                <input id="year-3" class="peer" type="radio" name="years"
                                    onclick="changeYears(10)" />
                                <div class="icon">10y</div>
                            </label>
                            <label for="year-4">
                                <input id="year-4" class="peer" type="radio" name="years"
                                    onclick="changeYears(100)" />
                                <div class="icon">All</div>
                            </label>
                        </div>

                        <div class="m-auto">
                            <div id="yearsTable1">
                                <table id="table1" style="width: 100%;"></table>
                            </div>
                            <div class="col-12 d-none" id="yearsTable2">
                                <table id="table2" style="width: 100%;"></table>
                            </div>
                            <div class="col-12 d-none" id="yearsTable3">
                                <table id="table3" style="width: 100%;"></table>
                            </div>
                            <div class="col-12 d-none" id="yearsTable4">
                                <table id="table4" style="width: 100%;"></table>
                            </div>
                        </div>
                    </div>

                    <p class="my-3 main-container-text">
                        For analysis of individual factors, click <a href="/performance-of-factors">here</a>
                    </p>
                </div>
            </div>
    </section>
@endsection


@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>

    <script>
        let chart;
        let index = 1;
        let datesArray = [];
        let dataValues = [];
        let statsDataArray = [];
        let selectedUrl = `/get-graph-data`;
        let plotClicked = false;

        document.getElementById('analyze').addEventListener('click', function(event) {
            plotClicked = true;
        });

        function toggleUrl() {
            if (!plotClicked) {
                return;
            }
            
            const toggleSwitch = document.getElementById('toggleUrlSwitch');
            if (toggleSwitch.checked) {
                selectedUrl = `/get-alpha-graph-data`;
                plotGraph(event)
            } else {
                selectedUrl = `/get-graph-data`;
                plotGraph(event)
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeSelect2();
            initializeChart();
        });

        function initializeSelect2() {
            $('.js-example-basic-single').select2({
                placeholder: "Select an option",
                allowClear: false
            });
        }

        function initializeChart() {
            if (document.getElementById('container')) {
                chart = Highcharts.stockChart('container', {
                    credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            dataGrouping: {
                                enabled: false
                            }
                        }
                    },
                    rangeSelector: {
                        buttons: [{
                            type: 'year',
                            count: 1,
                            text: '1y'
                        }, {
                            type: 'year',
                            count: 5,
                            text: '5y'
                        }, {
                            type: 'year',
                            count: 10,
                            text: '10y'
                        }, {
                            type: 'all',
                            text: 'All'
                        }],
                        selected: 5,
                        inputEnabled: false,
                    },
                    exporting: {
                        enabled: false
                    },
                    title: {
                        text: ''
                    },
                    navigator: {
                        enabled: false,
                        adaptToUpdatedData: false,
                        backgroundColor: 'red',
                        borderColor: '#cccccc',
                        series: {
                            lineWidth: 0
                        }
                    },
                    scrollbar: {
                        liveRedraw: false,
                        barBorderRadius: 0,
                        barBorderWidth: 1,
                        buttonsEnabled: false,
                        height: 15,
                        margin: 0,
                        rifleColor: '#333',
                        trackBackgroundColor: '#f2f2f2',
                        trackBorderRadius: 0
                    },
                    xAxis: {
                        type: 'datetime',
                        events: {
                            afterSetExtremes: function(event) {
                                const min = event.min;
                                chart.series.forEach(series => {
                                    const modifiedData = getModifiedData(series.options.originalData,
                                        min);
                                    series.setData(modifiedData, false);
                                });
                                chart.redraw();
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        crosshairs: true,
                        pointFormatter: function() {
                            const cumulativeSum = this.y;
                            return `${this.series.name}: ${(this.cumulativeSum).toFixed(2)}<br>`;
                        },
                        valueDecimals: 2,
                    },
                    yAxis: {
                        labels: {
                            formatter: function() {
                                return this.value;
                            }
                        },
                        startOnTick: false,
                        endOnTick: false,
                    },
                    legend: {
                        enabled: true,
                    },
                    series: []
                });
            } else {
                console.error("Chart container not found");
            }
        }

        function getModifiedData(data, min) {
            var modifiedData = data.map(function(point) {
                return [point[0], point[0] >= min ? point[1] : null];
            });

            var initialPointIndex = modifiedData.findIndex(function(point) {
                return point[0] >= min;
            });

            if (initialPointIndex !== -1) {
                modifiedData[initialPointIndex] = [modifiedData[initialPointIndex][0], 1];
            }
            return modifiedData;
        }

        function plotGraph(event) {
            event.preventDefault();
            const loader = document.getElementById('loader');
            const analyzeBtn = document.getElementById('analyze');
            loader.classList.remove("d-none");
            analyzeBtn.classList.add("d-none");

            document.getElementById('yearsTableContainer').classList.remove("d-none");
            document.getElementById('yearsControls').classList.remove("d-none");

            const dropdownSets = document.querySelectorAll('.dropdown-set');
            const selections = new Set();
            let hasDuplicate = false;
            let completedRequests = 0;

            const series = [];
            let datesArray = [];
            let statsDataArray = [];
            let dataValues = [];

            ['table1', 'table2', 'table3', 'table4'].forEach(tableId => {
                const table = document.getElementById(tableId);
                if (table) {
                    const tbody = table.querySelector('tbody');
                    if (tbody) {
                        tbody.innerHTML = '';
                    } else {
                        console.error(`No tbody found in table with id ${tableId}`);
                    }
                } else {
                    console.error(`No table found with id ${tableId}`);
                }
            });

            dropdownSets.forEach((set) => {
                const region = set.querySelector(`[name="region"]`).value;
                const theme = set.querySelector(`[name="theme"]`).value;
                const frequency = set.querySelector(`[name="frequency"]`).value;
                const weight = set.querySelector(`[name="weight"]`).value;
                const selectionKey = `${region}-${theme}-${frequency}-${weight}`;

                if (selections.has(selectionKey)) {
                    alert("Duplicate selections found. Please remove the repetition or change the selection.");
                    loader.classList.add("d-none");
                    analyzeBtn.classList.remove("d-none");
                    hasDuplicate = true;
                    return;
                }
                selections.add(selectionKey);
            });

            if (hasDuplicate) return;

            while (chart.series.length > 0) {
                chart.series[0].remove(true);
            }

            dropdownSets.forEach((set, i) => {
                const region = set.querySelector(`[name="region"]`).value;
                const theme = set.querySelector(`[name="theme"]`).value;
                const frequency = set.querySelector(`[name="frequency"]`).value;
                const weight = set.querySelector(`[name="weight"]`).value;

                if (region && theme && frequency && weight) {
                    setTimeout(() => {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            method: "POST",
                            url: selectedUrl,
                            data: {
                                region,
                                theme,
                                frequency,
                                weight
                            },
                            success: function(response) {
                                handleSuccess(response, dropdownSets.length, set.id, i);
                            },
                            error: function(xhr, status, error) {
                                handleError(status, error, dropdownSets.length);
                            }
                        });
                    }, i * 1000);
                } else {
                    console.warn('Missing parameters in dropdown set', set);
                    completedRequests++;
                }
            });

            function handleSuccess(response, totalRequests, setId, index) {
                if (response.graphData && response.graphData.data && response.graphData.data.values && response.graphData
                    .data.dates) {
                    datesArray.push(response.graphData.data.dates);
                    statsDataArray.push(response.statsData);
                    dataValues.push(response.graphData.label);
                } else {
                    console.error(`Invalid data structure for ${response.graphData.label}:`, response);
                    alert(`Failed to retrieve valid data for ${response.graphData.label}.`);
                }
                addSeries(response, setId, index);
                completedRequests++;
                checkCompletion(totalRequests);
            }

            function handleError(status, error, totalRequests) {
                console.error('Error:', status, error);
                alert('Failed to retrieve data.');
                completedRequests++;
                checkCompletion(totalRequests);
            }

            function checkCompletion(totalRequests) {
                if (completedRequests === totalRequests) {
                    loader.classList.add("d-none");
                    analyzeBtn.classList.remove("d-none");
                    showTable(statsDataArray, dataValues);

                    document.getElementById('year-4').checked = true;
                    changeYears(100);

                    document.getElementById('yearsControls').classList.remove("d-none");
                    document.getElementById('yearsTableContainer').classList.remove("d-none");
                }
            }

            function addSeries(response, setId, index) {
                if (!response || !response.graphData || !response.graphData.data) {
                    console.error('Invalid response structure:', response);
                    return;
                }

                let dates = response.graphData.data.dates.map(date => Date.parse(date));
                let values = response.graphData.data.values;

                if (!dates || !values || dates.length !== values.length) {
                    console.error('Mismatched dates and values lengths:', dates, values);
                    return;
                }

                let cumulativeData = [];
                let cumulativeSum = 1;
                values.forEach((point, i) => {
                    cumulativeSum = point;
                    cumulativeData.push([dates[i], cumulativeSum]);
                });

                chart.addSeries({
                    id: `dropdown-set-${setId}`,
                    name: response.graphData.label,
                    data: cumulativeData,
                    type: 'line',
                    legendIndex: index,
                    cumulative: true,
                    cumulativeStart: true,
                    originalData: cumulativeData
                });
                chart.redraw();
                chart.rangeSelector.clickButton(1, true);
                chart.rangeSelector.clickButton(3, true);
            }
        }

        function showTable(statsDataArray, dataValues) {
            console.log("statsDataArray", statsDataArray, "dataValues", dataValues);
            document.getElementById('yearsControls').classList.remove("d-none");
            document.getElementById('yearsTableContainer').classList.remove("d-none");

            statsDataArray.forEach((arrayData, index) => {
                if (Array.isArray(arrayData) && arrayData.length >= 5) {
                    const label = dataValues[index];
                    createTable('table1', arrayData, 1, label);
                    createTable('table2', arrayData, 2, label);
                    createTable('table3', arrayData, 3, label);
                    createTable('table4', arrayData, 4, label);
                } else {
                    console.error(`Insufficient data received for array ${index + 1}.`);
                }
            });
        }

        function createTable(tableId, data, columnIndex, label) {
            const table = document.getElementById(tableId);

            if (!table) {
                console.error(`Table with id ${tableId} not found.`);
                return;
            }

            if (table.rows.length === 0) {
                table.innerHTML = `
                <thead>
                    <tr>
                        <th scope="col">Factor</th>
                        <th scope="col">Average Returns (Ann. %)</th>
                        <th scope="col">Volatility (Ann. %)</th>
                        <th scope="col">Sharpe Ratio</th>
                        <th scope="col">Info. Ratio</th>
                        <th scope="col">Alpha (Ann. %)</th>
                        <th scope="col">Beta</th>
                    </tr>
                </thead>
                <tbody></tbody>`;
            }

            let valueRow = '<tr>';
            data.forEach(function(entry, idx) {
                if (Array.isArray(entry) && entry.length > columnIndex) {
                    if (idx === 0) {
                        valueRow += `<td data-label="Factor" data-tip="${label}" tabindex="1">${label}</td>`;
                    } else {
                        const labels = ["Factor", "Average Returns (Ann. %)", "Volatility (Ann. %)", "Sharpe Ratio",
                            "Info. Ratio", "Alpha (Ann. %)", "Beta"
                        ];
                        valueRow +=
                            `<td data-label="${labels[idx]}">${(Math.round(entry[columnIndex] * 100) / 100).toFixed(2)}</td>`;
                    }
                } else {
                    console.error(`Insufficient data for entry ${idx} at column ${columnIndex}`);
                }
            });
            valueRow += '</tr>';

            table.querySelector('tbody').innerHTML += valueRow;
        }

        function changeYears(years) {
            const tableIds = {
                1: 'yearsTable1',
                5: 'yearsTable2',
                10: 'yearsTable3',
                100: 'yearsTable4'
            };

            Object.keys(tableIds).forEach(function(yearKey) {
                const table = document.getElementById(tableIds[yearKey]);
                if (parseInt(yearKey) === years) {
                    table.classList.add('d-block');
                    table.classList.remove('d-none');
                } else {
                    table.classList.add('d-none');
                    table.classList.remove('d-block');
                }
            });
        }

        document.addEventListener('click', function(event) {
            if (event.target.closest('.add-dropdown')) {
                event.preventDefault();
                addDropdown(event);
            } else if (event.target.closest('.remove-dropdown')) {
                event.preventDefault();
                removeDropdown(event);
            }
        });

        function addDropdown(event) {
            const button = event.target.closest('.add-dropdown');
            const newRow = document.createElement('div');
            newRow.className = 'row dropdown-set';
            newRow.id = `dropdown-set-${index}`;
            newRow.innerHTML = generateDropdownHTML(index);

            document.getElementById('dropdown-container').appendChild(newRow);

            button.innerHTML = '<i class="fa-solid fa-times"></i>';
            button.classList.remove('add-dropdown');
            button.classList.add('remove-dropdown');

            index++;
            initializeSelect2();
        }

        function removeDropdown(event) {
            const button = event.target.closest('.remove-dropdown');
            const setId = button.closest('.dropdown-set').id;
            const setIndex = parseInt(setId.split('-')[2]);

            document.getElementById(setId).remove();

            if (chart) {
                datesArray.splice(setIndex, 1);
                dataValues.splice(setIndex, 1);
                statsDataArray.splice(setIndex, 1);

                showTable(statsDataArray, dataValues);
            }
            plotGraph(event);
        }

        function generateDropdownHTML(index) {
            return `
            <div class="col my-1">
                <label for="">Region/Country</label>
                <select name="region" id="region_${index}" class="form-control region js-example-basic-single w-100">
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
            <div class="col my-1">
                <label for="">Theme/Factor</label>
                <select name="theme" id="theme_${index}" class="form-control theme js-example-basic-single w-100">
                    <option value="" disabled>Themes</option>
                    <option value="accruals">Accruals Theme</option>
                    <option value="debt_issuance">Debt Issuance Theme</option>
                    <option value="investment">Investment Theme</option>
                    <option value="low_leverage">Low Leverage Theme</option>
                    <option value="low_risk">Low Risk Theme</option>
                    <option value="momentum">Momentum Theme</option>
                    <option value="profit_growth">Profit Growth Theme</option>
                    <option value="profitability">Profitability Theme</option>
                    <option value="quality">Quality Theme</option>
                    <option value="seasonality">Seasonality Theme</option>
                    <option value="size">Size Theme</option>
                    <option value="short_term_reversal">Short-Term Reversal Theme</option>
                    <option value="value">Value Theme</option>
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
                    <option value="cop_atl1">Cash-based operating profits-to-lagged book assets</option>
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
                    <option value="dolvol_var_126d">Coefficient of variation for dollar trading volume</option>
                    <option value="turnover_var_126d">Coefficient of variation for share turnover</option>
                    <option value="coskew_21d">Coskewness</option>
                    <option value="prc_highprc_252d">Current price to high price over last year</option>
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
                    <option value="rmax5_rvol_21d">Highest 5 days of return scaled by volatility</option>
                    <option value="emp_gr1">Hiring rate</option>
                    <option value="iskew_capm_21d">Idiosyncratic skewness from the CAPM</option>
                    <option value="iskew_ff3_21d">Idiosyncratic skewness from the Fama-French 3-factor model</option>
                    <option value="iskew_hxz4_21d">Idiosyncratic skewness from the q-factor model</option>
                    <option value="ivol_capm_21d">Idiosyncratic volatility from the CAPM (21 days)</option>
                    <option value="ivol_capm_252d">Idiosyncratic volatility from the CAPM (252 days)</option>
                    <option value="ivol_ff3_21d">Idiosyncratic volatility from the Fama-French 3-factor model</option>
                    <option value="ivol_hxz4_21d">Idiosyncratic volatility from the q-factor model</option>
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
                    <option value="ni_inc8q">Number of consecutive quarters with earnings increases</option>
                    <option value="zero_trades_21d">Number of zero trades with turnover as tiebreaker (1 month)</option>
                    <option value="zero_trades_252d">Number of zero trades with turnover as tiebreaker (12 months)</option>
                    <option value="zero_trades_126d">Number of zero trades with turnover as tiebreaker (6 months)</option>
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
            <div class="col-md-2 my-1 d-none">
                <label for="">Data Frequency</label>
                <select name="frequency" id="frequency_${index}" class="form-control frequency js-example-basic-single w-100">
                    <option value="monthly" selected>Monthly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>
            <div class="col my-1">
                <label for="">Weighting</label>
                <select name="weight" id="weight_${index}" class="form-control weight js-example-basic-single w-100">
                    <option value="vw_cap">Capped Value Weighted (Recommended)</option>
                    <option value="vw">Value Weighted</option>
                    <option value="ew">Equal Weighted</option>
                </select>
            </div>
            <div class="col-md-1 my-1" style="align-self: center;">
                <button class="btn btn-primary plus-btn rounded rounded-pill mt-4 add-dropdown w-100"
                        style="font-weight: 200; border: 1px solid black; color: black; background: transparent;">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        `;
        }
    </script>
@endsection
