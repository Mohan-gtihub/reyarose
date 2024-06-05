$(function ($) {

    "use strict";

    function lazy() {
        $(".lazy").Lazy({
            scrollDirection: 'vertical',
            effect: "fadeIn",
            effectTime: 1000,
            threshold: 0,
            visibleOnly: false,
            onError: function (element) {
                console.log('error loading ' + element.data('src'));
            }
        });
    }

    $(document).ready(function () {

        lazy();


        function number_format(number, decimals = 2, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        // announcement banner magnific popup
        if (mainbs.is_announcement == 1) {
            $('.announcement-banner').magnificPopup({
                type: 'inline',
                midClick: true,
                mainClass: 'mfp-fade',
                callbacks: {
                    open: function () {
                        $.magnificPopup.instance.close = function () {
                            // Do whatever else you need to do here
                            sessionStorage.setItem("announcement", "closed");
                            // console.log(sessionStorage.getItem('announcement'));

                            // Call the original close method to close the announcement
                            $.magnificPopup.proto.close.call(this);
                        };
                    }
                }
            });
        }

        // Mobile Category
        $('#category_list .has-children .category_search span').on('click', function (e) {
            e.preventDefault();
        });

        // Toggle mobile serch
        $('.close-m-serch').on('click', function () {
            $('.topbar .search-box-wrap').toggleClass('d-none');
        });


        // Flash Deal Area Start
        var $hero_slider_main = $(".hero-slider-main");
        $hero_slider_main.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            items: 1,
            thumbs: false,
        });

        // heroarea-slider
        var $testimonialSlider = $('.heroarea-slider');
        $testimonialSlider.owlCarousel({
            loop: true,
            navText: [],
            nav: true,
            nav: true,
            dots: false,
            autoplay: true,
            thumbs: false,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                576: {
                    items: 1
                },
                950: {
                    items: 1
                },
                960: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        });


        // popular_category_slider
        var $popular_category_slider = $(".popular-category-slider");
        $popular_category_slider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            loop: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 4,
                },
                1400: {
                    items: 5
                }
            },
        });



        // Flash Deal Area Start
        var $flash_deal_slider = $(".flash-deal-slider");
        $flash_deal_slider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                },
                576: {
                    items: 1,
                    margin: 0,
                },
                768: {
                    items: 1,
                    margin: 0,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 2,
                },
                1400: {
                    items: 2,
                },
            },
        });


        // col slider
        var $col_slider = $(".newproduct-slider");
        $col_slider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            loop: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 1,
                },
                530: {
                    items: 1,
                },
            },
        });

        // col slider 2
        var $col_slider2 = $(".toprated-slider");
        $col_slider2.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            loop: true,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 1,
                },
                530: {
                    items: 1,
                },
            },
        });

        // newproduct-slider Area Start
        var $newproduct_slider = $(".features-slider");
        $newproduct_slider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            loop: false,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 4,
                },
                1400: {
                    items: 5
                }
            },
        });

        // home-blog-slider
        var $home_blog_slider = $(".home-blog-slider");
        $home_blog_slider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            loop: false,
            thumbs: false,
            margin: 15,
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 3,
                },
                1400: {
                    items: 4,
                }
            },
        });

        // toprated-slider Area Start
        var $relatedproductsliderv = $(".relatedproductslider");
        $relatedproductsliderv.owlCarousel({
            nav: false,
            navText: [],
            dots: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            margin: 15,
            thumbs: false,
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 4,
                },
                1400: {
                    items: 5
                }
            },
        });

        // Blog Details Slider Area Start
        var $hero_slider_main = $(".blog-details-slider");
        $hero_slider_main.owlCarousel({
            navText: [],
            nav: true,
            dots: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            items: 1,
            thumbs: false,
        });

        // Top navbar
        var $top_navbar = $(".top-navbar-slider");

        $top_navbar.owlCarousel({
            nav: false,
            dots: false,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            items: 1,
            thumbs: false,
        });


        // coupons-slider
        // coupons-slider
