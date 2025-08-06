@extends('layouts.client.index')

@section('page-css')
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            padding: 10px
        }



        @media screen and (max-width: 786px) {
            #btn-section {
                width: 100% !important;
            }

            .button-margin {
                margin-left: 15px;
                margin-right: 15px;
            }
        }

        .yellow-btn {
            cursor: pointer;
            border-radius: 3px;
            background-color: blanchedalmond;
            margin: 2px 0px;
            padding: 3px 6px;
            width: 100%;
            border: none;
            text-align: left;
            font-size: 15px;
            color: #212529 !important;
            align-self: stretch !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            position: relative;
        }


        .yellow-btn:hover,
        .yellow-btn:focus {
            overflow: visible;
            background-color: #FF8C02;
            color: white !important;
        }

        /*== common styles for both parts of tool tip ==*/
        .yellow-btn::before,
        .yellow-btn::after {
            left: 50%;
            opacity: 1;
            position: absolute;
            z-index: 100;
        }

        .yellow-btn:hover::before,
        .yellow-btn:focus::before,
        .yellow-btn:hover::after,
        .yellow-btn:focus::after {
            opacity: 1 !important;
            transform: scale(1) translateY(0) translateX(-50%) !important;
            z-index: 100 !important;
            overflow: visible !important;
        }


        .yellow-btn::before {
            border-style: solid;
            border-width: 1em 0.75em 0 0.75em;
            border-color: black transparent transparent transparent;
            bottom: 100%;
            content: "";
            margin-left: -0.5em;
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26), opacity .65s .5s;
            transform: scale(.6) translateY(-90%);
        }

        .yellow-btn:hover::before,
        .yellow-btn:focus::before {
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
        }

        .yellow-btn::after {
            background: black;
            border-radius: .25em;
            bottom: 180%;
            color: white;
            content: attr(data-tip);
            /* margin-left: -0.5em; */
            padding: 1em;
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
            transform: scale(.6) translateY(50%) translateX(50%) !important;
        }

        .yellow-btn:hover::after,
        .yellow-btn:focus::after {
            transition: all .65s cubic-bezier(.84, -0.18, .31, 1.26);
        }

        @media (max-width: 760px) {
            .yellow-btn::after {
                font-size: .75em;
                margin-left: -5em;
                /* width: 10em; */
            }
        }

        .text-14 {
            font-size: 14px !important;
        }
    </style>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
