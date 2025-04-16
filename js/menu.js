/**
 * AutoFocus Theme Menu JavaScript
 * Handles toggling the menu for small screens
 */
(function($) {
    'use strict';
    
    // Toggle menu on small screens
    $(document).ready(function() {
        var $menu = $('#menu');
        var $menuToggle = $('.menu-toggle');
        
        $menuToggle.on('click', function(e) {
            e.preventDefault();
            $menu.toggleClass('toggled-on');
            $menuToggle.attr('aria-expanded', $menu.hasClass('toggled-on'));
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$menu.is(e.target) && $menu.has(e.target).length === 0 && !$menuToggle.is(e.target)) {
                $menu.removeClass('toggled-on');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
        
        // Add dropdown toggle buttons to menu items with children
        $menu.find('li:has(ul)').children('a').append('<button class="dropdown-toggle" aria-expanded="false">' +
            '<span class="screen-reader-text">' + autofocusScreenReaderText.expand + '</span></button>');
        
        // Toggle sub-menus
        $menu.find('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $parent = $this.parent();
            var $subMenu = $parent.next('ul');
            
            $subMenu.toggleClass('toggled-on');
            $this.attr('aria-expanded', $subMenu.hasClass('toggled-on'));
            $this.html('<span class="screen-reader-text">' + 
                ($subMenu.hasClass('toggled-on') ? autofocusScreenReaderText.collapse : autofocusScreenReaderText.expand) + 
                '</span>');
        });
        
        // Home page image hover effects
        $('.home .featured.post').hover(
            function() {
                $(this).find('.post-content').css('visibility', 'visible').stop().animate({opacity: 0.7}, 200);
            },
            function() {
                $(this).find('.post-content').stop().animate({opacity: 0}, 200, function() {
                    $(this).css('visibility', 'hidden');
                });
            }
        );
        
        // Make images responsive
        $('.entry-content img, .comment-content img').addClass('img-responsive');
        
        // Responsive videos
        $('.entry-content iframe[src*="youtube"], .entry-content iframe[src*="vimeo"]').wrap('<div class="video-container"></div>');
    });
    
    // Add resize handler for menu
    $(window).on('resize', function() {
        if (window.innerWidth > 767) {
            $('#menu').removeClass('toggled-on');
            $('.menu-toggle').attr('aria-expanded', 'false');
        }
    });
    
})(jQuery);