var $coupons_slider = $(".coupons-slider");
$coupons_slider.owlCarousel({
    navText: [],
    nav: true,
    dots: false,
    autoplayTimeout: 6000,
    smartSpeed: 1200,
    loop: true,
    thumbs: false,
    margin: 15,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        }
    }
});


        // brand-slider
        var $brandSlider = $(".brand-slider"); // Corrected class name
        $brandSlider.owlCarousel({
            navText: [],
            nav: true,
            dots: false,
            autoplayTimeout: 6000,
            smartSpeed: 1200,
            loop: true,
            thumbs: false,
            margin: 9,
            responsive: {
                0: {
                    items: 2,
                    nav: true,
                },
                575: {
                    items: 3,
                    nav: true,
                },
                790: {
                    items: 4,
                    nav: true,
                },
                1100: {
                    items: 5,
                    nav: true,
                },
                1200: {
                    items: 5,
                    nav: true,
                },
                1400: {
                    items: 6,
                    nav: true,
                }
            }
        });



        // Recent Blog Slider Area Start
        var $popular_category_slider = $(".resent-blog-slider");
        $popular_category_slider.owlCarousel({
            navText: [],
            nav: false,
            dots: true,
            loop: false,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            margin: 30,
            thumbs: false,
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 3,
                }
            },
        });



        // Product details main slider
        $('.product-details-slider').owlCarousel({
            loop: true,
            items: 1,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            autoplay: false,
            thumbs: true,
            dots: false,
            thumbImage: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            thumbContainerClass: 'owl-thumbs',
            thumbItemClass: 'owl-thumb-item',
        });

        // Product details image zoom
        $('.product-details-slider .item').zoom();

        // Video popup
        $('.video-btn a').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade'
        });



        $('.left-category-area .category-header').on('click', function () {
            $('.left-category-area .category-list').toggleClass("active")
        });


        // $("[data-date-time]").each(function () {
        //     var $this = $(this),
        //         finalDate = $(this).attr("data-date-time");
        //     $this.countdown(finalDate, function (event) {
        //         $this.html(
        //             event.strftime(
        //                 `<span>%D<small>${language.Days}</small></span></small> <span>%H<small>${language.Hrs}</small></span> <span>%M<small>${language.Min}</small></span> <span>%S<small>${language.Sec}</small></span>`
        //             )
        //         );
        //     });
        // });

        $("[data-date-time]").each(function () {
            var $this = $(this),
                finalDate = $this.attr("data-date-time");

            // Find countdown elements within the current product context
            var $days = $this.find('.days');
            var $hours = $this.find('.hours');
            var $minutes = $this.find('.minutes');
            var $seconds = $this.find('.seconds');

            // Initialize countdown for each set of elements
            $this.countdown(finalDate, function (event) {
                // Update the corresponding HTML elements with the countdown values
                $days.text(event.strftime('%D'));
                $hours.text(event.strftime('%H'));
                $minutes.text(event.strftime('%M'));
                $seconds.text(event.strftime('%S'));
            });
        });


        // Subscriber Form Submit
        $(document).on("submit", ".subscriber-form", function (e) {
            e.preventDefault();
            var $this = $(this);
            var submit_btn = $this.find("button");
            submit_btn.find(".fa-spin").removeClass("d-none");
            $this.find("input[name=email]").prop("readonly", true);
            submit_btn.prop("disabled", true);
            $.ajax({
                method: "POST",
                url: $(this).prop("action"),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $.magnificPopup.close();
                    if (data.errors) {
                        for (var error in data.errors) {
                            dangerNotification(data.errors[error]);
                        }
                    } else {
                        if ($this.hasClass("subscription-form")) {
                            $(".mfp-close").click();
                        }
                        successNotification(data);
                        $this.find("input[name=email]").val("");
                    }
                    submit_btn.find(".fa-spin").addClass("d-none");
                    $this.find("input[name=email]").prop("readonly", false);
                    submit_btn.prop("disabled", false);
                },
            });
        });
        // Subscriber Form Submit ENDS

        // Notifications
        let currentNotification = null;

        function showNotification(title, type) {
            // Check if there's an existing notification
            if (currentNotification) {
                // Close the existing notification
                currentNotification.close();
            }

            // Create a new notification
            currentNotification = $.notify({
                title: `<strong>${title}</strong>`,
                message: '',
                icon: type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle'
            }, {
                type: type,
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: function () {
                    // Clear the existing notification reference when the new one is shown
                    currentNotification = null;
                },
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class'
            });
        }

        // Example usage
        function successNotification(title) {
            showNotification(title, 'success');
        }

        function dangerNotification(title) {
            showNotification(title, 'danger');
        }

        // Notifications Ends




        $(document).on('click', '.list-view', function () {
            let viewCheck = $(this).attr('data-step');
            let check = $(this);
            $('.list-view').removeClass('active');
            $('#search_form #view_check').val(viewCheck);
            $("#search_button").click();
            check.addClass('active');
        })


        // category wise product 
        $(document).on('click', '.category_get,.product_get', function () {

            $('.' + this.className).removeClass('active');
            $(this).addClass('active');
            let geturl = $(this).attr('data-href');
            let view = $(this).attr('data-target');

            $('.' + view).removeClass('d-none');

            $.get(geturl, function (response) {
                $('#' + view).html(response);
                $('.' + view).addClass('d-none');

                if (response.data === undefined) {
                    $('.' + view + '_not_found').removeClass('d-none');
                } else {
                    $('.' + view + '_not_found').addClass('d-none');
                }

            });
        })


        // product quintity select js Start
        // $(document).on('click', '.subclick', function () {
        //     let current_qty = parseInt($('.cart-amount').val());
        //     if (current_qty > 1) {
        //         $('.cart-amount').val(current_qty - 1);
        //     } else {
        //         error('Minumum Quantity Must Be 1');
        //     }

        // })

        // // product quintity select js Start


        // $(document).on('click', '.addclick', function () {
        //     let current_stock = parseInt($('#current_stock').val());
        //     let current_qty = parseInt($('.cart-amount').val());
        //     if (current_qty < current_stock) {
        //         $('.cart-amount').val(current_qty + 1);
        //     } else {
        //         dangerNotification('Product Quantity Maximum ' + current_stock);
        //     }
        // })


        // $(document).on('click', '.subclick', function () {
        //     var $input = $(this).parent().find('.cart-qty');
        //     var currentVal = parseInt($input.val());
        //     let current_qty = currentVal;
        //     var minQty = parseInt($input.attr('min'));
        //     let multiple = parseInt($('.decrement').data('multiple')); // assuming decrement has the same multiple

        //     // Check if current quantity minus multiple is at least the minimum quantity allowed
        //     if (current_qty - multiple >= 1) {
        //         $('.cart-amount').val(current_qty - multiple);
        //     } else {
        //         $('.cart-amount').val(current_qty); // Reset to minimum if subtraction goes below 1
        //         dangerNotification('Minimum Quantity Must Be ' + current_qty); // Use a function that handles error messages if exists
        //     }
        // });

        $(document).on('click', '.subclick', function () {
            var $input = $(this).parent().find('.cart-qty');
            var currentVal = parseInt($input.val());
            let current_qty = currentVal; // This is redundant since `currentVal` already holds this value
            var minQty = parseInt($input.attr('min')) || 1; // Ensure there's a fallback if min attribute is not set
            let multiple = parseInt($('.decrement').data('multiple')) || 1; // Ensure there's a fallback if multiple is not set

            // Check if the current quantity minus multiple is at least the minimum quantity allowed
            if (current_qty - multiple >= minQty) {
                $input.val(current_qty - multiple); // Update the input field, not '.cart-amount'
            } else {
                $input.val(minQty); // Reset to minQty if subtraction goes below minQty
                dangerNotification('Minimum Quantity Must Be ' + minQty); // Show notification with correct minQty
            }
        });

        // Product quantity select JavaScript for incrementing
        // $(document).on('click', '.addclick', function () {
        $(document).on("click", ".addclick", function () {
            var $input = $(this).parent().find('.cart-qty');
            var currentVal = parseInt($input.val());
            let current_stock = parseInt($('#current_stock').val());
            let current_qty = currentVal;
            let multiple = parseInt($(this).data('multiple')); // Ensure 'multiple' data attribute is set correctly in HTML

            // Check if current quantity plus multiple is within stock limits
            if (current_qty + multiple <= current_stock) {
                $('.cart-amount').val(current_qty + multiple);
            } else {
                $('.cart-amount').val(current_stock); // Set to max stock if addition goes over
                dangerNotification('Product Quantity Maximum ' + current_stock); // Display a warning if stock limits are reached
            }
        });



        $(document).on('keyup', '.cart-amount', function () {
            let current_stock = parseInt($('#current_stock').val());
            let key_val = parseInt($(this).val());

            if (key_val > current_stock) {
                error('Product Maximum Quantity ' + current_stock);
                $('.cart-amount').val(current_stock);
            }
            if (key_val <= 0) {
                $('.cart-amount').val(1);
                error('Product Minimum Quantity' + 1);
            }
            if (key_val > 0 && key_val < current_stock) {
                $('.cart-amount').val(key_val);
            }

        })


        $(document).on('click', '.wishlist_store', function (e) {
            e.preventDefault();
            let wishlist_url = $(this).attr('href');
            $.get(wishlist_url, function (response) {
                if (response.status == 0) {
                    location.href = response.link;
                } else if (response.status == 2) {
                    dangerNotification(response.message);
                } else {
                    $('.wishlist1').addClass('d-none');
                    $('.wishlist2').removeClass('d-none');
                    $('.wishlist_count').text(response.count)
                    successNotification(response.message);
                }
            })
        })


        // catalog js start
        $(document).on("click", ".brand-select", function () {
            $('.brand-select').prop('checked', false);
            let brand = $(this).val();
            $(this).prop('checked', true);
            $("#search_form #brand").val(brand);
            removePage();
            $("#search_button").click();
        });

        $(document).on("click", "#price_filter", function () {
            let min_price = parseInt($(".min_price").html());
            let max_price = parseInt($(".max_price").html());
            $("#search_form #minPrice").val(min_price);
            $("#search_form #maxPrice").val(max_price);
            removePage();
            $("#search_button").click();
        });

        $(document).on("change", "#sorting", function () {
            let sorting = $(this).val();
            $("#search_form #sorting").val(sorting);
            removePage();
            $("#search_button").click();
        });

        $(document).on("click", ".widget_price_filter", function () {
            let filter_prices = $(this).val();
            if (filter_prices) {
                filter_prices = filter_prices.split(",");
                $("#search_form #minPrice").val(filter_prices[0]);
                $("#search_form #maxPrice").val(filter_prices[1]);
            } else {
                $("#search_form #minPrice").val('');
                $("#search_form #maxPrice").val('');
            }
            removePage();
            $("#search_button").click();
        });


        $(document).on('change', '#category_select', function () {
            let category = $(this).val();
            $('#search__category').val(category);
        })



        $(document).on('click', '#quick_filter li a', function () {
            $('#quick_filter li').removeClass('active');
            let filter = '';
            $(this).parent().addClass('active');
            if ($(this).attr('data-href')) {
                filter = $(this).attr('data-href');
            } else {
                filter = $(this).attr('data-href');
            }
            $("#search_form #quick_filter").val(filter);
            removePage();
            $("#search_button").click();
        });

        $(document).on('click', '#limit p', function () {
            $('#limit p').removeClass('active');
            let limit = '';
            $(this).addClass('active');
            if ($(this).attr('data-limit')) {
                limit = $(this).attr('data-limit');
            } else {
                limit = $(this).attr('data-limit');
            }

            $("#search_form #limit").val(limit);
            removePage();
            $("#search_button").click();
        });

        function removePage() {
            $("#search_form #page").val('');
        }

        $(document).on('keyup', '#__product__search', function () {
            let search = $(this).val();
            let category = '';
            category = $('#search__category').val();
            if (search) {
                let url = $(this).attr('data-target');
                $.get(url + '?search=' + search + '&category=' + category, function (response) {
                    $('.serch-result').removeClass('d-none');
                    $('.serch-result').html(response);
                })
            } else {
                $('.serch-result').addClass('d-none');
            }

        })
        $(document).on('click', '#view_all_search_', function () {
            $('#header_search_form').submit();
        })

        $(document).on('click', '#category_list li a.category_search', function () {
            $('#category_list li').removeClass('active');
            let category = '';
            $(this).parent().addClass('active');
            if ($(this).attr('data-href')) {
                category = $(this).attr('data-href');
            } else {
                category = $(this).attr('data-href');
            }
            removePage();
            $("#search_form #childcategory").val('');
            $("#search_form #subcategory").val('');
            $("#search_form #category").val(category);
            $("#search_button").click();
        });


        $(document).on('click', '#subcategory_list li a.subcategory', function () {
            $('#subcategory_list li').removeClass('active');
            let category = '';
            $(this).parent().addClass('active');
            if ($(this).attr('data-href')) {
                category = $(this).attr('data-href');
            } else {
                category = $(this).attr('data-href');
            }
            $("#search_form #childcategory").val('');
            $("#search_form #subcategory").val(category);
            $("#search_button").click();
        });

        $(document).on('click', '#childcategory_list li a.childcategory', function () {
            $('#childcategory_list li').removeClass('active');
            let childcategory = '';
            $(this).parent().addClass('active');
            if ($(this).attr('data-href')) {
                childcategory = $(this).attr('data-href');
            } else {
                childcategory = $(this).attr('data-href');
            }
            removePage();
            $("#search_form #childcategory").val(childcategory);
            $("#search_button").click();
        });

        $(document).on('click', '#item_pagination .page-item .page-link', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            if (href) {
                let url = new URL(href);
                let page = url.searchParams.get("page");
                $("#search_form #page").val(page);
                $("#search_button").click();
            } else {
                // Handle the cases for next and previous buttons without href
                let pagination = $(this).text().trim();
                let lastActive = parseInt($('#item_pagination .page-item.active .page-link').text());
                if (pagination === '»') {
                    pagination = lastActive + 1;
                } else if (pagination === '«') {
                    pagination = lastActive - 1;
                }
                $("#search_form #page").val(pagination);
                $("#search_button").click();
            }
        });


        $(document).on('click', '.option', function () {

            let option = [];
            $(this).parent().addClass('active');
            $("input.option").each(function (index) {
                if ($(this).is(':checked')) {
                    option.push($(this).val());
                }
            });
            removePage();
            $("#search_form #option").val(option);
            $("#search_button").click();
        });

        $(document).on('submit', '#search_form', function (e) {
            e.preventDefault();

            let loader = `
            <div id="view_loader_div" class="">
            <div class="product-not-found">
              <img class="loader_image" src="${mainurl + '/assets/images/ajax_loader.gif'}" alt="">
            </div>
          </div>
            `;
            $('#list_view_ajax').html(loader);

            let form_url = $(this).attr('action');
            let method = $(this).attr('method');
            $.ajax({
                type: method,
                url: form_url,
                data: $(this).serialize(),
                success: function (response) {
                    window.scrollTo(0, 0);
                    $('#list_view_ajax').html(response.html);

                    // Update the results information
                    $('#results-first-item').text(response.firstItem);
                    $('#results-last-item').text(response.lastItem);
                    $('#results-total').text(response.total);
                    $(".cat-prod-img").hover(
                        function () {
                            var secondImage = $(this).data("src-2");
                            if (secondImage) {
                                $(this).data("src-original", $(this).attr("src"));
                                $(this).attr("src", secondImage);
                            }
                        },
                        function () {
                            var originalImage = $(this).data("src-original");
                            if (originalImage) {
                                $(this).attr("src", originalImage);
                            }
                        }
                    );
                }
            });

        })

        // catalog script end

        // rating from submit
        $(".ratingForm").on("submit", function (e) {
            e.preventDefault();
            var $this = $(this);
            var submit_btn = $this.find("button");
            submit_btn.find(".fa-spin").removeClass("d-none");
            $this.find("textarea").prop("readonly", true);
            submit_btn.prop("disabled", true);
            $.ajax({
                method: "POST",
                url: $(this).prop("action"),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var error in data.errors) {
                            dangerNotification(data.errors[error]);
                        }
                    } else {
                        successNotification(data);
                        $this.find("textarea").val("");
                    }

                    $this.find("textarea").prop("readonly", false);
                    submit_btn.prop("disabled", false);
                    $(".modal_close").click();
                },
            });
        });
        // compare script start

        $(document).on("click", ".product_compare", function () {
            let compare_url = $(this).attr("data-target");
            $.get(compare_url, function (data) {
                if (data.status == 1) {
                    successNotification(data.message);
                } else {
                    dangerNotification(data.message);
                }
                $(".compare_count").text(data.compare_count);
            });
        });

        $(document).on("click", ".compare_remove", function () {
            let removeUrl = $(this).attr("data-href");
            $.get(removeUrl, function () {
                location.reload();
            });
        });
        // compare script end

        // cart script start
        $(document).on("change", ".attribute_option", function () {
            getData();
        });


        $(document).on("keyup", ".cart-amount", function () {
            getData();
        });
        // $(document).on("click", ".increaseQty", function () {
        //     getData();
        // });
        $(document).on("click", ".increaseQtycart", function () {
            let item_key = $(this).attr('data-target');
            let item_id = $(this).attr('data-id');
            let item = $(this).attr('data-item');
            let newOptionArray = item.split(',');
            let qty = parseInt($(this).parent().find('input').val()) + 1;
            cartSubmit(item_key, item_id, qty, newOptionArray);
            // getData(0,0,0,0,0,);
        });

        // $(document).on("click", ".decreaseQty", function () {
        //     getData();
        // });


        $(document).on("click", ".decreaseQtycart", function () {
            let item_key = $(this).attr('data-target');
            let item_id = $(this).attr('data-id');
            
            var $input = $(this).parent().find('.qtyValue');

            var minQty = parseInt($input.attr('min')) || 1;
            
            let qty = parseInt($(this).parent().find('input').val()) - 1;

            if (qty >= minQty) {
                cartSubmit(item_key, item_id, qty);
                getData();
            } else {
                $input.val(minQty); 
                dangerNotification('Minimum Quantity Must Be ' + minQty);
            }

        });

        $(document).on("click", ".increaseQty", function () {
            var $input = $(this).parent().find('.cart-qty');
            var currentVal = parseInt($input.val());
            var multiple = parseInt($(this).data('multiple'));
            if (!isNaN(currentVal) && multiple > 0) {
                var newQuantity = currentVal + multiple;
                $input.val(newQuantity);

                // Directly pass the newQuantity to getData instead of relying on getQuantity
                getData(0, 0, 0, newQuantity, 0);
            }
        });

        // $(document).on("click", ".decreaseQty", function () {
        //     var $input = $(this).parent().find('.cart-qty');
        //     var currentVal = parseInt($input.val());
        //     var multiple = parseInt($(this).data('multiple'));
        //     var minQty = parseInt($input.attr('min'));

        //     if (!isNaN(currentVal) && multiple > 0 && currentVal > minQty) {

        //         if (minQty > 1) {
        //             var newQty = Math.max(currentVal - multiple, minQty);
        //             $input.val(newQty);
        //         } else {
        //             dangerNotification('Minumum Quantity Must Be ' + minQty);
        //         }

        //         getData(0, 0, 0, newQty, 0); // Updated call with new quantity
        //     }
        // });

        $(document).on("click", ".decreaseQty", function (event) {
            event.preventDefault(); // Prevent any default action from occurring

            var $input = $(this).parent().find('.cart-qty');
            var currentVal = parseInt($input.val());
            var multiple = parseInt($(this).data('multiple'));
            var minQty = parseInt($input.attr('min'));

            if (!isNaN(currentVal) && multiple > 0) {
                var newQty = currentVal;

                if (newQty >= minQty) {
                    $input.val(newQty);
                    getData(0, 0, 0, newQty, 0); // Updated call with new quantity
                } else if (minQty > 1) {
                    $input.val(minQty); // Ensure minimum quantity
                    getData(0, 0, 0, minQty, 0); // Updated call with minimum quantity
                } else {
                    getData(0, 0, 0, minQty, 0);
                    dangerNotification('Minimum Quantity Must Be ' + minQty);
                }
            }
        });




        $(document).on("click", "#add_to_cart", function () {
            getData(1);
        });
        $(document).on("click", "#but_to_cart", function () {
            getData(1, 0, 0, 0, 1);
        });
        $(document).on("click", ".add_to_single_cart", function () {
            getData(1, $(this).attr("data-target"));
        });

        function cartSubmit(item_key, item_id, cartQty, newOptionArray) {
            getData(1, item_key, item_id, cartQty, 0, newOptionArray);
        };

        function getBulkPrice(quantity) {
            var defaultPrice = parseFloat($("#demo_price").val());
            var price = defaultPrice; // Default price if no bulk discount applies

            if (typeof bulkDiscounts !== 'undefined' && Array.isArray(bulkDiscounts) && bulkDiscounts.length > 0) {
                bulkDiscounts.forEach(function (detail) {
                    if (quantity >= detail.items) {
                        price = detail.price;
                    }
                });
            }
            return price;
        }


        function getData(status = 0, check = 0, item_key = 0, qty = 0, add_type = 0, optionIds = null) {

            let itemId;
            let type;
            if (check != 0) {
                itemId = check;
                type = 1;
            } else {
                itemId = $("#item_id").val();
                type = 0;
            }


            let options_prices = optionPrice();


            let totalOptionPrice = parseFloat(optionPriceSum(options_prices));


            let attribute_ids = $(".attribute_option :selected")
                .map(function (i, el) {
                    return $(el).attr("data-type");
                })
                .get();


            if (optionIds != null) {
                var options_ids = optionIds;
            } else {

                var options_ids = $(".attribute_option :selected")
                    .map(function (i, el) {
                        return $(el).attr("data-href");
                    })
                    .get();
            }


            // Use the passed qty if it's provided and nonzero, otherwise, get from getQuantity()
            let quantity = qty > 0 ? qty : parseInt(getQuantity());

            if (isNaN(quantity) || quantity <= 0) {
                quantity = 1; // Ensure quantity is always at least 1
            }

            // Alert for debugging
            let setCurrency = $("#set_currency").val();
            let currency_direction = $("#currency_direction").val();

            // Get bulk price based on the quantity
            let bulkPrice = getBulkPrice(quantity);

            // Calculate main price
            let subPrice = parseFloat(bulkPrice) + totalOptionPrice;
            let mainPrice = subPrice * quantity;
            mainPrice = number_format(mainPrice, 2, decimal_separator, thousand_separator);

            // if (currency_direction == 0) {
            //     $('#main_price').html(mainPrice + setCurrency);
            // } else {
            //     $('#main_price').html(setCurrency + mainPrice);
            // }

            if (status == 1) {
                let addToCartUrl = `${mainurl}/product/add/cart?item_id=${itemId}&options_ids=${options_ids}&attribute_ids=${attribute_ids}&quantity=${quantity}&type=${type}&item_key=${item_key}&add_type=${add_type}`;
                $.ajax({
                    type: "GET",
                    url: addToCartUrl,
                    success: function (data) {

                        if (data.status == 'outStock') {
                            dangerNotification(data.message);
                        } else if (data.status == 'alreadyInCart') {
                            dangerNotification(data.message);
                        } else {
                            $(".cart_count").text(data.qty);
                            $(".cart_view_header").load(
                                $("#header_cart_load").attr("data-target")
                            );
                            if (qty) {
                                $("#view_cart_load").load(
                                    $("#cart_view_load").attr("data-target")
                                );
                            }
                            if (add_type == 1) {
                                location.href = mainurl + '/cart';
                            } else {
                                if(location.href == mainurl + '/cart'){
                                    successNotification(data.message);
                                }else{
                                    openOffcanvas();
                                }
                                
                            }
                        }


                    },
                });
            }
        }

        function optionPrice() {
            let option_prices = $(".attribute_option :selected")
                .map(function (i, el) {
                    return $(el).attr("data-target");
                })
                .get();

            return option_prices;
        }

        function getQuantity() {
            let quickQtyValue = $(".quickQtyValue").val();
            let quantity = $(".qtyValue").val();
            if (quickQtyValue !== undefined && quickQtyValue !== null && quickQtyValue.trim() !== "") {
                quantity = $(".quickQtyValue").val();
            }
            return parseInt(quantity);
        }

        function optionPriceSum(options_prices) {
            var price = 0;
            $.each(options_prices, function (i, v) {
                price += parseFloat(v);
            });
            return price;
        }

        // cart script end
        $(document).on("submit", "#coupon_form", function (e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr("action");
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (data) {
                    if (data.status == true) {
                        successNotification(data.message);
                        $("#view_cart_load").load(
                            $("#cart_view_load").attr("data-target")
                        );
                    } else {
                        dangerNotification(data.message);
                    }
                },
            });
        });

        // user panel script start
        $(document).on("change", "#avater", function () {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#avater_photo_view").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        });


        $('#submit_number').on('click', function (e) {
            var link = $(this).data('href') + '?order_number=' + $('#order_number').val();
            $('#track-order').load(link);
            return false;
        });

        $(document).ready(function () {
            $('.coupons-slider').on('click', '.slider-item', function () {
                var couponValue = $(this).find('img').data('coupon');

                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(couponValue).select();
                document.execCommand('copy');
                tempInput.remove();

                successNotification('Coupon code copied: ' + couponValue);
            });

            $('.qtyValue').on('input', function () {
                var currentQuantity = $(this).val();
            });




            // brand-slider
            var $brandslider = $(".brandslider");
            $brandslider.owlCarousel({
                nav: true,
                navText: [],
                dots: false,
                autoplayTimeout: 6000,
                smartSpeed: 1200,
                loop: true,
                thumbs: false,
                margin: 9,
                responsive: {
                    0: {
                        items: 2,
                    },
                    575: {
                        items: 3,
                    },
                    790: {
                        items: 4,
                    },
                    1100: {
                        items: 5,
                    },
                    1200: {
                        items: 5,
                    },
                    1400: {
                        items: 6,
                    }
                },
            });
        });

    });




});


