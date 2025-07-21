$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sorting Filter
    $("#sort").on('change', function () {
        // picking two things one is sort it self and another is filter_products class


        var sort = $(this).val();
        // alert(sort);
        var brand = get_filter('brand');
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var url = $('#url').val();

        $.ajax({
            url: url,
            method: 'post',
            data: { brand: brand, fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    });


    //Sidebar Filters

    $(".brand").on('click', function () {
        var brand = get_filter('brand');
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { brand: brand, fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })


    $(".fabric").on('click', function () {
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })

    $(".sleeve").on('click', function () {
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })

    $(".pattern").on('click', function () {
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })

    $(".fit").on('click', function () {
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })

    $(".occasion").on('click', function () {
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $("#sort option:selected").val();
        var url = $('#url').val();
        $.ajax({
            url: url,
            method: 'post',
            data: { fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);
            }
        })
    })
    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }


    //Get Price Attributes Size
    $('#getPrice').change(function () {
        var size = $(this).val();
        if (size == "") {
            alert("please select size");
            return false;
        }
        var product_id = $(this).attr('product-id'); //Getting the product id
        $.ajax({
            url: "/get-product-price",
            data: { size: size, product_id: product_id },
            type: 'post',
            success: function (resp) {

                // alert(resp['product_price']);
                // alert(resp['discounted_price']);
                // return false;

                if (resp['final_price'] < resp['product_price']) {
                    $(".getAttrPrice").html("Rs. " + resp['final_price'] + "<del class='text-danger'> <h4> Rs." + resp['product_price'] + " </h4></del>");
                } else {
                    $(".getAttrPrice").html("Rs. " + resp['product_price']);
                }

            }, else: function () {
                alert("Error");
            }
        });
    });


    // /*********************  Append attributes Level ***********************/
    $('#getPrice').change(function () {
        var getPrice = $(this).val();
        // alert(getPrice);
        var product_id = $(this).attr('product-id'); //Getting the product id
        $.ajax({
            type: 'post',
            url: '/get-attribute-color',
            data: { getPrice: getPrice, product_id: product_id },
            success: function (resp) {
                $("#getColor").html("");
                for (let i = 0; i < resp.length; i++) {
                    $("#getColor").append("<option value='" + resp[i].id + "'>" + resp[i].color + "</option>");
                }

            }, error: function () {
                aler("Error");
            }
        });
    });

    //Update Cart Items
    $(document).on('click', '.btnItemUpdate', function () {
        // alert('Hello');
        if ($(this).hasClass('qtyMinus')) {
            // if quantity minus button gets click by user
            var quantity = $(this).prev().val();
            if (quantity <= 1) {
                alert("Item quantity must be 1 or greater!");
                return false;
            } else {
                new_qty = parseInt(quantity) - 1;
                // alert(new_qty);
            }
        }
        if ($(this).hasClass('qtyPlus')) {
            // if quantity plus button gets click by user
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity) + 1;
        }
        // alert(new_qty);
        var cartid = $(this).data('cartid');
        // alert(cartid);
        $.ajax({
            data: { 'cartid': cartid, 'qty': new_qty },
            url: '/update-cart-item-qty',
            type: 'post',
            success: function (resp) {

                if (resp.status == false) {
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems + " Items");
                $("#AppendCartItems").html(resp.view);
            }, error: function () {
                alert('Error');
            }
        });
    });

    //Delete Cart Items
    $(document).on('click', '.btnItemDelete', function () {
        var cartid = $(this).data('cartid');
        // alert(cartid); return false;
        var result = confirm("Want to delete this cart item");
        if (result) {
            $.ajax({
                data: { 'cartid': cartid },
                url: '/delete-cart-item',
                type: 'post',
                success: function (resp) {
                    $(".totalCartItems").html(resp.totalCartItems + " Items");
                    $("#AppendCartItems").html(resp.view);
                }, error: function () {
                    alert('Error');
                }
            });
        }
    });


    // //Delete Reminder List Items
    // $(document).on('click', '.btnDelete', function () {
    //     var reminderid = $(this).data('reminderid');
    //     // alert(reminderid); return false;
    //     var result = confirm("Want to delete this cart item");
    //     if (result) {
    //         $.ajax({
    //             data: { 'reminderid': reminderid },
    //             url: '/delete-reminder-item',
    //             type: 'post',
    //             success: function (resp) {
    //                 // $(".totalCartItems").html(resp.totalCartItems + " Items");
    //                 $("#AppendReminderItems").html(resp.view);
    //             }, error: function () {
    //                 alert('Error');
    //             }
    //         });
    //     }
    // });


    // validate signup form on keyup and submit
    $("#registerForm").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true,
                minlength: 3,
            },
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true,
            },
            email: {
                required: true,
                email: true,
                remote: "check-email",
            },
            password: {
                required: true,
                minlength: 8
            },

        },
        messages: {
            name: {
                required: "Please enter your name",
                lettersonly: "Please enter valid name",
                minlength: "Name should be greater than 3 character"
            },
            mobile: {
                required: "Please enter a mobile number",
                minlength: "Your mobile must consist of at least 11 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },

            email: {
                required: "Email is required",
                email: "Please enter valid email address ",
                remote: "Email already exists",
            }

        }
    });


    // validate login form on keyup and submit
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,

            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Please enter valid email address ",
            },
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long"
            },
        }
    });


    // validate account form on keyup and submit
    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                // letters: { accept: "[a-zA-Z]+" },
            },
            mobile: {
                required: true,
                minlength: 14,
                maxlength: 14,
                digits: true,
            },

        },
        messages: {
            name: {
                required: "Please enter your name",
                // lettersonly: "Please enter valid name",
            },
            mobile: {
                required: "Please enter a mobile number",
                minlength: "Your mobile must consist of at least 14 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },

            email: {
                required: "Email is required",
                email: "Please enter valid email address ",
                remote: "Email already exists",
            }

        }
    });


    // validate user upadte password form on keyup and submit
    $("#passwordForm").validate({
        rules: {
            current_pwd: {
                required: true,
                minlength: 8

            },
            new_pwd: {
                required: true,
                minlength: 8
            },
            confirm_pwd: {
                required: true,
                minlength: 8,
                equalTo: "#new_pwd",
            },
        },

    });

    //checking the user current password
    $("#current_pwd").keyup(function () {
        var current_pwd = $(this).val();
        $.ajax({
            type: 'post',
            url: '/check-user-pwd',
            data: { current_pwd: current_pwd },
            success: function (resp) {
                // alert(resp);
                if (resp == 'false') {
                    $("#chkPwd").html("<font color='red'>Current password is incorrect</font>");
                } else if (resp == 'true') {
                    $("#chkPwd").html("<font color='green'>Current password is correct</font>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    // Rating Tab
    var $star_rating = $('.star-rating .fa');

    var SetRatingStar = function () {
        return $star_rating.each(function () {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };

    $star_rating.on('click', function () {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });

    SetRatingStar();
    $(document).ready(function () {


    });

    // Rating Tab
    var $star_rating = $('.star-rating .fa');

    // News letter

    $(document).ready(function () {
        if (localStorage.getItem('popState') != 'shown') {
            //Fade in delay for the background overlay (control timing here)
            $("#bkgOverlay").delay(4800).fadeIn(400);
            //Fade in delay for the popup (control timing here)
            $("#delayedPopup").delay(5000).fadeIn(400);
        }
        //Hide dialouge and background when the user clicks the close button
        $("#btnClose").click(function (e) {
            HideDialog();
            e.preventDefault();
        });

    });
    //Controls how the modal popup is closed with the close button
    function HideDialog() {
        $("#bkgOverlay").fadeOut(400);
        $("#delayedPopup").fadeOut(300);
    }

    // //Compare Pr9oducts
    // $(document).on('click', '.compare', function () {
    //     var id = $(this).attr('rel');

    //     var input = []; // initialise an empty array
    //     input.push(id);

    //     // alert(input.length); return false;
    //     if (input.length > 0) {
    //         alert("You have already selected maximum product");
    //     }
    // });

    // // Apply Coupon
    // $("#ApplyCoupon").submit(function () {

    //     alert("Test"); return false;
    //     var user = $(this).attr("user");
    //     if (user == 1) {
    //         //do nothing
    //     } else {
    //         alert("Please login to apply coupon!");
    //         return false;
    //     }
    //     var code = $("#code").val();
    //     $.ajax({
    //         type: 'post',
    //         data: { code: code },
    //         url: '/apply-coupon',
    //         success: function (resp) {

    //         },
    //         error: function () {
    //             alert("Error");
    //         }
    //     });
    // })


});