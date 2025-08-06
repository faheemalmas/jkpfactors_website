@extends('layouts.client.index')

@section('page-css')
    <style>
        .copyButton {
            position: absolute;
            top: 1%;
            right: 20px;
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
@endsection

@section('content')
    <div class="container pt-5">
        <h1 class="">How to download JKP data from WRDS through Python</h1>
        <p>AUTHOR
            <br>
            Theis I. Jensen, Bryan Kelly, and Lasse H. Pedersen</p>
        <div class="d-flex flex-row">
            <h2>Overview</h2>
        </div>
        <p>
            This document explains how to download the data set from Is There a
            Replication Crisis in Finance by Jensen, Kelly, and Pedersen (2023,
            henceforth JKP) directly from Python. To successfully run this code you
            need a WRDS account with access to CRSP and Compustat. A viable
            alternative is to download the data directly from <a class="text-dark"
                href="https://wrds-www.wharton.upenn.edu/login/?next=/pages/get-data/contributed-data-forms/global-factor-data/"> WRDS’s web
                interface </a>
        </p>
        <div class="d-flex flex-row">
            <h2>Downloading the JKP data from WRDS</h2>
        </div>
        <h4>Step 0 - Download the relevant packages</h4>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="code-blue">import</span> wrds<br />
                            <span class="code-blue">import</span> pandas <span class="code-blue">as</span> pd
                        </code>
                    </p>
                    <div class="copyButton ">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <h4>Step 1 - Connect to WRDS</h4>
        </div>
        <p>
            The first step is to connect to the WRDS server. Run the code below to
            connect to the WRDS server.
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-y: hidden;overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code> wrds_db = wrds.Connection() </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <p>
            You will see prompts asking for your username and password. Enter your
            username and password to proceed. You may also see a prompt for creation
            of .pgpass file. Choose 'y' and proceed. Note: WRDS uses multi-factor
            authentication, so you might have to check approve the request before
            the code will successfully execute.
        </p>
        <div class="d-flex flex-row">
            <h4>Step 2 - Decide on your desired data subset</h4>
        </div>
        <p>
            The full JKP data is massive, but most people only need a subset of the
            data. Here I’ll show how to generate the data set used by JKP, except
            that I’ll only use data from developed countries.
        </p>
        <p>
            To extract developed countries, I use the “country classification.xlsx”
            available from our <a class="text-dark"
                href="https://github.com/bkelly-lab/ReplicationCrisis/blob/master/GlobalFactors/Country%20Classification.xlsx.">Github
                repository</a>
            The code below downloads this file and extracts the ISO code for the
            developed countries.
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="comment-text">
                                #downloading and extracting list of developed countries
                            </span><br />
                            countries =
                            pd.read_excel(<span><a class="code-green"
                                    href="https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Country%20Classification.xlsx">'https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Country%20Classification.xlsx'</a></span>)<br>
                            countries_rel = countries[countries[<span class="code-green">'msci_development'</span>] ==
                            <span class="code-green">'developed'</span>][<span class="code-green">'excntry'</span>].tolist()
                        </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <p>
            Next, the data set contains more than 400 stock characteristics but JKP
            only uses a subset of 153 characteristics that is used to create
            published equity factors. The list of relevant characteristics <a class="text-dark"
                href="https://github.com/bkelly-lab/ReplicationCrisis/blob/master/GlobalFactors/Factor%20Details.xlsx.">is
                here</a>
            The code below downloads this file and extracts the relevant
            characteristics.
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="comment-text">
                                #downloading and extracting list of characteristics
                            </span><br />
                            chars =
                            pd.read_excel(<span class="code-green"><a
                                    href="https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Factor%20Details.xlsx">'https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Factor%20Details.xlsx'</a></span>) <br>
                            chars_rel = chars[chars[<span class="code-green">'abr_jkp'</span>].notna()][<span
                                class="code-green">'abr_jkp'</span>].tolist()
                        </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <p>Finally, JKP relies on four screens:</p>
        <ul>
            <li>
                exch_main=1 (only use data from the main exchanges within a country)
            </li>
            <li>
                primary_sec=1 (if a firm has multiple securities outstanding, only
                retain the primary security as identified by Compustat)
            </li>
            <li>
                obs_main=1 (if CRSP and Compustat have data for the same stock, only
                retain the observation from CRSP)
            </li>
        </ul>
        <p>I’ll include these screens in the SQL query</p>
        <div class="d-flex flex-row">
            <h4>Step 3 - Extracting the data</h4>
        </div>
        <div class="d-flex flex-row">
            <h5>Extracting data from one country</h5>
        </div>
        <p>
            First, I’m going to show a simple extract of some identifying
            information, the stock’s size group, its market equity, and its return
            over the next 1 month from stocks listed in Denmark:
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="comment-text">
                                # Download JKP data from Denmark
                            </span> <br />
                            sql_query= <span class="code-green">
                                f""" <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SELECT id, eom, excntry, gvkey, permno, size_grp, me,
                                ret_exc_lead1m <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FROM
                                contrib.global_factor <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;WHERE common=1 and
                                exch_main=1 and primary_sec=1 and obs_main=1
                                and <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;excntry='DNK' <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; """
                            </span> <br />

                            data = wrds_db.raw_sql(sql_query)
                        </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">id</th>
                    <th scope="col">eom</th>
                    <th scope="col">excntry</th>
                    <th scope="col">gvkey</th>
                    <th scope="col">permno</th>
                    <th scope="col">size_grp</th>
                    <th scope="col">me</th>
                    <th scope="col">ret_exc_lead1m</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0</td>
                    <td>301555201.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>015552</td>
                    <td>None</td>
                    <td>large</td>
                    <td>632.873233</td>
                    <td>-0.125864</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>301563002.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>015630</td>
                    <td>None</td>
                    <td>small</td>
                    <td>238.626127</td>
                    <td>-0.094336</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>301563002.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>015630</td>
                    <td>None</td>
                    <td>small</td>
                    <td>238.626127</td>
                    <td>-0.094336</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>300802002.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>008020</td>
                    <td>None</td>
                    <td>large</td>
                    <td>752.215748</td>
                    <td>-0.021207</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>301560001.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>015600</td>
                    <td>None</td>
                    <td>small</td>
                    <td>262.161970</td>
                    <td>-0.056547</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>301644901.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>016449</td>
                    <td>None</td>
                    <td>large</td>
                    <td>572.112443</td>
                    <td>-0.140906</td>
                </tr>
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>59776</td>
                    <td>335097901.0</td>
                    <td>2023-04-30</td>
                    <td>DNK</td>
                    <td>350979</td>
                    <td>None</td>
                    <td>mega</td>
                    <td>14.437491</td>
                    <td>NaN</td>
                </tr>
                <tr>
                    <td>59777</td>
                    <td>335111701.0</td>
                    <td>2023-04-30</td>
                    <td>DNK</td>
                    <td>351117</td>
                    <td>None</td>
                    <td>mega</td>
                    <td>17.879868</td>
                    <td>NaN</td>
                </tr>
                <tr>
                    <td>59778</td>
                    <td>335118601.0</td>
                    <td>2023-04-30</td>
                    <td>DNK</td>
                    <td>351186</td>
                    <td>None</td>
                    <td>mega</td>
                    <td>36.533362</td>
                    <td>NaN</td>
                </tr>
                <tr>
                    <td>59779</td>
                    <td>335351301.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>353513</td>
                    <td>None</td>
                    <td>mega</td>
                    <td>33.802300</td>
                    <td>NaN</td>
                </tr>
                <tr>
                    <td>59780</td>
                    <td>335630801.0</td>
                    <td>1985-12-31</td>
                    <td>DNK</td>
                    <td>356308</td>
                    <td>None</td>
                    <td>None</td>
                    <td>NaN</td>
                    <td>NaN</td>
                </tr>
            </tbody>
        </table>
        <p>59781 rows × 8 columns</p>
        <div class="d-flex flex-row">
            <h5>Extracting data from many countries</h5>
        </div>
        <p>
            Next, I’m downloading the 153 characteristics from all developed
            countries (on my machine, this takes around 35 minutes and the data set
            is 17.3GB in csv format):
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            sql_query= <span class="code-green">
                                f""" <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SELECT id, eom, excntry, gvkey, permno, size_grp, me, {',
                                '.join(map(str, chars_rel))} <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FROM
                                contrib.global_factor <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;WHERE common=1 and
                                exch_main=1 and primary_sec=1 and obs_main=1
                                and <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;excntry in ({',
                                '.join("'" + str(item) + "'" for item in
                                countries_rel)}) <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"""
                            </span> <br />

                            data = wrds_db.raw_sql(sql_query)
                        </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <h5>Extracting data from many countries with limited RAM</h5>
        </div>
        <p>
            If your computer has limited RAM, a viable alternative is to download
            the data country-by-country and save the country-specific files to your
            local PC:
        </p>
        <div>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            for country in countries_rel: <br>
                            sql_query= <span class="code-green">
                                f""" <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SELECT id, eom, excntry, gvkey, permno, size_grp, me, {',
                                '.join(map(str, chars_rel))} <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FROM
                                contrib.global_factor <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; WHERE common=1 and
                                exch_main=1 and primary_sec=1 and obs_main=1 and <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; excntry = {"'" +
                                str(country) + "'"} <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"""</span> <br>
                            data = wrds_db.raw_sql(sql_query) <br>
                            data.to_csv(<span class="code-green">f</span>'{country}<span class="code-green">.csv</span>')
                        </code>
                    </p>
                    <div class="copyButton">
                        📋<span class="tooltip">Copied!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <h4>Notes</h4>
        </div>
        <ul>
            <li>To get data from all countries, remove the part of the “WHERE” clause that’s related to the exchange
                country.</li>
            <li>To get all columns in the data set change the select clause to “SELECT *”
            </li>
            <li>If you discover a mistake, please open an issue on our <a class="text-dark"
                    href="github.com/bkelly-lab/ReplicationCrisis">Github repo</a></li>
        </ul>
    </div>
@endsection

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.copyButton').forEach(button => {
                button.addEventListener('click', function() {
                    const codeToCopy = this.previousElementSibling.innerText;
                    navigator.clipboard.writeText(codeToCopy).then(() => {

                        const copiedTooltip = document.createElement('span');
                        copiedTooltip.textContent = 'Copied!';
                        copiedTooltip.style.position = 'absolute';
                        copiedTooltip.style.backgroundColor = 'black';
                        copiedTooltip.style.color = 'white';
                        copiedTooltip.style.borderRadius = '4px';
                        copiedTooltip.style.padding = '5px';
                        copiedTooltip.style.top = '0';
                        copiedTooltip.style.left = '50%';
                        copiedTooltip.style.transform = 'translateX(-50%)';
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
    </script>
@endsection
