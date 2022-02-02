$(document).ready(function() {
    
    "use strict";
    const submenu_animation_speed = 200;

    const sidebar = function() {
        var select_sub_menus = $('.accordion-menu li:not(.open) ul'),
            active_page_sub_menu_link = $('.accordion-menu li.active-page > a');
        
        // Hide all sub-menus
        select_sub_menus.hide();

        const container = document.querySelector('.page-sidebar');
        const ps = new PerfectScrollbar(container);

        
        // Accordion
        $('.accordion-menu li a').on('click', function(e) {
            var sub_menu = $(this).next('ul'),
                parent_list_el = $(this).parent('li'),
                active_list_element = $('.accordion-menu > li.open'),
                show_sub_menu = function() {
                    sub_menu.slideDown(submenu_animation_speed);
                    parent_list_el.addClass('open');
                    ps.update();
                },
                hide_sub_menu = function() {
                    sub_menu.slideUp(submenu_animation_speed);
                    parent_list_el.removeClass('open');
                    ps.update();
                },
                hide_active_menu = function() {
                    $('.accordion-menu > li.open > ul').slideUp(submenu_animation_speed);
                    active_list_element.removeClass('open');
                    ps.update();
                };
            
            if(sub_menu.length) {
                console.log(sub_menu.length);
                
                if(!parent_list_el.hasClass('open')) {
                    if(active_list_element.length) {
                        hide_active_menu();
                    };
                    show_sub_menu();
                } else {
                    hide_sub_menu();
                };
                
                return false;
                
            };
            // e.preventDefault();
            // return false;
        });
        
        if($('.active-page > ul').length) {
            active_page_sub_menu_link.click();
        };


    };

    function toggleSidebar() {
        $('body').toggleClass("sidebar-hidden");
    };

    $('#sidebar-toggle').on('click', function() {
        toggleSidebar();
    });
    
    (function(){ 
        feather.replace()
    })();

    function global() {

        $('[data-bs-toggle="popover"]').popover();
        $('[data-bs-toggle="tooltip"]').tooltip(); // gives the scroll position


        // Form Validation
        var forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
    }


    sidebar();
    global();
});


$(window).on("load", function () {
    setTimeout(function() {
    $('body').addClass('no-loader')}, 1000)
});