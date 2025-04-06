$(document).ready(function() {
    'use strict';

    // Initialize owl carousel for intro slider
    if ($.fn.owlCarousel) {
        $('.intro-slider').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            navText: ['<i class="icon-angle-left">', '<i class="icon-angle-right">'],
            dots: true,
            smartSpeed: 400,
            autoplay: true,
            autoplayTimeout: 15000
        });
    }

    // Smooth scroll to sections
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 72
            }, 600);
        }
    });

    // Skill level filter
    $('.skill-level').on('click', function() {
        $(this).toggleClass('active');
        filterProducts();
    });

    // Material filter
    $('.material-filter').on('click', function() {
        $(this).toggleClass('active');
        filterProducts();
    });

    function filterProducts() {
        var selectedSkills = $('.skill-level.active').map(function() {
            return $(this).text().toLowerCase();
        }).get();

        var selectedMaterials = $('.material-filter.active').map(function() {
            return $(this).text().toLowerCase();
        }).get();

        $('.product').each(function() {
            var product = $(this);
            var skills = product.data('skills') ? product.data('skills').toLowerCase().split(',') : [];
            var materials = product.data('materials') ? product.data('materials').toLowerCase().split(',') : [];

            var showProduct = 
                (selectedSkills.length === 0 || skills.some(s => selectedSkills.includes(s.trim()))) &&
                (selectedMaterials.length === 0 || materials.some(m => selectedMaterials.includes(m.trim())));

            product.toggle(showProduct);
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize popovers
    $('[data-toggle="popover"]').popover({
        trigger: 'hover'
    });

    // Back to top button
    var $backToTop = $('#scroll-top');

    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 400) {
            $backToTop.fadeIn();
        } else {
            $backToTop.fadeOut();
        }
    });

    $backToTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 600);
    });

    // Mobile menu toggle
    $('.mobile-menu-toggler').on('click', function() {
        $('body').addClass('mmenu-active');
    });

    $('.mobile-menu-overlay, .mobile-menu-close').on('click', function() {
        $('body').removeClass('mmenu-active');
    });

    // Add animation class to adventure cards on scroll
    function animateOnScroll() {
        $('.adventure-card').each(function() {
            var card = $(this);
            if (isElementInViewport(card) && !card.hasClass('animated')) {
                card.addClass('animated fadeInUp');
            }
        });
    }

    function isElementInViewport(el) {
        var rect = el[0].getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    $(window).on('scroll resize', animateOnScroll);
    animateOnScroll(); // Initial check
});