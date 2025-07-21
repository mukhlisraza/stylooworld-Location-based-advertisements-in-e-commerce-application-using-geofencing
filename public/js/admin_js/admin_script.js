$(document).ready(function () {
    //checking whatever the current password is correct or not

    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            type: 'post', // type 
            url: '/admin/check-current-pwd', // create route function
            data: { current_pwd: current_pwd }, // passing this data
            success: function (resp) {

                if (resp == "false") {
                    $("#chkCurrentPwd").html("<font color=red> Current password is incorrect</font>");
                } else if (resp == "true") {
                    $("#chkCurrentPwd").html("<font color=green> Current password is correct</font>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });


    /*********************  Update Section Status Active, Inactive ***********************/
    // $(".updateSectionStatus").click(function () {
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: { status: status, section_id: section_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#section-" + section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });


    /*********************  Update Brand Status ***********************/
    // $(".updateBrandStatus").click(function () {
    $(document).on("click", ".updateBrandStatus", function () {
        var status = $(this).children("i").attr("status");
        // alert(status); return false;
        var brand_id = $(this).attr("brand_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-brand-status',
            data: { status: status, brand_id: brand_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#brand-" + brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#brand-" + brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    /*********************  Update Categories Status Active, Inactive ***********************/
    // $(".updateCategoryStatus").click(function () {
    $(document).on("click", ".updateCategoryStatus", function () {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: { status: status, category_id: category_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    /*********************  Product Attribute  ***********************/
    // $(".updateAttributeStatus").click(function () {
    $(document).on("click", ".updateAttributeStatus", function () {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: { status: status, attribute_id: attribute_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#attribute-" + attribute_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#attribute-" + attribute_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    // /*********************  Append Categories Level ***********************/
    $('#section_id').change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: { section_id: section_id },
            success: function (resp) {
                $("#appendCategoriesLevel").html(resp);
            }, error: function () {
                aler("Error");
            }
        });
    });

    //confirm deletion with sweet alerts
    // $(".confirmDelete").click(function () {
    $(document).on("click", ".confirmDelete", function () {
        var record = $(this).attr("record"); //record means module in which module we are working categories, sections or products etc.
        var recordid = $(this).attr("recordid"); //is product_id, category_id, section_id etc. it's id
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                window.location.href = "/admin/delete-" + record + "/" + recordid;
            }
        });

    });



    /*********************  Update product Status Active, Inactive ***********************/
    // $(".updateProductStatus").click(function () {
    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: { status: status, product_id: product_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });


    /*********************  Update Users Status Active, Inactive ***********************/
    // $(".updateProductStatus").click(function () {
    $(document).on("click", ".updateUserStatus", function () {
        var status = $(this).children("i").attr("status");
        var user_id = $(this).attr("user_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-user-status',
            data: { status: status, user_id: user_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#user-" + user_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#user-" + user_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    /*********************  Update Vendor Status Active, Inactive ***********************/
    // $(".updateProductStatus").click(function () {
    $(document).on("click", ".updateVendorStatus", function () {
        var status = $(this).children("i").attr("status");
        var vendor_id = $(this).attr("vendor_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-vendor-status',
            data: { status: status, vendor_id: vendor_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#vendor-" + vendor_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#vendor-" + vendor_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    /*************************** Product Attributes Add/Remove Fields**************************/
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" value="" style="width:120px" placeholder="Size"/>&nbsp;<input type="text" name="price[]" value="" style="width:120px" placeholder="Price"/>&nbsp;<input type="text" name="stock[]" value="" style="width:120px" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button">&nbsp;<i class="fas fa-minus-square text-danger"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    /*************************** Product Colors Add/Remove Fields**************************/
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.addColor_button'); //Add button selector
    var wrapper1 = $('.field_wrapper1'); //Input field wrapper
    var fieldHTML1 = '<div><div style="height:10px;"></div><input type="text" name="size[]" value="" style="width:120px" placeholder="Color"/>&nbsp;<input type="text" name="stock[]" value="" style="width:120px" placeholder="Stock"/><a href="javascript:void(0);" class="removeColor_button">&nbsp;<i class="fas fa-minus-square text-danger"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper1).append(fieldHTML1); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper1).on('click', '.removeColor_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    /*********************  Update Image Status Active, Inactive ***********************/

    // $(".updateImageStatus").click(function () {
    $(document).on("click", ".updateImageStatus", function () {
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        // alert(status);
        // alert(section_id);

        $.ajax({
            type: 'post',
            url: '/admin/update-image-status',
            data: { status: status, image_id: image_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#image-" + image_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#image-" + image_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });


    /*********************  Update Banner Status Active, Inactive ***********************/
    $(document).on("click", ".updateBannerStatus", function () {
        var status = $(this).children("i").attr("status");
        var banners_id = $(this).attr("banners_id");

        $.ajax({
            type: 'post',
            url: '/admin/update-banner-status',
            data: { status: status, banners_id: banners_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#banners-" + banners_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#banners-" + banners_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });

    /*********************  Update Coupon Status Active, Inactive ***********************/
    $(document).on("click", ".updateCouponstatus", function () {
        var status = $(this).children("i").attr("status");
        var coupon_id = $(this).attr("coupon_id");

        $.ajax({
            type: 'post',
            url: '/admin/update-coupon-status',
            data: { status: status, coupon_id: coupon_id },
            success: function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp["status"] == 0) {
                    $("#coupon-" + coupon_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                } else if (resp["status"] == 1) {
                    $("#coupon-" + coupon_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error: function () {
                alert("Error");
            }
        });
    });


    // Show/Hide Coupon Field For Manual/Automatic
    $("#ManaulCoupon").click(function () {
        $("#couponField").show();
    });
    $("#AutomaticCoupon").click(function () {
        $("#couponField").hide();
    });


    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    // Add Edit Product Form Validation
    $("#productForm").validate({
        rules: {

            category_id: {
                required: true,
            },
            product_name: {
                required: true,
            },
            brand_id: {
                required: true,
            },
            product_Actual_price: {
                required: true,
            },
            product_price: {
                required: true,
                digits: true,
            },
            product_weight: {
                required: true,
                digits: true,
            },


        },
        messages: {

            category_id: {
                required: "Please select category",
            },
            product_name: {
                required: "Product name is required",
            },
            brand_id: {
                required: "Please select brand",
            },
            product_Actual_price: {
                required: "Product actual price is required",
            },
            product_price: {
                required: "Please enter product price",

            },
            product_weight: {
                required: "Product weight is required",
            },
        }
    });

    // vendor Form Validation
    $("#verdorRegisterForm").validate({
        rules: {

            business_name: {
                required: true,
            },
            business_address: {
                required: true,
            },
            name: {
                required: true,
                minlength: 3,

            },
            phone: {
                required: true,
                maxlength: 11,
                minlength: 11,
                digits: true,
            },


        },
        messages: {

            business_name: {
                required: "Shop name is required!",
            },
            business_address: {
                required: "Shop address is requried!",
            },
            name: {
                required: "Name is required!",
                minlength: "Name should be equal or greater than 3 characters! ",

            },
            phone: {
                required: "Phone number is required!",
                maxlength: "Phone number should be 11 digits: 0300-0000000! ",
                minlength: "Phone number should be 11 digits: 0300-0000000! "
            },


        }
    });

    // category Form Validation
    $("#categoryForm").validate({
        rules: {
            section_id: {
                required: true,
            },
            category_name: {
                required: true,
                minlength: 3,

            },
            category_discount: {
                required: true,

            },
            parent_id: {
                required: true,
            },
        },
        messages: {

            section_id: {
                required: "Section is requried!",
            },
            category_name: {
                required: "Category name is required!",
                minlength: "Category name should be equal or greater than 3 characters! ",

            },
            category_discount: {
                required: "Category discount is required!",

            },
            parent_id: {
                required: "Category level is required!",
            },

        }
    });
});