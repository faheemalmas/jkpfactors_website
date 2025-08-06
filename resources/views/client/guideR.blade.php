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
        <h1>How to download JKP data from WRDS through R</h1>

        <p>
            AUTHOR
        <br>
            Theis I. Jensen, Bryan Kelly, and Lasse H. Pedersen
        </p>

        <h2>
            Overview
        </h2>

        <p>
            This document explains how to download the data set from Is There a Replication Crisis in Finance by Jensen,
            Kelly, and
            Pedersen (2023, henceforth JKP) directly from R. To successfully run this code you need a WRDS account with
            access to
            CRSP and Compustat. A viable alternative is to download the data directly from <a class="text-dark"
                href="https://wrds-www.wharton.upenn.edu/login/?next=/pages/get-data/contributed-data-forms/global-factor-data/">
                WRDS’s web interface
            </a>

        </p>

        <h2>
            Downloading the JKP data from WRDS
        </h2>

        <div>
            <h4>
                Step 0 - Download the relevant packages
            </h4>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="code-blue">library</span><span class="code-dark">(RPostgres)</span> <br>
                            <span class="code-blue">library</span><span class="code-dark">(httr)</span> <br>
                            <span class="code-blue">library</span><span class="code-dark">(readxl)</span> <br>
                            <span class="code-blue">library</span><span class="code-dark">(tidyverse)</span> <br>
                            <span class="code-blue">library</span><span class="code-dark">(data.table)</span>
                        </code>
                    </p>
                    <div class="copyButton">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>
        </div>

        <div>
            <h4>
                Step 1 - Connect to WRDS
            </h4>
            <p>
                The first step is to connect to the WRDS server. To do so, start by replacing USERNAME and PASSWORD with
                your WRDS
                username and password in the code below. Next, run the code to connect to the WRDS server. Note: WRDS
                uses multi-factor
                authentication, so you might have to check approve the request before the code will successfully
                execute.
            </p>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="code-dark">wrds <- </span><span class="code-blue">dbConnect(Postgres(),</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <span class="code-green">host=</span> <span
                                        class="code-p-green">'wrds-pgdata.wharton.upenn.edu',</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span
                                        class="code-green">port=</span> <span class="code-p-green">9737,</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span
                                        class="code-green">dbname=</span> <span class="code-p-green">'wrds',</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span
                                        class="code-green">sslmode=</span> <span class="code-p-green">'require',</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span
                                        class="code-green">user=</span> <span class="code-p-green">'USERNAME',</span> <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span
                                        class="code-green">password='</span> <span class="code-p-green">PASSWORD'</span> )
                        </code>
                    </p>
                    <div class="copyButton">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>
        </div>

        <div>
            <h4>
                Step 2 - Decide on your desired data subset
            </h4>
            <p>
                The full JKP data is massive, but most people only need a subset of the data. Here I’ll show how to
                generate the data
                set used by JKP, except that I’ll only use data from developed countries.

                To extract developed countries, I use the “country classification.xlsx” available from our <a
                    class="text-dark"
                    href="https://github.com/bkelly-lab/ReplicationCrisis/blob/master/GlobalFactors/Country%20Classification.xlsx">
                    Github
                    repository
                </a> The code below
                downloads this file and extracts the ISO code for the developed countries.
            </p>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            <span class="comment-text"># Convenience function to download excel files from Github</span>
                            <br>
                            <span class="code-dark">github_excel <- function(link)</span> {<br>
                                    <span class="code-dark">temp_file <-< /span> <span
                                                class="code-blue">tempfile</span>(<span class="code-green">fileext=</span>
                                            <span class="code-p-green">".xlsx"</span>
                                            )<br>
                                            <span class="code-dark">req <- GET</span>(link, <br>
                                                    &nbsp; &nbsp; &nbsp; <span class="code-blue">authenticate</span>(<span
                                                        class="code-blue">Sys.getenv</span>( <span
                                                        class="code-p-green">"GITHUB_PAT"</span> ), "" ),<br>
                                                    &nbsp; &nbsp; &nbsp; write_disk(<span
                                                        class="code-green">path</span>=temp_file))<br>
                                                    data <- readxl:: <span class="code-blue">read_excel</span> (temp_file)
                                            <br>
                                            <span class="code-blue">unlink</span>(temp_file)<br>
                                            <span class="code-blue">return</span>(data)<br>
                                            }<br> <br>
                                            <span class="comment-text">
                                                # Download country classification file
                                            </span>
                                            <br>
                                            link <- <span class="code-green"><a class="code-green"
                                                    href="https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Country%20Classification.xlsx">"https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Country%20Classification.xlsx"</a></span>
                                    <span class="comment-text">
                                        # Notice I'm using the 'raw' rather than 'blob' URL
                                    </span>
                                    <br>
                                    countries <- link |> <span class="code-blue">github_excel</span>() <br> <br>
                                        <span class="comment-text">
                                            # Extract developed countries
                                        </span>
                                        <br>
                                        (countries_rel <- countries |> <br>
                                            &nbsp; &nbsp; <span class="code-blue">filter</span>(msci_development==<span
                                                class="code-green">"developed</span>") |> <br>
                                            &nbsp; &nbsp; <span class="code-blue">pull</span>(excntry))
                        </code>
                    </p>
                    <div class="copyButton ">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>
            <p>
                [1] "USA" "JPN" "HKG" "GBR" "CAN" "AUS" "DEU" "FRA" "SWE" "CHE" "SGP" "ITA"
                [13] "ESP" "ISR" "NLD" "NOR" "BEL" "DNK" "FIN" "NZL" "AUT" "IRL" "PRT"
            </p>
            <p>
                Next, the data set contains more than 400 stock characteristics but JKP only uses a subset of 153
                characteristics that
                is used to create published equity factors. The list of relevant characteristics is here <a
                    class="text-dark"
                    href="https://github.com/bkelly-lab/ReplicationCrisis/blob/master/GlobalFactors/Factor%20Details.xlsx">
                    characteristics is here
                </a>
                The code below
                downloads this file and extracts the relevant characteristics.
            </p>

            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                                <span class="comment-text"># Extract the factor details files</span> <br>

                            link <- <span class="code-green"><a class="code-green"
                                    href="https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Factor%20Details.xlsx">"https://github.com/bkelly-lab/ReplicationCrisis/raw/master/GlobalFactors/Factor%20Details.xlsx"</a></span>
                                <br>
                                chars <- link |> <span class="code-blue">github_excel</span>()<br> <br>
                                    <span class="comment-text">
                                        # Extract the relevant characteristics
                                    </span>
                                    <br>
                                    chars_rel <- chars |><br>
                                        &nbsp; &nbsp; <span class="code-blue">filter</span>(!<span
                                            class="code-blue">is.na</span>(abr_jkp)) |><br>
                                        &nbsp; &nbsp; <span class="code-blue">pull</span>(abr_jkp)
                        </code>
                    </p>
                    <div class="copyButton ">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>

            <p>
                Finally, JKP relies on four screens:
            </p>

            <ul>
                <li>common=1 (only use common stocks)</li>
                <li>exch_main=1 (only use data from the main exchanges within a country)</li>
                <li>primary_sec=1 (if a firm has multiple securities outstanding, only retain the primary security as
                    identified by
                    Compustat)</li>
                <li>obs_main=1 (if CRSP and Compustat have data for the same stock, only retain the observation from
                    CRSP)</li>
            </ul>

            <p>
                I’ll include these screens in the SQL query
            </p>
        </div>

        <div>
            <h4>
                Step 3 - Extracting the data
            </h4>
            <h4>
                Extracting data from one country
            </h4>
            <p>
                First, I’m going to show a simple extract of some identifying information, the stock’s size group, its
                market equity,
                and its return over the next 1 month from stocks listed in Denmark:
            </p>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                                <span class="comment-text"># Convenience function to fetch data from WRDS</span> <br>

                            <span class="code-dark">wrds_fetch <- function(wrds, sql_query,</span> <span
                                        class="code-green">n=</span>-<span class="code-red">1</span>){ <br>
                                    &nbsp; &nbsp; res <- <span class="code-blue">dbSendQuery</span>(wrds, sql_query) <br>
                            &nbsp; &nbsp; data <- <span class="code-blue">dbFetch</span>(res, n=n) <br>
                                &nbsp; &nbsp; <span class="code-blue">dbClearResult</span>(res) <br>
                                &nbsp; &nbsp; <span class="code-blue">return</span>(data) <br>
                                }<br><br>
                                <span class="comment-text">
                                    # Download JKP data from Denmark
                                </span><br>
                                sql_query <- <span class="code-blue">paste0</span>( <br>
                                    <span class="code-green">
                                        &nbsp; &nbsp; " SELECT id, eom, excntry, gvkey, permno, size_grp, me, ret_exc_lead1m
                                        <br>
                                        &nbsp; &nbsp; &nbsp; &nbsp; FROM contrib.global_factor <br>
                                        &nbsp; &nbsp; &nbsp; &nbsp; WHERE common=1 and exch_main=1 and primary_sec=1 and
                                        obs_main=1 and
                                        <br>
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;excntry='DNK';" </span><br>
                                    ) <br>
                                    data <- wrds |> <span class="code-blue">wrds_fetch</span>(sql_query) <br> <br>
                                        <span class="comment-text">
                                            # Show
                                        </span>
                                        <br>
                                        data |> <span class="code-blue">as_tibble</span>()
                        </code>
                    </p>
                    <div class="copyButton">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>

            <p>
                # A tibble: 59,781 × 8
            </p>

            <table>
                <tbody>
                    <tr>
                        <td>id</td>
                        <td>eom</td>
                        <td>excntry</td>
                        <td>gvkey</td>
                        <td>permno</td>
                        <td>size_grp</td>
                        <td>me</td>
                        <td>ret_exc_lead1m</td>
                    </tr>
                    <tr>
                        <td>
                            &#x3c;dbl&#x3e;
                        </td>
                        <td>
                            &#x3c;date&#x3e;
                        </td>
                        <td>
                            &#x3c;chr&#x3e;
                        </td>
                        <td>
                            &#x3c;chr&#x3e;
                        </td>
                        <td>
                            &#x3c;dbl&#x3e;
                        </td>
                        <td>
                            &#x3c;chr&#x3e;
                        </td>
                        <td>
                            &#x3c;dbl&#x3e;
                        </td>
                        <td>
                            &#x3c;dbl&#x3e;
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>301555201</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>015552</td>
                        <td>NA</td>
                        <td>large</td>
                        <td>633.</td>
                        <td>-0.126</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>301563002</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>015630</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>239.</td>
                        <td>-0.0943</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>300802002</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>008020</td>
                        <td>NA</td>
                        <td>large</td>
                        <td>752.</td>
                        <td>-0.0212</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>301644901</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>016449</td>
                        <td>NA</td>
                        <td>large</td>
                        <td>572.</td>
                        <td>-0.141</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>301560001</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>015600</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>262.</td>
                        <td>-0.0565</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>302390301</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>023903</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>312.</td>
                        <td>-0.0630</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>302391101</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>023911</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>267.</td>
                        <td>-0.0988</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>302482601</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>024826</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>139.</td>
                        <td>0.00548</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>310113005</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>101130</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>200.</td>
                        <td>0.201</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>310115101</td>
                        <td>1985-12-31</td>
                        <td>DNK</td>
                        <td>101151</td>
                        <td>NA</td>
                        <td>small</td>
                        <td>229.</td>
                        <td>-0.118</td>
                    </tr>
                </tbody>
            </table>
            <p>
                # ℹ 59,771 more rows
            </p>

            <h4>
                Extracting data from many countries
            </h4>
            <p>
                Next, I’m downloading the 153 characteristics from all developed countries (on my machine, this takes
                around 25 minutes
                the data set is 12.4GB):
            </p>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code style="font-size: .875em;">
                            sql_query <- <span class="code-blue">paste0</span>(<br>
                                &nbsp; &nbsp; <span class="code-green">" SELECT id, eom, excntry, gvkey,
                                    permno,"</span>,<br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; paste0(chars_rel, collapse=", " ),<br>
                                <span class="code-green">
                                    &nbsp; &nbsp; " FROM contrib.global_factor <br>
                                    &nbsp; &nbsp; WHERE common=1 and exch_main=1 and primary_sec=1 and obs_main=1 and <br>
                                    excntry in",</span>
                                <br>
                                &nbsp; &nbsp; "(" , <span class="code-blue">paste0</span>("'", countries_rel, "'" ,
                                collapse=", " ), ")" ,<br>
                                ";" <br>
                                ) <br>
                                data <- wrds |> <span class="code-blue">wrds_fetch</span>(sql_query)
                        </code>
                    </p>
                    <div class="copyButton">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>

            <h4>
                Extracting data from many countries with limited RAM
            </h4>
            <p>
                If your computer has limited RAM, a viable alternative is to download the data country-by-country and
                save the
                country-specific files to your local PC:
            </p>
            <div class="px-3 pt-3 pb-1 blue-box" style="overflow-x: scroll;">
                <div style="width: 1300px; min-width: 1300px;">
                    <p>
                        <code>
                            for (country in countries_rel) { <br>

                            &nbsp; &nbsp; sql_query <- <span class="code-blue">paste0</span>(<br>
                                &nbsp; &nbsp; <span class="code-green">" SELECT id, eom, excntry, gvkey,
                                    permno,"</span>,<br>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; paste0(chars_rel, collapse=", " ), <br>
                                <span class="code-green">
                                    &nbsp; &nbsp; " FROM contrib.global_factor <br>
                                    &nbsp; &nbsp; WHERE common=1 and exch_main=1 and primary_sec=1 and obs_main=1 and<br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; excntry = '"</span> , country, "';" )<br> <br>
                                    <span class="comment-text">
                                        # Get data
                                    </span>
                                    <br>
                                    data <- wrds |> <span class="code-blue">wrds_fetch</span>(sql_query)<br> <br>
                                        <span class="comment-text">
                                            # Save
                                        </span>
                                        <br>
                                        data |> <span class="code-blue">fwrite</span>(<span
                                            class="code-blue">paste0</span>(country, ".csv"))<br>
                                        }
                        </code>
                    </p>
                    <div class="copyButton">📋<span class="tooltip">Copied!</span></div>
                </div>
            </div>
            <h4>
                Notes
            </h4>
            <ul>
                <li>
                    To get data from all countries, remove the part of the “WHERE” clause that’s related to the exchange
                    country.
                </li>
                <li>
                    To get all columns in the data set change the select clause to “SELECT *”
                </li>
                <li>
                    If you discover a mistake, please open an issue on our <a class="text-dark"
                        href="https://github.com/bkelly-lab/ReplicationCrisis">Github repo</a>
                </li>
            </ul>
        </div>
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