@endsection
@section('content')
    <section>
        {{-- <div class="form-check form-switch">
            <label class="form-check-label" for="toggleUrlSwitch">First Text</label>
            <input class="form-check-input" type="checkbox" id="toggleUrlSwitch" onchange="toggleUrl()">
            <label class="form-check-label" for="toggleUrlSwitch">Second Text</label>
        </div> --}}
        <div class="container mt-3">
            <p class="main-container-text text-center">
                Monthly stock-level characteristics data can be downloaded from WRDS.
            </p>
            <div class="row button-margin">
                <a href="https://wrds-www.wharton.upenn.edu/login/?next=/pages/get-data/contributed-data-forms/global-factor-data/"
                    target="_blank" class="btn rounded rounded-2 my-2 mx-auto"
                    style="font-weight: 200;border: 1px solid black; color: black; background: transparent; width: 26.5rem; padding:10px 0px;">WRDS
                    JKP Stock
                    Characteristics via web interface</a>
                <a href="https://jkpfactors.com/guide-python" class="btn rounded rounded-2 my-2 mx-auto"
                    style="font-weight: 200;border: 1px solid black; color: black; background: transparent; width: 26.5rem; padding:10px 0px;">WRDS
                    JKP Stock
                    Characteristics via Python</a>
                <a href="https://jkpfactors.com/guide-R" class="btn rounded rounded-2 my-2 mx-auto"
                    style="font-weight: 200;border: 1px solid black; color: black; background: transparent; width: 26.5rem; padding:10px 0px;">WRDS
                    JKP Stock
                    Characteristics via R</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container text-center mt-3 main-container-text">
            <div id="hide-show" onclick="toggleVisibility()">
                <span class="raleway-font main-container-text text-center">Below is the list of</span> <span
                    class="raleway-font hide-show main-container-text">153 Characteristics in “Is There a
                    Replication Crisis in Finance?” Journal of Finance (2023)</span>
                <div class="raleway-font main-container-text text-center">Click on the name(s) to see performance of the
                    corresponding monthly capped value weighted factor(s) in US over time.</div>
            </div>
        </div>

    </section>

    <div id="loader" class="text-center d-none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <section id="btn-section" class="w-75 row m-auto my-3">
        <div class="col-12 mb-4 m-auto">
            <input type="text" id="searchInput" class="form-control mr-sm-5"
                style="min-width:100%;margin-top:10px;font-size:14px;" placeholder="Type to search..."
                onkeyup="searchFunction()">
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('capex_abn')" data-tip="Abnormal corporate investment"
                tabindex="1">
                Abnormal corporate investment
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('z_score')" data-tip="Altman Z-score" tabindex="1">
                Altman Z-score
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ami_126d')" data-tip="Amihud Measure" tabindex="1">
                Amihud Measure
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('at_gr1')" data-tip="Asset Growth" tabindex="1">
                Asset Growth
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('tangibility')" data-tip="Asset tangibility"
                tabindex="1">
                Asset tangibility
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sale_bev')" data-tip="Asset turnover" tabindex="1">
                Asset turnover
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('at_me')" data-tip="Assets-to-market" tabindex="1">
                Assets-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('at_be')" data-tip="Book leverage" tabindex="1">
                Book leverage
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('bev_mev')" data-tip="Book-to-market enterprise value"
                tabindex="1">
                Book-to-market enterprise value
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('be_me')" data-tip="Book-to-market equity" tabindex="1">
                Book-to-market equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('capx_gr1')" data-tip="CAPEX growth (1 year)"
                tabindex="1">
                CAPEX growth (1 year)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('capx_gr2')" data-tip="CAPEX growth (2 years)"
                tabindex="1">
                CAPEX growth (2 years)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('capx_gr3')" data-tip="CAPEX growth (3 years)"
                tabindex="1">
                CAPEX growth (3 years)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('at_turnover')" data-tip="Capital turnover"
                tabindex="1">
                Capital turnover
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ocfq_saleq_std')" data-tip="Cash flow volatility"
                tabindex="1">
                Cash flow volatility
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('cop_at')"
                data-tip="Cash-based operating profits-to-book assets" tabindex="1">
                Cash-based operating profits-to-book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('cop_atl1')"
                data-tip="Cash-based operating profits-to-lagged book assets" tabindex="1">
                Cash-based operating profits-to-lagged book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('cash_at')" data-tip="Cash-to-assets" tabindex="1">
                Cash-to-assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dgp_dsale')"
                data-tip="Change gross margin minus change sales" tabindex="1">
                Change gross margin minus change sales
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('be_gr1a')" data-tip="Change in common equity"
                tabindex="1">
                Change in common equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('coa_gr1a')"
                data-tip="Change in current operating assets" tabindex="1">
                Change in current operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('col_gr1a')"
                data-tip="Change in current operating liabilities" tabindex="1">
                Change in current operating liabilities
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('cowc_gr1a')"
                data-tip="Change in current operating working capital" tabindex="1">
                Change in current operating working capital
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('fnl_gr1a')" data-tip="Change in financial liabilities"
                tabindex="1">
                Change in financial liabilities
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('lti_gr1a')" data-tip="Change in long-term investments"
                tabindex="1">
                Change in long-term investments
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('lnoa_gr1a')"
                data-tip="Change in long-term net operating assets" tabindex="1">
                Change in long-term net operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('nfna_gr1a')" data-tip="Change in net financial assets"
                tabindex="1">
                Change in net financial assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('nncoa_gr1a')"
                data-tip="Change in net noncurrent operating assets" tabindex="1">
                Change in net noncurrent operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('noa_gr1a')" data-tip="Change in net operating assets"
                tabindex="1">
                Change in net operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ncoa_gr1a')"
                data-tip="Change in noncurrent operating assets" tabindex="1">
                Change in noncurrent operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ncol_gr1a')"
                data-tip="Change in noncurrent operating liabilities" tabindex="1">
                Change in noncurrent operating liabilities
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ocf_at_chg1')"
                data-tip="Change in operating cash flow to assets" tabindex="1">
                Change in operating cash flow to assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('niq_at_chg1')"
                data-tip="Change in quarterly return on assets" tabindex="1">
                Change in quarterly return on assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('niq_be_chg1')"
                data-tip="Change in quarterly return on equity" tabindex="1">
                Change in quarterly return on equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sti_gr1a')" data-tip="Change in short-term investments"
                tabindex="1">
                Change in short-term investments
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ppeinv_gr1a')" data-tip="Change PPE and Inventory"
                tabindex="1">
                Change PPE and Inventory
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dsale_dinv')"
                data-tip="Change sales minus change Inventory" tabindex="1">
                Change sales minus change Inventory
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dsale_drec')"
                data-tip="Change sales minus change receivables" tabindex="1">
                Change sales minus change receivables
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dsale_dsga')" data-tip="Change sales minus change SG&A"
                tabindex="1">
                Change sales minus change SG&A
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dolvol_var_126d')"
                data-tip="Coefficient of variation for dollar trading volume" tabindex="1">
                Coefficient of variation for dollar trading volume
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('turnover_var_126d')"
                data-tip="Coefficient of variation for share turnover" tabindex="1">
                Coefficient of variation for share turnover
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('coskew_21d')" data-tip="Coskewness" tabindex="1">
                Coskewness
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('prc_highprc_252d')"
                data-tip="Current price to high price over last year" tabindex="1">
                Current price to high price over last year
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('debt_me')" data-tip="Debt-to-market" tabindex="1">
                Debt-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('beta_dimson_21d')" data-tip="Dimson beta"
                tabindex="1">
                Dimson beta
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('div12m_me')" data-tip="Dividend yield" tabindex="1">
                Dividend yield
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dolvol_126d')" data-tip="Dollar trading volume"
                tabindex="1">
                Dollar trading volume
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('betadown_252d')" data-tip="Downside beta"
                tabindex="1">
                Downside beta
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ni_ar1')" data-tip="Earnings persistence"
                tabindex="1">
                Earnings persistence
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('earnings_variability')" data-tip="Earnings variability"
                tabindex="1">
                Earnings variability
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ni_ivol')" data-tip="Earnings volatility"
                tabindex="1">
                Earnings volatility
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ni_me')" data-tip="Earnings-to-price" tabindex="1">
                Earnings-to-price
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ebitda_mev')"
                data-tip="Ebitda-to-market enterprise value" tabindex="1">
                Ebitda-to-market enterprise value
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('eq_dur')" data-tip="Equity duration" tabindex="1">
                Equity duration
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('eqnpo_12m')" data-tip="Equity net payout"
                tabindex="1">
                Equity net payout
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('age')" data-tip="Firm age" tabindex="1">
                Firm age
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('betabab_1260d')"
                data-tip="Frazzini-Pedersen market beta" tabindex="1">
                Frazzini-Pedersen market beta
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('fcf_me')" data-tip="Free cash flow-to-price"
                tabindex="1">
                Free cash flow-to-price
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('gp_at')" data-tip="Gross profits-to-assets"
                tabindex="1">
                Gross profits-to-assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('gp_atl1')" data-tip="Gross profits-to-lagged assets"
                tabindex="1">
                Gross profits-to-lagged assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('debt_gr3')" data-tip="Growth in book debt (3 years)"
                tabindex="1">
                Growth in book debt (3 years)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rmax5_21d')" data-tip="Highest 5 days of return"
                tabindex="1">
                Highest 5 days of return
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rmax5_rvol_21d')"
                data-tip="Highest 5 days of return scaled by volatility" tabindex="1">
                Highest 5 days of return scaled by volatility
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('emp_gr1')" data-tip="Hiring rate" tabindex="1">
                Hiring rate
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('iskew_capm_21d')"
                data-tip="Idiosyncratic skewness from the CAPM" tabindex="1">
                Idiosyncratic skewness from the CAPM
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('iskew_ff3_21d')"
                data-tip="Idiosyncratic skewness from the Fama-French 3-factor model" tabindex="1">
                Idiosyncratic skewness from the Fama-French 3-factor model
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('iskew_hxz4_21d')"
                data-tip="Idiosyncratic skewness from the q-factor model" tabindex="1">
                Idiosyncratic skewness from the q-factor model
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ivol_capm_21d')"
                data-tip="Idiosyncratic volatility from the CAPM (21 days)" tabindex="1">
                Idiosyncratic volatility from the CAPM (21 days)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ivol_capm_252d')"
                data-tip="Idiosyncratic volatility from the CAPM (252 days)" tabindex="1">
                Idiosyncratic volatility from the CAPM (252 days)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ivol_ff3_21d')"
                data-tip="Idiosyncratic volatility from the Fama-French 3-factor model" tabindex="1">
                Idiosyncratic volatility from the Fama-French 3-factor model
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ivol_hxz4_21d')"
                data-tip="Idiosyncratic volatility from the q-factor model" tabindex="1">
                Idiosyncratic volatility from the q-factor model
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ival_me')" data-tip="Intrinsic value-to-market"
                tabindex="1">
                Intrinsic value-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('inv_gr1a')" data-tip="Inventory change"
                tabindex="1">
                Inventory change
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('inv_gr1')" data-tip="Inventory growth" tabindex="1">
                Inventory growth
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('kz_index')" data-tip="Kaplan-Zingales index"
                tabindex="1">
                Kaplan-Zingales index
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sale_emp_gr1')" data-tip="Labor force efficiency"
                tabindex="1">
                Labor force efficiency
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('aliq_at')" data-tip="Liquidity of book assets"
                tabindex="1">
                Liquidity of book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('aliq_mat')" data-tip="Liquidity of market assets"
                tabindex="1">
                Liquidity of market assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_60_12')" data-tip="Long-term reversal"
                tabindex="1">
                Long-term reversal
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('beta_60m')" data-tip="Market Beta" tabindex="1">
                Market Beta
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('corr_1260d')" data-tip="Market correlation"
                tabindex="1">
                Market correlation
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('market_equity')" data-tip="Market Equity"
                tabindex="1">
                Market Equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rmax1_21d')" data-tip="Maximum daily return"
                tabindex="1">
                Maximum daily return
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('mispricing_mgmt')"
                data-tip="Mispricing factor: Management" tabindex="1">
                Mispricing factor: Management
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('mispricing_perf')"
                data-tip="Mispricing factor: Performance" tabindex="1">
                Mispricing factor: Performance
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('dbnetis_at')" data-tip="Net debt issuance"
                tabindex="1">
                Net debt issuance
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('netdebt_me')" data-tip="Net debt-to-price"
                tabindex="1">
                Net debt-to-price
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('eqnetis_at')" data-tip="Net equity issuance"
                tabindex="1">
                Net equity issuance
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('noa_at')" data-tip="Net operating assets"
                tabindex="1">
                Net operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('eqnpo_me')" data-tip="Net payout yield"
                tabindex="1">
                Net payout yield
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('chcsho_12m')" data-tip="Net stock issues"
                tabindex="1">
                Net stock issues
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('netis_at')" data-tip="Net total issuance"
                tabindex="1">
                Net total issuance
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ni_inc8q')"
                data-tip="Number of consecutive quarters with earnings increases" tabindex="1">
                Number of consecutive quarters with earnings increases
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('zero_trades_21d')"
                data-tip="Number of zero trades with turnover as tiebreaker (1 month)" tabindex="1">
                Number of zero trades with turnover as tiebreaker (1 month)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('zero_trades_252d')"
                data-tip="Number of zero trades with turnover as tiebreaker (12 months)" tabindex="1">
                Number of zero trades with turnover as tiebreaker (12 months)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('zero_trades_126d')"
                data-tip="Number of zero trades with turnover as tiebreaker (6 months)" tabindex="1">
                Number of zero trades with turnover as tiebreaker (6 months)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('o_score')" data-tip="Ohlson O-score" tabindex="1">
                Ohlson O-score
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('oaccruals_at')" data-tip="Operating accruals"
                tabindex="1">
                Operating accruals
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ocf_at')" data-tip="Operating cash flow to assets"
                tabindex="1">
                Operating cash flow to assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ocf_me')" data-tip="Operating cash flow-to-market"
                tabindex="1">
                Operating cash flow-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('opex_at')" data-tip="Operating leverage"
                tabindex="1">
                Operating leverage
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('op_at')" data-tip="Operating profits-to-book assets"
                tabindex="1">
                Operating profits-to-book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ope_be')" data-tip="Operating profits-to-book equity"
                tabindex="1">
                Operating profits-to-book equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('op_atl1')"
                data-tip="Operating profits-to-lagged book assets" tabindex="1">
                Operating profits-to-lagged book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ope_bel1')"
                data-tip="Operating profits-to-lagged book equity" tabindex="1">
                Operating profits-to-lagged book equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('eqpo_me')" data-tip="Payout yield" tabindex="1">
                Payout yield
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('oaccruals_ni')" data-tip="Percent operating accruals"
                tabindex="1">
                Percent operating accruals
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('taccruals_ni')" data-tip="Percent total accruals"
                tabindex="1">
                Percent total accruals
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('f_score')" data-tip="Pitroski F-score" tabindex="1">
                Pitroski F-score
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_12_1')" data-tip="Price momentum t-12 to t-1"
                tabindex="1">
                Price momentum t-12 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_12_7')" data-tip="Price momentum t-12 to t-7"
                tabindex="1">
                Price momentum t-12 to t-7
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_3_1')" data-tip="Price momentum t-3 to t-1"
                tabindex="1">
                Price momentum t-3 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_6_1')" data-tip="Price momentum t-6 to t-1"
                tabindex="1">
                Price momentum t-6 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_9_1')" data-tip="Price momentum t-9 to t-1"
                tabindex="1">
                Price momentum t-9 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('prc')" data-tip="Price per share" tabindex="1">
                Price per share
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ebit_sale')" data-tip="Profit margin" tabindex="1">
                Profit margin
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('qmj')" data-tip="Quality minus Junk: Composite"
                tabindex="1">
                Quality minus Junk: Composite
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('qmj_growth')" data-tip="Quality minus Junk: Growth"
                tabindex="1">
                Quality minus Junk: Growth
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('qmj_prof')"
                data-tip="Quality minus Junk: Profitability" tabindex="1">
                Quality minus Junk: Profitability
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('qmj_safety')" data-tip="Quality minus Junk: Safety"
                tabindex="1">
                Quality minus Junk: Safety
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('niq_at')" data-tip="Quarterly return on assets"
                tabindex="1">
                Quarterly return on assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('niq_be')" data-tip="Quarterly return on equity"
                tabindex="1">
                Quarterly return on equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rd5_at')" data-tip="R&D capital-to-book assets"
                tabindex="1">
                R&D capital-to-book assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rd_me')" data-tip="R&D-to-market" tabindex="1">
                R&D-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rd_sale')" data-tip="R&D-to-sales" tabindex="1">
                R&D-to-sales
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('resff3_12_1')" data-tip="Residual momentum t-12 to t-1"
                tabindex="1">
                Residual momentum t-12 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('resff3_6_1')" data-tip="Residual momentum t-6 to t-1"
                tabindex="1">
                Residual momentum t-6 to t-1
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ni_be')" data-tip="Return on equity" tabindex="1">
                Return on equity
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ebit_bev')" data-tip="Return on net operating assets"
                tabindex="1">
                Return on net operating assets
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rvol_21d')" data-tip="Return volatility"
                tabindex="1">
                Return volatility
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('saleq_gr1')" data-tip="Sales Growth (1 quarter)"
                tabindex="1">
                Sales Growth (1 quarter)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sale_gr1')" data-tip="Sales Growth (1 year)"
                tabindex="1">
                Sales Growth (1 year)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sale_gr3')" data-tip="Sales Growth (3 years)"
                tabindex="1">
                Sales Growth (3 years)
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('sale_me')" data-tip="Sales-to-market" tabindex="1">
                Sales-to-market
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('turnover_126d')" data-tip="Share turnover"
                tabindex="1">
                Share turnover
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('ret_1_0')" data-tip="Short-term reversal"
                tabindex="1">
                Short-term reversal
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('niq_su')" data-tip="Standardized earnings surprise"
                tabindex="1">
                Standardized earnings surprise
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('saleq_su')" data-tip="Standardized Revenue surprise"
                tabindex="1">
                Standardized Revenue surprise
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('tax_gr1a')" data-tip="Tax expense surprise"
                tabindex="1">
                Tax expense surprise
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('pi_nix')" data-tip="Taxable income-to-book income"
                tabindex="1">
                Taxable income-to-book income
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('bidaskhl_21d')" data-tip="The high-low bid-ask spread"
                tabindex="1">
                The high-low bid-ask spread
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('taccruals_at')" data-tip="Total accruals"
                tabindex="1">
                Total accruals
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('rskew_21d')" data-tip="Total skewness" tabindex="1">
                Total skewness
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_1_1an')" data-tip="Year 1-lagged return, annual"
                tabindex="1">
                Year 1-lagged return, annual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_1_1na')"
                data-tip="Year 1-lagged return, nonannual" tabindex="1">
                Year 1-lagged return, nonannual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_2_5an')"
                data-tip="Years 2-5 lagged returns, annual" tabindex="1">
                Years 2-5 lagged returns, annual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_2_5na')"
                data-tip="Years 2-5 lagged returns, nonannual" tabindex="1">
                Years 2-5 lagged returns, nonannual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_6_10an')"
                data-tip="Years 6-10 lagged returns, annual" tabindex="1">
                Years 6-10 lagged returns, annual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_6_10na')"
                data-tip="Years 6-10 lagged returns, nonannual" tabindex="1">
                Years 6-10 lagged returns, nonannual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_11_15an')"
                data-tip="Years 11-15 lagged returns, annual" tabindex="1">
                Years 11-15 lagged returns, annual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_11_15na')"
                data-tip="Years 11-15 lagged returns, nonannual" tabindex="1">
                Years 11-15 lagged returns, nonannual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_16_20an')"
                data-tip="Years 16-20 lagged returns, annual" tabindex="1">
                Years 16-20 lagged returns, annual
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 wrap">
            <div class="yellow-btn tool" onclick="getFileContent('seas_16_20na')"
                data-tip="Years 16-20 lagged returns, nonannual" tabindex="1">
                Years 16-20 lagged returns, nonannual
            </div>
        </div>

    </section>

    <section id="main-chart" class="d-none">
        <div class="mb-5 rounded" style="width: 80%; margin: auto;">
            <div class="row align-items-center">
                <div class="col-md-12 align-self-stretch">
                    <div id="container" style="width: 100%;height:400px;"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

    <script>
        let chart;
        let startDate;
        let selectedUrl = `/get-graph-data`;

        function toggleUrl() {
            const toggleSwitch = document.getElementById('toggleUrlSwitch');
            if (toggleSwitch.checked) {
                selectedUrl = `/get-alpha-graph-data`;
            } else {
                selectedUrl = `/get-graph-data`;
            }
        }

        function searchFunction() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const section = document.getElementById('btn-section');
            const buttons = section.getElementsByClassName('yellow-btn');

            for (let i = 0; i < buttons.length; i++) {
                const textValue = buttons[i].textContent || buttons[i].innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    buttons[i].parentElement.style.display = "";
                } else {
                    buttons[i].parentElement.style.display = "none";
                }
            }
        }

        function getFileContent(e) {
            var section = document.getElementById('btn-section');
            section.style.display = 'none';
            document.getElementById('loader').classList.remove("d-none");
            document.getElementById('main-chart').classList.remove("d-none");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    method: "POST",
                    url: selectedUrl,
                    data: {
                        "region": 'usa',
                        "theme": e,
                        "frequency": 'monthly',
                        "weight": 'vw_cap',
                    }
                })
                .done(function(response) {
                    console.log(response); // Log the response to see its structure
                    if (response && response.graphData && response.graphData.data) {
                        plotGraph(response.graphData);
                    } else {
                        alert('Invalid response structure.');
                        document.getElementById('loader').classList.add("d-none");
                    }
                }).fail(function(error) {
                    alert('Failed to retrieve data.');
                    document.getElementById('loader').classList.add("d-none");
                }).always(function() {
                    document.getElementById('loader').classList.add("d-none");
                });
        }

        function plotGraph(graphData) {
            if (!chart) {
                initializeChart(graphData);
            } else {
                addSeries(graphData);
            }
        }

        function initializeChart(graphData) {
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
                    yAxis: {
                        labels: {
                            formatter: function() {
                                return this.value;
                            }
                        },
                        startOnTick: false,
                        endOnTick: false,
                    },
                    navigator: {
                        enabled: false,
                        adaptToUpdatedData: false,
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
                    tooltip: {
                        shared: true,
                        crosshairs: true,
                        pointFormatter: function() {
                            return `${this.series.name}: ${(this.y).toFixed(2)}<br>`;
                        },
                        valueDecimals: 2,
                    },
                    legend: {
                        enabled: true,
                    },
                    series: [], // Start with no series, add dynamically
                });

                window.addEventListener('resize', function() {
                    chart.reflow();
                });

                addSeries(graphData);
            } else {
                console.error("Chart container not found");
            }
        }

        function addSeries(graphData) {
            if (!graphData || !graphData.data || !graphData.data.dates || !graphData.data.values) {
                console.error('Invalid response structure:', graphData);
                return;
            }

            const dates = graphData.data.dates.map(date => Date.parse(date));
            const values = graphData.data.values;

            const cumulativeData = values.map((value, i) => [dates[i], value]);

            const seriesData = getModifiedData(cumulativeData, dates[0]);

            chart.addSeries({
                name: graphData.label,
                data: seriesData,
                type: 'line',
                tooltip: {
                    valueDecimals: 2
                },
                originalData: cumulativeData // Store original data for recalculation
            });
            chart.redraw();
            chart.rangeSelector.clickButton(1, true);
            chart.rangeSelector.clickButton(3, true);
        }

        function getModifiedData(data, min) {
            const modifiedData = data.map(point => {
                return [point[0], point[0] >= min ? point[1] : null];
            });

            const initialPointIndex = modifiedData.findIndex(point => point[0] >= min);
            if (initialPointIndex !== -1) {
                modifiedData[initialPointIndex][1] = 1;
            }

            let cumulativeSum = 0;
            for (let i = initialPointIndex; i < modifiedData.length; i++) {
                if (modifiedData[i][1] !== null) {
                    cumulativeSum += modifiedData[i][1];
                    modifiedData[i][1] = cumulativeSum;
                }
            }

            return modifiedData;
        }

        function toggleVisibility() {
            var section = document.getElementById('btn-section');

            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'flex';
            } else {
                section.style.display = 'none';
            }
        }
    </script>
@endsection
