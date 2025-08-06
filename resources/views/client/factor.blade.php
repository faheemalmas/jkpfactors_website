@extends('layouts.client.index')

@section('page-css')
    <style>
        a {
            text-decoration: none;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
            color: #2f2f2f;
            text-decoration: underline;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: black !important;
            color: white
        }

        option {
            font-size: 14px;
            font-weight: 100;
        }

        label {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif !important;
        }

        .factor-data-text {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <section style="">
        <div class="container">
            <div class="intro-excerpt px-3">
                {{-- <h1 class="text-dark text-center">Factor Returns</h1> --}}
                {{-- <p class="text-center">
                    Select and download the factors returns below*
                </p> --}}

                {{-- <div class="col-12">
                        <h3 class="text-center">
                            Select the all factors below and download related data from there.
                        </h3>
                    </div> --}}
                {{-- <form action="{{ route('factors.download-file') }}" class="row" method="POST"> --}}
                <form action="#" class="row" method="POST" onsubmit="download(event)">
                    @csrf
                    <div class="col-md-6 my-4">
                        <label for="">Region/Country</label>
                        <select name="country" id="region" class="form-control js-example-basic-single w-100">
                            <option value="" disabled>Regions</option>
                            <option value="all_regions">All Regions</option>
                            <option value="developed">Developed Markets</option>
                            <option value="emerging">Emerging Markets</option>
                            <option value="frontier">Frontier Markets</option>
                            <option value="" disabled>Countries</option>
                            <option value="all_countries">All Countries</option>
                            <option value="usa" selected>United states</option>
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
                    <div class="col-md-6 my-4">
                        <label for="">Market/Theme/Factor*</label>
                        <select name="themes" id="theme" class="form-control js-example-basic-single w-100">
                            <option value="" disabled>Market</option>
                            <option value="mkt">Market</option>

                            <option value="" disabled>Themes</option>
                            <option value="all_themes">All 13 Themes</option>
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
                            <option value="all_factors">All 153 Factors</option>
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
                            <option value="iskew_ff3_21d">Idiosyncratic skewness from the Fama-French 3-factor model
                            </option>
                            <option value="iskew_hxz4_21d">Idiosyncratic skewness from the q-factor model</option>
                            <option value="ivol_capm_21d">Idiosyncratic volatility from the CAPM (21 days)</option>
                            <option value="ivol_capm_252d">Idiosyncratic volatility from the CAPM (252 days)</option>
                            <option value="ivol_ff3_21d">Idiosyncratic volatility from the Fama-French 3-factor model
                            </option>
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
                            <option value="zero_trades_21d">Number of zero trades with turnover as tiebreaker (1 month)
                            </option>
                            <option value="zero_trades_252d">Number of zero trades with turnover as tiebreaker (12 months)
                            </option>
                            <option value="zero_trades_126d">Number of zero trades with turnover as tiebreaker (6 months)
                            </option>
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
                    <div class="col-md-6 my-4">
                        <label for="">Data Frequency</label>
                        <select name="frequency" id="frequency" class="form-control js-example-basic-single w-100">
                            <option value="monthly" selected>Monthly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                    <div class="col-md-6 my-4">
                        <label for="weight">Weighting</label>
                        <select name="weight" id="weight" class="form-control js-example-basic-single w-100">
                            <option value="vw_cap">Capped Value Weighted (Recommended)</option>
                            <option value="vw">Value Weighted</option>
                            <option value="ew">Equal Weighted</option>
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <span type="button" onclick="updateURLAndBookmark()">Click <a href="#">here</a> to
                            bookmark the selection</span>
                    </div>
                    <div class="col-12 d-flex justify-content-center my-4">
                        <button type="submit" class="btn rounded rounded-2"
                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;">
                            <span id="text" class="">Download</span>
                            <div class="spinner-border d-none" role="status" id="spin">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                        <button type="reset" onclick="resetForm()" class="btn ms-3 px-5 rounded rounded-2"
                            style="font-weight: 200;border: 1px solid black; color: black; background: transparent;">Reset</button>
                    </div>
                    <div style="margin-top: 4rem;">
                        <p class="factor-data-text">
                            *The return data is for characteristic-managed portfolios, or "factors," from around the
                            world. It includes factors for 153 characteristics in 13 themes, using data from 93
                            countries* and four regions, based on the construction in Jensen, Kelly, and Pedersen
                            (2023). Return series for each of the 13 themes are equal-weighted averages of the factors that fall under that theme. The data is available at the daily and monthly frequencies with equal weighting,
                            value weighting, or capped value weighting (default). Returns are excess returns in USD. For
                            details about the factor construction, see <a class="text-dark"
                                href="https://jkpfactors.s3.amazonaws.com/documents/Documentation.pdf"
                                target="_blank">documentation</a>.

                        </p>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            populateSelectOptionsFromURL();
        });

        function updateURLAndBookmark() {
            const region = document.getElementById('region').value;
            const theme = document.getElementById('theme').value;
            const frequency = document.getElementById('frequency').value;
            const weight = document.getElementById('weight').value;

            const baseUrl = window.location.origin + window.location.pathname;
            const newUrl = `${baseUrl}?country=${region}&theme=${theme}&frequency=${frequency}&weight=${weight}`;

            window.history.pushState({
                path: newUrl
            }, '', newUrl);


            if (window.sidebar && window.sidebar.addPanel) {
                window.sidebar.addPanel(document.title, newUrl, "");
            } else if (window.external && ('AddFavorite' in window.external)) {
                window.external.AddFavorite(newUrl, document.title);
            } else {
                alert('Press Ctrl+D (Cmd+D for Mac) to bookmark the selected factor.');
            }

            console.log(newUrl);
        }

        function resetForm() {
            document.getElementById('region').value = "usa";
            document.getElementById('theme').value = "all_themes";
            document.getElementById('frequency').value = "monthly";
            document.getElementById('weight').value = "vw_cap";

            $('.js-example-basic-single').trigger('change');

            const baseUrl = window.location.origin + window.location.pathname;
            const newUrl = `${baseUrl}?country=usa&theme=all_themes&frequency=monthly&weight=vw_cap`;

            window.history.pushState({
                path: newUrl
            }, '', newUrl);

            document.getElementById('generated-url').value = newUrl;
        }

        function populateSelectOptionsFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const region = urlParams.get('country');
            const theme = urlParams.get('theme');
            const frequency = urlParams.get('frequency');
            const weight = urlParams.get('weight');

            if (region) {
                document.getElementById('region').value = region;
            }
            if (theme) {
                document.getElementById('theme').value = theme;
            }
            if (frequency) {
                document.getElementById('frequency').value = frequency;
            }
            if (weight) {
                document.getElementById('weight').value = weight;
            }

            $('.js-example-basic-single').trigger('change');
        }
    </script>

    <script>
        function download(event) {
            event.preventDefault();
            let region = document.getElementById("region").value;
            document.getElementById("spin").classList.toggle("d-none");
            document.getElementById("text").classList.toggle("d-none");
            let theme = document.getElementById("theme").value;
            let frequency = document.getElementById("frequency").value;
            let weight = document.getElementById("weight").value;

            let url =
                `https://jkpfactors.s3.amazonaws.com/public/%5B${region}%5D_%5B${theme}%5D_%5B${frequency}%5D_%5B${weight}%5D.zip`;

            window.location.href = url;
            document.getElementById("spin").classList.toggle("d-none");
            document.getElementById("text").classList.toggle("d-none");
        }
    </script>
@endsection
