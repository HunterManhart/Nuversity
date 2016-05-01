$workspace = $('#workspace');
$top = $('#top');
$username = $('#user');
$loginText = $('#login-text');

//  When user logs into site (index)
$('#loginForm').submit(function (e) {
    e.preventDefault();

    //  Post login data to checking script
    var dataForm = $('#loginForm').serialize();
    $.post("query/login.php", dataForm).done(function (result) {
        if (result)
            window.location.href = "workspace.php";
    });
});

/*     Workspace Open     */

     //Creates tab functionality
    $('#tabs').each(function(){
         //For each set of tabs, we want to keep track of
         //which tab is active and its associated content
        var $active, $content, $links = $(this).find('a');

        // If the location.hash matches one of the links, use that as the active tab.
        // If no match is found, use the first link as the initial active tab.
        $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
        $active.addClass('active');

        $content = $($active[0].hash);

        // Hide closed tabs
        $links.not($active).each(function () {
            $(this.hash).hide();
        });

        // Tab Click functionality
        $(this).on('click', 'a', function(e){
            // Make the old tab inactive.
            $active.removeClass('active');
            $content.hide();

            // Update the variables with the new link and content
            $active = $(this);
            $content = $(this.hash);

            // Make the tab active.
            $active.addClass('active');
            $content.show();

            // Prevent the anchor's default click action
            e.preventDefault();
        });
    });
     //End tabs


    /*         Scroll Bar Resize Fix             */
    var $header = $("#tab-content");
    var body = $('body');
    var previousWidth = null;

    // Function that applies padding to the body
    // to adjust its position.
    var resizeBody = function () {
        if (body.width() != previousWidth) {
            previousWidth = body.width();

            // Measure the scrollbar size
            $header.css("overflow", "hidden");
            var scrollBarWidth = previousWidth - body.width();
            $header.css("overflow", "auto");

            $header.css("padding-right", scrollBarWidth + "px");
        }
    };

    // setInterval is required because the resize event
    // is not fired when a scrollbar appears or disappears.
    setInterval(resizeBody, 100);
    resizeBody();
    // End Scroll Fix


    /*      Text Area Resize      */   // Not Currently working
    $workspace.on('keyup input', "textarea[data-autoresize]", function() {
        $(this).css('min-height', $(this).innerHeight());
        //console.log($(this).innerHeight());
    });
    //  End Resize


/*      Login Animations      */
var $loginCon = $('.login');
var $loginForm = $('#login');
$loginCon.hover(
    function() {
        $loginForm.stop(true,true).slideDown('medium');
    },function(){
        $loginForm.stop(true,true).slideUp('medium');
    }
);
// Mobile
$(document).click(function(event) {
    if(!$(event.target).closest('.login').length &&
        !$(event.target).is('#menucontainer')) {
        $loginForm.stop(true, true).slideUp('medium');
    }
});


//  End Login


/*      Forgot Password     */
function forgotPassword(){
    var username = $username.val();

    $.post("query/forgotPass.php", {"username": username}).done(function(result){
        if(result){
            $loginText.text("An email has been sent to the email of this account with reset instructions");
            $('#forgot-password').remove();
        }else{
            $loginText.text("Sorry there's no one with this username");
        }
    })
}



/*       When survey button is pressed    */
$workspace.on("click", ".survey", function () {
    var $survey = $(this).data("survey");

    $.get("query/survey.php", {"survey": $survey}).done(function(results){
        results = JSON.parse(results);
        $top.html("");
        $sTitle.html(results["title"]);
        $sDescription.html(results["description"]);
        $sInstructions.html(results["instructions"]);
        $sReferrals.html(results["referrals"]);
        $sSurvey.html(results["survey"]);


        $('#main').css("margin-left", '300px');
        $('#header').css("left", 0);

        /*         Survey Submit       */
        $('#surveyForm').submit(function (e) {
            e.preventDefault();

            var referrals = $('#referralText').val();

            $.post("query/referrals.php", {"r": referrals}).done(function(results){
                console.log(results);
            });


            $.post("query/submit.php", $(this).serialize()).done(function(results){
                window.location.href = results;
            });
        });
        // End Submit
    })
});
//  End Survey

$('#tabs li').click(function(){
    if($(this).text() != "Surveys")
        exitSurvey();
});


$sTitle = $('#surveyTitle');
$sDescription = $('#description');
$sInstructions = $('#instructions');
$sReferrals = $('#referrals');
$sSurvey = $('#survey');

function exitSurvey(){
    if($top.html() == ""){
        $top.html(surveys);
        $sTitle.html("");
        $sDescription.html("");
        $sInstructions.html("");
        $sReferrals.html("");
        $sSurvey.html("");
        $('#main').css("margin-left", '0px');
        $('#header').css("left", "-300px");
    }
}