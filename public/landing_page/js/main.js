(function($) {
    "use strict";
    jQuery(window).on('load', function() {
        jQuery("#status").fadeOut();
        jQuery("#preloader").delay(350).fadeOut("slow");
    });
    jQuery('.mobile-menu nav').meanmenu({
        meanScreenWidth: "992",
    });
    $(".lng-in").on("click", function() {
        $(".lng-out").slideToggle("slow");
    });
    smoothScroll.init();
    if ($('#pie_chart_1').length > 0) {
        $('#pie_chart_1').easyPieChart({
            barColor: '#5e619c',
            lineWidth: 2,
            animate: 3000,
            size: 100,
            lineCap: 'square',
            scaleColor: false,
            onStep: function(from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent));
            }
        });
    }
    if ($('#e_chart_3').length > 0) {
        var eChart_3 = echarts.init(document.getElementById('e_chart_3'));
        var data = [{
            value: 1945,
            name: ''
        }, {
            value: 2580,
            name: ''
        }, {
            value: 5160,
            name: ''
        }, {
            value: 54826,
            name: ''
        }];
        var option3 = {
            tooltip: {
                show: true,
                trigger: 'item',
                backgroundColor: 'rgba(33,33,33,1)',
                borderRadius: 0,
                padding: 10,
                formatter: "{b}: {c} ({d}%)",
                textStyle: {
                    color: '#fff',
                    fontStyle: 'normal',
                    fontWeight: 'normal',
                    fontFamily: "'Roboto', sans-serif",
                    fontSize: 12
                }
            },
            series: [{
                type: 'pie',
                selectedMode: 'single',
                radius: ['90%', '30%'],
                color: ['#a8a9bd', '#9395b9', '#656790', '#3e406e'],
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: data
            }]
        };
        eChart_3.setOption(option3);
        eChart_3.resize();
    }
    if ($('#e_chart_2').length > 0) {
        var eChart_3 = echarts.init(document.getElementById('e_chart_2'));
        var data = [{
            value: 555555,
            name: ''
        }, {
            value: 58152,
            name: ''
        }, {
            value: 455025,
            name: ''
        }, {
            value: 255525,
            name: ''
        }];
        var option3 = {
            tooltip: {
                show: true,
                trigger: 'item',
                backgroundColor: 'rgba(33,33,33,1)',
                borderRadius: 0,
                padding: 10,
                formatter: "{b}: {c} ({d}%)",
                textStyle: {
                    color: '#fff',
                    fontStyle: 'normal',
                    fontWeight: 'normal',
                    fontFamily: "'Roboto', sans-serif",
                    fontSize: 12
                }
            },
            series: [{
                type: 'pie',
                selectedMode: 'single',
                radius: ['90%', '30%'],
                color: ['#a8a9bd', '#9395b9', '#656790', '#3e406e'],
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: data
            }]
        };
        eChart_3.setOption(option3);
        eChart_3.resize();
    }
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 100) {
            $('#return-to-top').fadeIn(200);
        } else {
            $('#return-to-top').fadeOut(200);
        }
    });
    $('#return-to-top').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
    });
    new WOW().init();
    $(".blog-slider").owlCarousel({
        autoPlay: false,
        slideSpeed: 2000,
        pagination: false,
        navigation: true,
        items: 3,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [992, 2],
        itemsTablet: [768, 2],
        itemsMobile: [480, 1],
    });
    $(".tokes-chart-slider").owlCarousel({
        autoPlay: false,
        slideSpeed: 2000,
        pagination: false,
        navigation: true,
        items: 1,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [992, 1],
        itemsTablet: [768, 1],
        itemsMobile: [479, 1],
    });
    (function($) {
        function doAnimations(elems) {
            var animEndEv = 'webkitAnimationEnd animationend';
            elems.each(function() {
                var $this = $(this)
                  , $animationType = $this.data('animation');
                $this.addClass($animationType).one(animEndEv, function() {
                    $this.removeClass($animationType);
                });
            });
        }
        var $myCarousel = $('#carousel-example-generic')
          , $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
        $myCarousel.carousel();
        doAnimations($firstAnimatingElems);
        $myCarousel.carousel('pause');
        $myCarousel.on('slide.bs.carousel', function(e) {
            var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
            doAnimations($animatingElems);
        });
    }
    )(jQuery);
    var deadline = 'dec 14 2021 11:59:00 GMT-0400';
    function time_remaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }
    function run_clock(id, endtime) {
        var clock = document.getElementById(id);
        var days_span = clock.querySelector('.days');
        var hours_span = clock.querySelector('.hours');
        var minutes_span = clock.querySelector('.minutes');
        var seconds_span = clock.querySelector('.seconds');
        function update_clock() {
            var t = time_remaining(endtime);
            days_span.innerHTML = t.days;
            hours_span.innerHTML = ('0' + t.hours).slice(-2);
            minutes_span.innerHTML = ('0' + t.minutes).slice(-2);
            seconds_span.innerHTML = ('0' + t.seconds).slice(-2);
            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }
        update_clock();
        var timeinterval = setInterval(update_clock, 1000);
    }
    run_clock('clockdiv', deadline);
    var deadline = 'september 1 2018 11:59:00 GMT-0400';
    function time_remaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }
    function run_clock(id, endtime) {
        var clock = document.getElementById(id);
        var days_span = clock.querySelector('.days');
        var hours_span = clock.querySelector('.hours');
        var minutes_span = clock.querySelector('.minutes');
        var seconds_span = clock.querySelector('.seconds');
        function update_clock() {
            var t = time_remaining(endtime);
            days_span.innerHTML = t.days;
            hours_span.innerHTML = ('0' + t.hours).slice(-2);
            minutes_span.innerHTML = ('0' + t.minutes).slice(-2);
            seconds_span.innerHTML = ('0' + t.seconds).slice(-2);
            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }
        update_clock();
        var timeinterval = setInterval(update_clock, 1000);
    }
    run_clock('clockdiv2', deadline);
    $('.wd_single_index_menu ul li a').on('click', function(e) {
        $('.wd_single_index_menu ul li').removeClass('active');
        $(this).parent().addClass('active');
        var target = $('[section-scroll=' + $(this).attr('href') + ']');
        e.preventDefault();
        var targetHeight = target.offset().top - parseInt('80', 10);
        $('html, body').animate({
            scrollTop: targetHeight
        }, 1000);
    });
    $(window).scroll(function() {
        var windscroll = $(window).scrollTop();
        var target = $('.wd_single_index_menu ul li');
        if (windscroll >= 0) {
            $('[section-scroll]').each(function(i) {
                if ($(this).position().top <= windscroll + 90) {
                    target.removeClass('active');
                    target.eq(i).addClass('active');
                }
            });
        } else {
            target.removeClass('active');
            $('.wd_single_index_menu ul li:first').addClass('active');
        }
    });
    $('#cssmenu ul li a').on('click', function(e) {
        $('#cssmenu ul li').removeClass('active');
        $(this).parent().addClass('active');
        var target = $('[section-scroll=' + $(this).attr('href') + ']');
        e.preventDefault();
        var targetHeight = target.offset().top - parseInt('80', 10);
        $('html, body').animate({
            scrollTop: targetHeight
        }, 1000);
    });
    $(window).scroll(function() {
        var windscroll = $(window).scrollTop();
        var target = $('#cssmenu ul li');
        if (windscroll >= 0) {
            $('[section-scroll]').each(function(i) {
                if ($(this).position().top <= windscroll + 90) {
                    target.removeClass('active');
                    target.eq(i).addClass('active');
                }
            });
        } else {
            target.removeClass('active');
            $('#cssmenu ul li:first').addClass('active');
        }
    });
    $(window).scroll(function() {
        var window_top = $(window).scrollTop() + 1;
        if (window_top > 800) {
            $('.gc_main_menu_wrapper').addClass('menu_fixed animated fadeInDown');
        } else {
            $('.gc_main_menu_wrapper').removeClass('menu_fixed animated fadeInDown');
        }
    });
    $.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });
}
)(jQuery);
var SEPARATION = 200
  , AMOUNTX = 30
  , AMOUNTY = 30;