// state price set up 

$(document).on('change', '#state_id_select', function () {
    var url = $('option:selected', this).attr('data-href');
    var state_id = $(this).val();
    $.get(url, function (response) {
        $('.set__state_price_tr').removeClass('d-none');
        $('.set__state_price').text(response.state_price);
        $('.grand_total_set').text(response.grand_total);

        $('.state_id_setup').val(state_id);
    })
})




$(document).on('click', '#trams__condition', function () {
    if ($(this).is(':checked')) {
        $('#continue__button').attr('type', 'submit');
        $('#continue__button').prop('disabled', false);
    } else {
        $('#continue__button').attr('type', 'button');
        $('#continue__button').prop('disabled', true);
    }
})



$(window).on('load', function (event) {
    // Preloader
    // $('#preloader').fadeOut(500);
    $("#preloader").fadeOut(700);
    $(".preloader-bg").delay(700).fadeOut(700);
    // announcement
    if (mainbs.is_announcement == 1) {
        // trigger announcement banner base on sessionStorage
        let announcement = sessionStorage.getItem('announcement') != null ? false : true;
        if (announcement) {
            setTimeout(function () {
                $('.announcement-banner').trigger('click');
            }, mainbs.announcement_delay * 1000);
        }
    }

});

function openOffcanvas() {
    var offcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
    offcanvas.show();
}