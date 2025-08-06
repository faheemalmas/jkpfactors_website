<div class="w-100 mb-0 py-md-4 pt-3 dm-serif-regular" style="background-color: white; color: #000000;">
    <div class="header-title text-center">
        <div class="d-none d-xl-block" style="font-size:64px;">Global Factor Data</div>
        <div class="d-none d-lg-block d-xl-none" style="font-size:48px;">Global Factor Data</div>
        <div class="d-none d-md-block d-lg-none" style="font-size:36px;">Global Factor Data</div>
        <div class="d-sm-block d-md-none" style="font-size:28px;">Global Factor Data</div>
    </div>
</div>

<nav style="padding-bottom: 5px !important; background-color: white;  width: 100%; margin: auto;">
    <div class="text-center m-auto d-none" style="width: 90%;">
        <div class="row text-center newbar" style="justify-content: space-around;">
            <div class="col">
                <a href="/" class="newcol text-blue">About</a>
            </div>
            <div class="col">
                <a href="/factor-return" class="newcol text-blue">Factor Returns</a>
            </div>
            <div class="col">
                <a href="/stock-data" class="newcol text-blue">Stock Characteristics</a>
            </div>
            <div class="col">
                <ul class="list-unstyled" style="margin: 0px auto;">
                    <li class="nav-item dropdown">
                        <a href="#" class="newcol newcol-aft text-blue" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Analysis
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                    style="color: black !important;" href="/analysis">
                                    Performance of
                                    Factors</a></li>
                            <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                    style="color: black !important;" href="/factors-to-watch">
                                    Factors to Watch
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col">
                <ul class="list-unstyled" style="margin: 0px auto;">
                    <li class="nav-item dropdown">
                        <a href="#" class="newcol newcol-aft text-blue" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Resources
                        </a>
                    </li>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li style="margin: auto; width: 100%;"><a class="dropdown-item" style="color: black !important;"
                                href="/analysis">
                                Performance of
                                Factors</a></li>
                        <li style="margin: auto; width: 100%;"><a class="dropdown-item" style="color: black !important;"
                                href="/factors-to-watch">
                                Factors to Watch
                            </a></li>
                    </ul>

                </ul>
            </div>

            <div class="col">
                <ul class="list-unstyled" style="margin: 0px auto;">
                    <li class="nav-item dropdown">
                        <a href="#" class="newcol newcol-aft text-blue" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Common Task Framework
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                    style="color: black !important;" href="{{ route('commontaskframework') }}">Model
                                    Submission</a></li>
                            <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                    style="color: black !important;" href="{{ route('requestCtfData') }}">
                                    CTF Data Request
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col">
                <a href="/contact" class="newcol text-blue">Contact Us hh</a>
            </div>
        </div>
    </div>
</nav>
<!-- End Header/Navigation -->
<div class="container-fluid border-bottom">
    <div class="d-flex justify-content-center flex-wrap">
        <div class="px-0">
            <a href="/" class="newcol text-blue @if (Request::segment(1) == null) active @endif">About</a>
        </div>
        <div class="px-0">
            <a href="/factor-returns" class="newcol text-blue @if (Request::segment(1) == 'factor-returns') active @endif">Factor
                Returns</a>
        </div>
        <div class="px-0">
            <a href="/stock-char" class="newcol text-blue @if (Request::segment(1) == 'stock-char') active @endif">Stock
                Characteristics</a>
        </div>
        <div class="px-0">
            <a href="/analysis" class="newcol text-blue @if (Request::segment(1) == 'analysis') active @endif">Analysis</a>
        </div>
        <div class="px-0">
            <a class="newcol newcol-aft text-blue @if (Request::segment(1) == 'guide-R' || Request::segment(1) == 'guide-python') active @endif" href="#"
                id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Resources
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li class="dropdown-submenu">
                </li>
                <li><a class="dropdown-item" target="_blank"
                        href="https://jkpfactors.s3.amazonaws.com/documents/Documentation.pdf">Documentation</a></li>
                <li><a class="dropdown-item" href="/guide-python">JKP/WRDS Python Guide</a></li>
                <li><a class="dropdown-item" href="/guide-R">JKP/WRDS R Guide</a></li>
                <li><a class="dropdown-item" target="_blank"
                        href="https://github.com/bkelly-lab/ReplicationCrisis">JKP Github Repo</a></li>
            </ul>
            </li>
        </div>

        <div class="px-0">
            <ul class="list-unstyled" style="margin: 0px auto;">
                <li class="nav-item dropdown">
                    <a href="#" class="newcol newcol-aft text-blue" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Common Task Framework
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                style="color: black !important;" href="{{ route('commontaskframework') }}">Model
                                Submission</a></li>
                        <li style="margin: auto; width: 100%;"><a class="dropdown-item"
                                style="color: black !important;" href="{{ route('requestCtfData') }}">
                                CTF Data Request
                            </a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="px-0">
            <a href="/contact" class="newcol text-blue @if (Request::segment(1) == 'contact') active @endif">Contact Us</a>
        </div>
    </div>
</div>
