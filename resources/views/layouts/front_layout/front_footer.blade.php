<footer id="footer">
    <!--Footer-->
    <div class="footer-top">
        <div class="container">
            <!-- Top Line  -->
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">



                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Us</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="">Company Information</a></li>

                            <li><a href="/contactus">Contact Us</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1 pull-right">
                    <div class="single-widget">
                        <h2>About kirmaan</h2>
                        <form action="javascript:void(0);" class="searchform" type="POST">
                            @csrf
                            <input onfocusout="checkSubscriber();" type="email" name="subscriber_email" id="subscriber_email" placeholder="Your email address" required />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <div id="statusSubscriber" style="display:none; margin-top:5px;"></div>
                            <p>Get the most recent updates from <br />our site and be updated your self...</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2021 kirmaan.org Inc. All rights reserved.</p>

            </div>
        </div>
    </div>


</footer>

<script>
    function checkSubscriber() {
        var subscriber_email = $("#subscriber_email").val();
        // alert(subscrriber_email);

        $.ajax({
            type: 'post',
            url: '/check-subscriber-email',
            data: {
                subscriber_email: subscriber_email
            },
            success: function(resp) {
                if (resp == 'Exists') {
                    $("#statusSubscriber").show();
                    $("#statusSubscriber").html("<span><font color='red'> Subscriber email already exists! </font></span>");
                } else if (resp == 'Saved') {
                    $("#statusSubscriber").show();
                    $("#statusSubscriber").html("<span><font color='green'> Thanks for <strong> subscribe! </strong> </font></span>");
                }
            },
            error: function() {
                alert("Error");
            }
        });


    }
</script>