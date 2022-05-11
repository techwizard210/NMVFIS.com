<!doctype html>
<html class="no-js" lang="en">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content=<?php echo json_encode(md5(uniqid(rand(), TRUE))); ?>>

    <title>NMVFIS </title>
    <meta name="description" content="">

    <link rel="shortcut icon" href="landing_page/img/logo_1.png" type="image/x-icon">
    <link rel="icon" href="landing_page/img/logo_1.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="landing_page/css/bootstrap.min.css">
    <link rel="stylesheet" href="landing_page/css/animate.css">
    <link rel="stylesheet" href="landing_page/css/jquery-ui.min.css">
    <link rel="stylesheet" href="landing_page/css/meanmenu.min.css">
    <link rel="stylesheet" href="landing_page/css/owl.carousel.min.css">
    <link rel="stylesheet" href="landing_page/css/flaticon.css">
    <link rel="stylesheet" href="landing_page/css/font-awesome.min.css">
    <link rel="stylesheet" href="landing_page/css/video-js.css">
    <link rel="stylesheet" href="landing_page/css/responsive.css">
    <link rel="stylesheet" href="landing_page/css/style.css">
    <script src="landing_page/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <a href="javascript:" id="return-to-top"><i class="fa fa-angle-up"></i></a>


    <div section-scroll='0' class="wd_scroll_wrap">
        <div class="header-top">
            <div class="auto-container">

            </div>
        </div>
        <header class="gc_main_menu_wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-6">
                        <div class="logo-area">
                            <a href="index.php"><img src="landing_page/img/logo.png" alt="logo" width="230" style="position: absolute; top: -10px; left: 0px;" /></a>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-6">
                        <div class="menu-area  hidden-xs">
                            <nav class="wd_single_index_menu btc_main_menu">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About</a></li>
                                    <!-- <li><a href="concept.php">Business</a></li> -->

                                    <!-- <li><a href="faq.php">FAQ</a></li> -->
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </nav>

                            <div class="login-btn">
                                <a href="https://nmvfis.com/login" target="_blank" class="btn1"><i class="fa fa-user"></i><span>Login</span></a>
                                <a href="https://nmvfis.com/register" target="_blank" class="btn1"><i class="fa fa-user"></i><span>Register</span></a>

                            </div>
                        </div>

                        <div class="rp_mobail_menu_main_wrapper visible-xs">
                            <div class="row">
                                <div class="col-xs-12">

                                    <a id="toggle" onclick="if (!window.__cfRLUnblockHandlers) return false; myFunction()" data-cf-modified-00ac2b818fa70e622a9ba191-=""><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.177 31.177" style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve" width="25px" height="25px">
                                            <g>
                                                <g>
                                                    <path class="menubar" d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z" fill="#fff" />
                                                </g>
                                                <g>
                                                    <path class="menubar" d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z" fill="#fff" />
                                                </g>
                                                <g>
                                                    <path class="menubar" d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z" fill="#fff" />
                                                </g>
                                                <g>
                                                    <path class="menubar" d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z" fill="#fff" />
                                                </g>
                                                <g>
                                                    <path class="menubar" d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z" fill="#fff" />
                                                </g>
                                            </g>
                                        </svg></a>
                                </div>
                            </div>
                            <div id="sidebar">
                                <h1><a href="#">NMVFIS</a></h1>
                                <a href="#!">
                                    <div id="google_translate_element"></div>
                                </a>

                                <a id="toggle_close" onclick="if (!window.__cfRLUnblockHandlers) return false; myFunction1()" data-cf-modified-00ac2b818fa70e622a9ba191-="">&times;</a>
                                <div id='cssmenu' class="wd_single_index_menu">
                                    <ul>
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="concept.php">Business</a></li>

                                        <li><a href="faq.php">FAQ</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                        <li><a href="https://www.nmvfis.com/login" target="_blank" target="_blank">Login</a></li>
                                        <li><a href="https://www.nmvfis.com/register" target="_blank" target="_blank">Register</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>

    </div>

    <main>
        <div section-scroll='1' class="wd_scroll_wrap">

        </div>



        <div class="about-02-area pt-120 pos-rel pb-90 pd-t70 slider-area">
            <div class="container" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-lg-offset-2">
                        <div><img src="landing_page/img//about/contact.jpg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-02-area pt-120 pos-rel pb-90 pd-t70 bg-2">
            <div class="form-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 projects col-lg-offset-2">
                            <div class="project-list wow  fadeInUp  animated" data-wow-duration="1.0s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                                <div class="content">
                                    <img src="landing_page/img/icons/contact_acc.png" alt="" width="100">
                                    <h3>Contact Details</h3>
                                    <ul class="fontactInfo pd-t20">
                                        <li><span class="icon flaticon-location-pin"></span><strong>Founder:</strong> Joel Noval</li>
                                        <li><span class="icon flaticon-location-pin"></span><strong>Address:</strong> Flat 207 Al Jaddaf Western<br> Residence, Dubai, UAE</li>
                                        <li><span class="icon flaticon-technology-2"></span><strong>Phone:</strong>+971.524344457 </li>
                                        <li><span class="icon flaticon-envelope"></span><strong>Email :</strong><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="">support@nmvfis.com</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class=" ">Send Your Message</h4>
                            <p class="">Do not hesitate to ask us anything. Our customer support team is always ready to help you. <br> They are available 24/7.</p>
                            <div class="contact-form">
                                <form method="get" action="/send-email" enctype="multipart/form-data" autocomplete="on" class="form-horizontal">
                                    <div class="row clearfix">
                                        <div class="column col-md-6 col-sm-12 col-xs-12 bg-inpt">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Your Name *" required>
                                            </div>
                                        </div>
                                        <div class="column col-md-6 col-sm-12 col-xs-12 bg-inpt">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address*" required>
                                            </div>
                                        </div>
                                        <div class="column col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group t-hgt">
                                                <textarea name="message" id="message" class="form-control" placeholder="Your Message..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="column btn-column col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group text-center">
                                                <input type="hidden" name="token" value=<?php echo json_encode(md5(uniqid(rand(), TRUE))); ?>>
                                                <button class="btn1" id="btnSend" type="submit" name="contactSubmit">Submit Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal cm" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <img src="landing_page/img/tick.png" width="90">
                        </center>
                        <br>
                        <h3 style="text-align: center;">Thank you for enquiry, We will contact you soon..!</h3>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </main>


    <footer class="top-foo">
        <div id="footer-js">
            <div class="footer-top section">
                <div class="container">
                    <div class="row" style="display: flex; justify-content:center;">

                        <div class="big-column col-md-10 col-sm-10 col-xs-12">
                            <div class="footer-column col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-widget link-widget">

                                    <a href="index.php">
                                        <img src="landing_page/img/logo.png" style="position: relative; bottom:10px;">
                                    </a>
                                    <p class="tw mt-20">Complete Crypto ventures with NMVFIS. A protected and productive platform to grow your Crypto finances. Invest and acquire better each day.</p>

                                </div>
                            </div>

                            <div class="footer-column col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-widget link-widget">
                                    <div class="footer-title">
                                        <h2>Important Links</h2>
                                        <div class="separator"></div>
                                    </div>
                                    <ul class="list-links">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="footer-column col-md-4 col-sm-4 col-xs-12">
                                <div class="footer-widget info-widget">
                                    <div class="footer-title">
                                        <h2>Quick Links</h2>
                                        <div class="separator"></div>
                                    </div>
                                    <ul class="social-links">
                                        <li><a href="https://www.nmvfis.com/login" target="_blank"><span class="fa fa-sign-in"></span> Login</a></li>
                                        <li><a href="https://www.nmvfis.com/register" target="_blank"><span class="fa fa-user-plus"></span> Register</a></li>
                                    </ul>
                                    <div class="slider-content footer-social">
                                        <ul>
                                            <li data-animation="animated bounceInDown" class="slider_social_icon1"><a href="https://www.facebook.com/NMVFIS/"><i class="fa fa-facebook"></i></a></li>

                                            <li data-animation="animated bounceInDown" class="slider_social_icon3"><a href="https://t.me/+ZoepFMoVnhk3ZDVk" target="_blank"><i class="fa fa-send-o"></i></a></li>
                                            <li data-animation="animated bounceInDown" class="slider_social_icon4"><a href="https://www.youtube.com/c/JoelNoval" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
                                        </ul>
                                        <li class="lst"><span class="fa fa-server"></span> <b>Server Time</b>: <span id="date_time"></span></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <footer class="foo-bot">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="copyright wow  fadeInUp animated" data-wow-duration="1.9s" style="visibility: visible; animation-duration: 1.0s; animation-name: fadeInUp;">
                            <p>
                                <a href="#">NMVFIS.com</a> Registered On 2022-01-23, Soft Launched @ 2022-03-07
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    </div>


    <script src="landing_page/js/email-decode.min.js"></script>
    <script src="landing_page/js/three.js"></script>
    <script src="landing_page/js/stats.min.js"></script>
    <script src="landing_page/js/Projector.js"></script>
    <script src="landing_page/js/CanvasRenderer.js"></script>

    <script src="landing_page/js/vendor/jquery-3.2.1.min.js"></script>
    <script src="landing_page/js/vendor/modernizr-2.8.3.min.js"></script>

    <script src="landing_page/js/tether.js"></script>

    <script src="landing_page/js/bootstrap.min.js"></script>

    <script src="landing_page/js/owl.carousel.min.js"></script>

    <script src="landing_page/js/jquery.meanmenu.js"></script>

    <script src="landing_page/js/jquery-ui.min.js"></script>

    <script src="landing_page/js/jquery.easypiechart.min.js"></script>


    <script src="landing_page/js/wow.min.js"></script>

    <script src="landing_page/js/smooth-scroll.min.js"></script>

    <script src="landing_page/js/plugins.js"></script>

    <script src="landing_page/js/echarts-en.min.js"></script>
    <script src="landing_page/js/echarts-liquidfill.min.js"></script>
    <script src="landing_page/js/vc_round_chart.min.js"></script>
    <script src="landing_page/js/videojs-ie8.min.js"></script>
    <script src="landing_page/js/video.js"></script>
    <script src="landing_page/js/Youtube.min.js"></script>

    <script src="landing_page/js/main.js"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>
        function myFunction() {
            var x = document.getElementById("sidebar");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
    </script>
    <script>
        function myFunction1() {
            var x = document.getElementById("sidebar");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <script>
        /* setInterval(function() {
        displayFullName();
    }, 3000); */
        displayFullName();

        function displayFullName() {
            // Creating the XMLHttpRequest object
            var request = new XMLHttpRequest();

            // Instantiating the request object
            request.open("GET", "https://www.paymara.com/paymara/api/get-server-details");

            // Defining event listener for readystatechange event
            request.onreadystatechange = function() {
                // Check if the request is compete and was successful
                if (this.readyState === 4 && this.status === 200) {
                    // Inserting the response from server into an HTML element
                    //document.getElementById("result").innerHTML = this.responseText;
                    var obj = JSON.parse(this.responseText);
                    var dateStringWithTime = obj.data.server_time;
                    getTime(dateStringWithTime);
                    // document.getElementById("date_time").innerHTML = dateStringWithTime;
                }
            };

            // Sending the request to the server
            request.send();
        }

        function getTime(server_date) {
            setInterval(myTimer, 1000);

            var d = new Date();
            var localTime = d.getTime();
            var localOffset = d.getTimezoneOffset() * 60000;
            var utc = localTime + localOffset;
            var offset = 4; //UTC of Dubai is +04.00
            var dubai = utc + (3600000 * offset);
            var nd = new Date(dubai);


            function myTimer() {
                nd.setSeconds(nd.getSeconds() + 1);

                let aaa = nd.getDate() + "-" + (nd.getMonth() + 1) + "-" + nd.getFullYear() + " " + nd.getHours() + ":" + nd.getMinutes() + ":" + nd.getSeconds(); //12:05
                document.getElementById("date_time").innerHTML = aaa;
            }
        }
    </script>
    <script>
        // $(document).ready(function() {
        //     $("#myModal").modal('show');
        // });
    </script>
    <script>
        $("#close_popup").click(function() {
            $("#myModal").css("display", "none");
        });
    </script>
    <script>
        $(".modal").click(function() {
            $("#myModal").css("display", "none");
        });
    </script>
    <script src="landing_page/js/rocket-loader.min.js"></script>

    <script>
        function handlePayment() {
            var username = $('#username').val();
            var email = $('#email').val();
            var message = $('#message').val();
            $csrf_token = <?php echo json_encode(md5(uniqid(rand(), TRUE))); ?>;
            $asdf = <?php echo json_encode(bin2hex(random_bytes(35))); ?>;

            console.log('@@@', $csrf_token)
            console.log('$$$$$', $('meta[name="csrf-token"]').attr('content'));
            console.log('%%%', $asdf);
            if (username != '' && email != '' && message != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $asdf
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/send-email',
                    data: {
                        'token': $asdf,
                        'username': username,
                        'email': email,
                        'message': message
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 'OK') {
                            $('#myModal').modal('show');
                            $('#username').val('');
                            $('#email').val('');
                            $('#message').val('');
                        }

                    },
                    error: function(request, error) {
                        alert("Request: " + JSON.stringify(request));
                    }
                });
            } else {
                alert('Kindly fill all the fields..');
            }
        }

        $(document).ready(function() {
            $('#btnSend').on("click", function() {
                var username = $('#username').val();
                var email = $('#email').val();
                var message = $('#message').val();
                if (username != '' && email != '' && message != '') {
                    //alert('Btn Clicked');
                    $('#myModal').modal('show');
                    $('#username').val('');
                    $('#email').val('');
                    $('#message').val('');
                } else {
                    alert('Kindly fill all the fields..');
                }
            });
        });
    </script>
</body>

</html>