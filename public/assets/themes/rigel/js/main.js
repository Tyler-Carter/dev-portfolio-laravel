/**
 * Template Name: MyResume - v2.1.0
 * Template URL: https://bootstrapmade.com/free-html-bootstrap-template-my-resume/
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */
!(function ($) {
    "use strict";

    // Preloader
    $(window).on('load', function () {
        if ($('#szn-preloader').length) {
            $('#szn-preloader').delay(100).fadeOut('slow', function() {
                $(this).remove();
            });
        }
    });

    // Smooth scroll for the navigation menu and links with .scrollto classes
    $(document).on('click', '.nav-menu a, .scrollto', function (e) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            if (target.length) {
                e.preventDefault();

                var scrollto = target.offset().top;

                $('html, body').animate({
                    scrollTop: scrollto
                }, 1500, 'easeInOutExpo');

                if ($(this).parents('.nav-menu, .mobile-nav').length) {
                    $('.nav-menu .active, .mobile-nav .active').removeClass('active');
                    $(this).closest('li').addClass('active');
                }

                if ($('body').hasClass('mobile-nav-active')) {
                    $('body').removeClass('mobile-nav-active');
                    $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
                }
                return false;
            }
        }
    });

    // Activate smooth scroll on page load with hash links in the url
    $(document).ready(function () {
        if (window.location.hash) {
            var initial_nav = window.location.hash;
            if ($(initial_nav).length) {
                var scrollto = $(initial_nav).offset().top;
                $('html, body').animate({
                    scrollTop: scrollto
                }, 1500, 'easeInOutExpo');
            }
        }
    });

    $(document).on('click', '.mobile-nav-toggle', function (e) {
        $('body').toggleClass('mobile-nav-active');
        $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
    });

    $(document).click(function (e) {
        var container = $(".mobile-nav-toggle");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($('body').hasClass('mobile-nav-active')) {
                $('body').removeClass('mobile-nav-active');
                $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
            }
        }
    });

    // Navigation active state on scroll
    var nav_sections = $('section');
    var main_nav = $('.nav-menu, #mobile-nav');

    $(window).on('scroll', function () {
        var cur_pos = $(this).scrollTop() + 300;

        nav_sections.each(function () {
            var top = $(this).offset().top,
                bottom = top + $(this).outerHeight();

            if (cur_pos >= top && cur_pos <= bottom) {
                if (cur_pos <= bottom) {
                    main_nav.find('li').removeClass('active');
                }
                main_nav.find('a[href="#' + $(this).attr('id') + '"]').parent('li').addClass('active');
            }
            if (cur_pos < 200) {
                $(".nav-menu ul:first li:first").addClass('active');
            }
        });
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });

    // Skills section
    $('.skills-content').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {
        offset: '80%'
    });

    // Init AOS
    function aos_init() {
        AOS.init({
            duration: 1000,
            once: true
        });
    }

    // Porfolio isotope and filter
    $(window).on('load', function () {
        var portfolioIsotope = $('.portfolio-container').isotope({
            itemSelector: '.portfolio-item'
        });

        $('#portfolio-flters li').on('click', function () {
            $("#portfolio-flters li").removeClass('filter-active');
            $(this).addClass('filter-active');

            portfolioIsotope.isotope({
                filter: $(this).data('filter')
            });
            aos_init();
        });


        // Initiate aos_init() function
        aos_init();

    });

})(jQuery);


// Theme toggle (light/dark) — applies CSS variable theme in real time
(() => {
    const STORAGE_KEY = "theme"; // "light" | "dark"
    const ROOT = document.documentElement;

    function setSwitchUI(isDark) {
        const btn = document.getElementById("themeToggle");
        if (!btn) return;

        // Visual state
        btn.classList.toggle("ant-switch-checked", isDark);
        btn.setAttribute("aria-checked", isDark ? "true" : "false");

        // Ensure basic switch semantics (safe even if already present)
        if (!btn.hasAttribute("role")) btn.setAttribute("role", "switch");
        if (!btn.hasAttribute("tabindex")) btn.setAttribute("tabindex", "0");

        // Optional icon flip (moon when dark, sun when light)
        const icon = document.getElementById("themeToggleIcon");
        if (icon) {
            icon.classList.toggle("bx-moon", isDark);
            icon.classList.toggle("bx-sun", !isDark);
        }
    }

    function applyTheme(theme, { persist = true } = {}) {
        const isDark = theme === "dark";

        // CSS hook: styles.css defines [data-theme="dark"] variable overrides
        if (isDark) ROOT.setAttribute("data-theme", "dark");
        else ROOT.removeAttribute("data-theme");

        setSwitchUI(isDark);

        if (persist) {
            try { localStorage.setItem(STORAGE_KEY, theme); } catch (_) {}
        }
    }

    function getInitialTheme() {
        try {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored === "dark" || stored === "light") return stored;
        } catch (_) {}

        // Fall back to system preference
        return window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
    }

    function toggleTheme() {
        const isDark = ROOT.getAttribute("data-theme") === "dark";
        applyTheme(isDark ? "light" : "dark");
    }

    // Init on DOM ready (in case the toggle is rendered late in the page)
    document.addEventListener("DOMContentLoaded", () => {
        applyTheme(getInitialTheme(), { persist: false });

        // Click + keyboard accessibility
        document.addEventListener("click", (e) => {
            const btn = e.target.closest("#themeToggle");
            if (!btn) return;
            toggleTheme();
        });

        document.addEventListener("keydown", (e) => {
            const btn = e.target.closest && e.target.closest("#themeToggle");
            if (!btn) return;
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                toggleTheme();
            }
        });
    });
})();