var container, stats;
var camera, scene, renderer;
var particles, particle, count = 0;
var mouseX = 100
  , mouseY = -550;
var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;
init();
animate();
function init() {
    container = document.createElement('div');
    document.body.appendChild(container);
    camera = new THREE.PerspectiveCamera(75,window.innerWidth / window.innerHeight,1,10000);
    camera.position.z = 1000;
    scene = new THREE.Scene();
    particles = new Array();
    var PI2 = Math.PI * 2;
    var material = new THREE.SpriteCanvasMaterial({
        color: 0xffffff,
        program: function(context) {
            context.beginPath();
            renderer.setClearColorHex(0x08091b, 1);
            context.arc(0, 0, 0.5, 0, PI2, true);
            context.fill();
        }
    });
    var i = 0;
    for (var ix = 0; ix < AMOUNTX; ix++) {
        for (var iy = 0; iy < AMOUNTY; iy++) {
            particle = particles[i++] = new THREE.Sprite(material);
            particle.position.x = ix * SEPARATION - ((AMOUNTX * SEPARATION) / 2);
            particle.position.z = iy * SEPARATION - ((AMOUNTY * SEPARATION) / 2);
            scene.add(particle);
        }
    }
    renderer = new THREE.CanvasRenderer();
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);
    stats = new Stats();
    container.appendChild(stats.dom);
}
function onWindowResize() {
    windowHalfX = window.innerWidth / 2;
    windowHalfY = window.innerHeight / 2;
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}
function onDocumentMouseMove(event) {
    mouseX = event.clientX - windowHalfX;
    mouseY = event.clientY - windowHalfY;
}
function onDocumentTouchStart(event) {
    if (event.touches.length === 1) {
        event.preventDefault();
        mouseX = event.touches[0].pageX - windowHalfX;
        mouseY = event.touches[0].pageY - windowHalfY;
    }
}
function onDocumentTouchMove(event) {
    if (event.touches.length === 1) {
        event.preventDefault();
        mouseX = event.touches[0].pageX - windowHalfX;
        mouseY = event.touches[0].pageY - windowHalfY;
    }
}
function animate() {
    requestAnimationFrame(animate);
    render();
    stats.update();
}
function render() {
    camera.position.x += (mouseX - camera.position.x) * .05;
    camera.position.y += (-mouseY - camera.position.y) * .05;
    camera.lookAt(scene.position);
    var i = 0;
    for (var ix = 0; ix < AMOUNTX; ix++) {
        for (var iy = 0; iy < AMOUNTY; iy++) {
            particle = particles[i++];
            particle.position.y = (Math.sin((ix + count) * 0.3) * 50) + (Math.sin((iy + count) * 0.5) * 50);
            particle.scale.x = particle.scale.y = (Math.sin((ix + count) * 0.3) + 1) * 4 + (Math.sin((iy + count) * 0.5) + 1) * 4;
        }
    }
    renderer.render(scene, camera);
    count += 0.1;
}
