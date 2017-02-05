<!DOCTYPE html>


<html>
<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <meta name="Author" content="University of South Florida">
    <link rel="shortcut icon" href="//cdn.usf.edu/favicon.ico" />
    <title>@yield('pagetitle') | Dashboard | Orientation | USF</title>

    <!--Resources-->
    <link rel="stylesheet" href="//cdn.usf.edu/themes/usf/user/v2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdn.usf.edu/themes/usf/user/v2.0/css/secondary.css" />
    <link rel="stylesheet" href="//cdn.usf.edu/themes/usf/user/v2.0/css/usf-mod.css" />
    <script type="text/javascript" src="//cdn.usf.edu/themes/usf/user/v2.0/js/jquery.min.1.9.1.js"></script>
    <script type="text/javascript" src="//cdn.usf.edu/themes/usf/user/v2.0/js/functions.js"></script>
    <script type="text/javascript" src="//cdn.usf.edu/themes/usf/user/v2.0/js/bootstrap.min.js"></script>
    <!--End Resources-->

    <!-- Proposal System CSS -->
    <link rel="stylesheet" href="{{ url('css/standard.min.css') }}" />
    @yield('css')
</head>
<body>

    <!--Header-->
    <header role="banner">
        <a class="skipLink" href="#content">Skip to Main Content</a><div class="global u-wrapper u-clearfix">
            <p class="global_logo"><a href="http://system.usf.edu/">University of South Florida System</a></p>
            <div class="global_tools u-clearfix">

                <ul>
                    <li><a href="https://my.usf.edu/">MyUSF</a></li>
                    <li><a href="http://www.usf.edu/about-usf/web-tools.aspx">Web Tools</a></li>
                    <li><a href="http://directory.usf.edu/">Directory</a></li>
                </ul>
                <form class="global_search" method="get" action="http://search.usf.edu/search" role="search">
                    <label class="hidden" for="site-search-input">Search for: </label>
                    <input id="site-search-input" type="text" name="q" size="20" maxlength="256" value="" />
                    <input id="site-search-submit" type="image" src="//cdn.usf.edu/_resources/images/v2/global/search/search.png" alt="Go" />
                    <input type="hidden" name="client" value="tampa" />
                    <input type="hidden" name="proxystylesheet" value="usf-edu-cms-v2" />
                    <input type="hidden" name="site" value="tampa" />
                    <input type="hidden" name="output" value="xml_no_dtd" />
                    <input type="hidden" name="numgm" value="5" />
                </form>


            </div>
        </div>
        <div class="banner">
            <div class="banner_interior u-wrapper">
                <h1 class="banner_title"><a href="{{ url('/') }}">Office of Orientation</a></h1>
                <p class="banner_subtitle"><a href="http://systemacademics.usf.edu">Undergraduate Studies</a></p>
            </div>
        </div>
        <nav class="mainNav" role="navigation">
            <div class="u-wrapper">
                <p class="mainNav_toggle toggle">Navigation</p>
                <ul class="mainNav_menu toggle-content mainNav--six">
                    <li class="mainNav_item"><a href="{{ url('tracking') }}">Reservation</a></li>
                    <li class="mainNav_item"><a href="{{ url('dashboard') }}">First Year</a></li>
                    <li class="mainNav_item"><a href="{{ url('resources') }}">Transfer</a></li>
                    <li class="mainNav_item"><a href="http://systemacademics.usf.edu/curriculum/curricular-processes.php">International</a></li>
                    <li class="mainNav_item"><a href="{{ url('contacts') }}">Join Our Team</a></li>
                    <li class="mainNav_item"><a href="{{ url('contacts') }}">About Us</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!--End Header-->


    <!--Content-->
    <div id="content" class="container" role="main">

        <h1 class="page-title-plain-text">@yield('pagetitle')</h1>

        <nav class="breadcrumbs" role="navigation">
            <ul>

                <li>
                    <a href="http://www.usf.edu/orientation/">Orientation</a> &gt;
                </li>
                @yield('breadcrumbs')
            </ul>
        </nav>


        @yield('secondary-navigation')

        <!--Begin Page Content -->
        @if(array_key_exists('secondary-navigation', app('view')->getSections()))
        <div class="contentfixmenu">
        @else
        <div>
        @endif
        @if (Auth::check())
          @include('dashboard.navbar.navbar')
        @endif
        <!-- Display Errors -->
        @include('common.errors')
        @include('common.statuses')
        @yield('content')
        </div><!--End Page Content-->
    </div>
    <!-- End Content -->

    <!--Footer-->
    <footer class="container footerfix">

        <div class="row">


            <div class="col-lg-6 col-md-5 col-sm-5">
                <a href="http://system.usf.edu"><img class="footer-usf-logo" src="//cdn.usf.edu/themes/usf/applications/1.0/images/footer/footer-logo-system.png" alt="University of South Florida System"></a><p class="footer-copy">
                    Copyright &copy; {{ date('Y') }}, University of South Florida. All rights reserved.<br>4202 E. Fowler Avenue,
                    Tampa, FL 33620, USA &bull; 813-974-2011<br>This website is maintained by <a href="mailto:myorientation@usf.edu">Orientation</a>.
                    <br>

                    <a href="http://www.usf.edu/about-usf/about-this-site.aspx">About This Site</a> &bull; <a href="http://www.usf.edu/about-usf/site-map.aspx">Site Map</a> &bull; <a href="http://www.usf.edu/about-usf/contact-usf.aspx">Contact USF</a>

                </p>

            </div>

            <nav>
                <div class="col-xs-4-offset-1 col-md-2 col-lg-2">
                    <ul>
                        <li><a title="USF Home" href="http://usf.edu/">USF Home</a></li>
                        <li><a title="About USF" href="http://usf.edu/about-usf/index.aspx">About USF</a></li>
                        <li><a title="Academics" href="http://usf.edu/academics/index.aspx">Academics</a></li>
                        <li><a title="Admissions" href="http://usf.edu/admission/index.aspx">Admissions</a></li>
                        <li><a title="Campus Life" href="http://usf.edu/campus-life/index.aspx">Campus Life</a></li>
                        <li><a title="Research" href="http://usf.edu/research/index.aspx">Research</a></li>
                    </ul>
                </div>
                <div class="col-xs-4-offset-1 col-md-2 col-lg-2">
                    <ul>
                        <li><a title="USF System" href="http://system.usf.edu" target="_blank">USF System</a></li>
                        <li><a title="Administrative Units" href="http://usf.edu/about-usf/administrative-units.aspx">Administrative Units</a></li>
                        <li><a title="Regulations" href="http://generalcounsel.usf.edu/regulations-and-policies/regulations-policies-procedures.asp" target="_blank">Regulations &amp; Policies</a></li>
                        <li><a title="Human Resources" href="http://usfweb2.usf.edu/human-resources/index.asp" target="_blank">Human Resources</a></li>
                        <li><a title="Emergency &amp; Safety" href="http://news.usf.edu/article/templates/?a=813&amp;z=51" target="_blank">Emergency &amp; Safety</a></li>
                        <li><a title="Visit USF" href="http://usf.edu/about-usf/visit-usf.aspx">Visit USF</a></li>
                    </ul>
                </div>
                <div class="col-xs-4-offset-1 col-md-2 col-lg-2">
                    <ul>
                        <li><a title="USF Health" href="http://health.usf.edu/" target="_blank">USF Health</a></li>
                        <li><a title="USF Athletics" href="http://www.gousfbulls.com/" target="_blank">USF Athletics</a></li>
                        <li><a title="USF Alumni" href="http://usfalumni.net/s/861/index.aspx" target="_blank">USF Alumni</a></li>
                        <li><a title="Support USF" href="http://usfweb3.usf.edu/unstoppable/index.aspx" target="_blank">Support USF</a></li>
                        <li><a title="USF Libraries" href="http://www.lib.usf.edu/" target="_blank">USF Libraries</a></li>
                        <li><a title="USF World" href="http://global.usf.edu/" target="_blank">USF World</a></li>
                    </ul>

                </div>
            </nav>
        </div>

    </footer>
    <!--End Footer-->
    <!--Working Overlay-->
    <div class="ajax-working hidden-print">
      <div class="working">
        <h3>Working</h3>
        <p><em>Please Wait</em></p>
        <p><img src="{{ url('images/loading.gif') }}"></p>
      </div>
    </div>

    <!-- Scripts -->
    <script>var api = '{{ env('INTERNAL_API') }}';</script>
    <script src="{{ url('js/app.min.js') }}"></script>
    @yield('js')
</body>
</html>
