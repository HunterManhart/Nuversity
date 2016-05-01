<?php
require_once "db/conn.php";
require_once "classes/User.php";
session_start();
$user = $_SESSION['user'];
if(isset($user)) {
    $user_id = $user->getId();
}else{
    header("Location: index.php");
}

$surveys = $user->surveysOpen();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Workspace</title>
    <meta charset="utf-8" />
    <link rel="icon" href="css/images/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="js/workspace/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="css/workspace/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="css/workspace/ie8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="css/workspace/ie9.css" /><![endif]-->
    <link rel="stylesheet" href="css/site.css">
</head>
<body>

<header id="topbar" class="reveal" style="background-color: white;">
    <h1 id="logo"><a href="index.php">Nuversity</a></h1>
    <h1 id="signout"><a href="signout.php">Sign Out</a></h1>
    <nav id="nav">
        <ul id="tabs">
            <?php
            if($user->getDemographic() == 1){
                echo '<li><a id="last" class="" href="#workspace">Surveys</a></li>
                        <li><a id="first" href="#overview">Overview</a></li>
                        <li><a id="middle" href="#faq">FAQ</a></li>';
            }else{
                echo '<li><a id="first" href="#overview">Overview</a></li>
                        <li><a id="middle" href="#faq">FAQ</a></li>
                        <li><a id="last" class="" href="#workspace">Surveys</a></li>';
            }

            ?>
        </ul>
    </nav>
</header>

<div id="page-wrapper">

<!-- Header -->
<div id="header" style="top: 3.5em;left: -300px;">

    <div class="top">

        <!-- Logo -->
        <div id="logo">
            <h1 id="title">
                <?php
                echo $user->getName();

                ?>
            </h1>
        </div>

        <!-- Nav -->
        <nav id="nav" class="scroll">
            <ul>
                <li><a href="#surveyTitle" id="surveyTitle-link" class="skel-layers-ignoreHref active"><span class="icon fa-tasks">App</span></a></li>
                <li><a href="#description" id="description-link" class="skel-layers-ignoreHref"><span class="icon fa-tasks">Description</span></a></li>
                <li><a href="#instructions" id="instructions-link" class="skel-layers-ignoreHref"><span class="icon fa-bar-chart">Instructions</span></a></li>
                <li><a href="#referrals" id="referrals-link" class="skel-layers-ignoreHref"><span class="icon fa-users">Referrals</span></a></li>
                <li><a href="#survey" id="survey-link" class="skel-layers-ignoreHref"><span class="icon fa-check-square">Survey</span></a></li>
            </ul>
        </nav>

    </div>

</div>

<!-- Main -->
<div id="main">

    <div id="tab-content">
    <div id="workspace">
        <!-- Intro -->
        <section id="top" class="one dark cover">
                <?php echo $surveys;?>
        </section>

        <section id="surveyTitle" class="one dark cover"></section>

        <!-- Description -->
        <section id="description" class="two"></section>

        <!-- Instructions -->
        <section id="instructions" class="three"></section>

        <!-- Referrals -->
        <section id="referrals" class="four"></section>

        <section id="survey" class="two"></section>
    </div>

    <div id="overview">
        <!-- Intro -->
        <section id="top" class="one dark cover">
            <div class="container">

                <header>
                    <h2>Overview</h2>
                    <p>Thank you for your interest in Nuversity!</p>
                </header>

                <p style="text-align: left;">We started Nuversity because we saw how bad the campus rep model was that many companies used to market their mobile apps on college campuses.<br>Instead of paying 2-3 a lot of money to do a bad job, we thought it would be better to pay a lot of people a little bit of money to do a better job. We are also hoping to expand our offering to providing user feedback to other companies like restaurants chains such as Starbucks and Chipotle, we will keep you posted.<br><br>

                    If you like making a minimum of $15/hour, being able to choose your own hours, and boosting your resume, help spread the word about Nuversity to your friends, and complete our surveys and marketing activities to the best of your abilities.<br> Please read our outline below before completing your first survey. Also check out our FAQ page for answers to any other questions you might have, or you can email us at nuversitysolutions@gmail.com or text 301-244-8113.
                </p>


            </div>
        </section>

        <!-- Question 1 -->
        <section id="portfolio" class="two">
            <div class="container">

                <header>
                    <h2>1</h2>
                </header>

                <p>When an app hires Nuversity, we will send out a text and email notifying you. The app will be available on the Nuversity website. You will have one week to complete the survey.
                </p>


            </div>
        </section>

        <!-- Question 2 -->
        <section id="about" class="three">
            <div class="container">

                <header>
                    <h2>2</h2>
                </header>

                <p>We pay 5 dollars per each completed survey. Each survey will take 20 minutes or less.  However, you must get two other users to download an app to qualify as completing the survey. We pay an additional dollar referral for each friend to download an app after your first two referrals. We only work with apps that we think you'd want to share with a friend, and there is no requirement or penalty for choosing to not complete a survey for an app.
                </p>

            </div>
        </section>

        <!-- Question 3 -->
        <section id="" class="four">
            <div class="container">

                <header>
                    <h2>3</h2>
                </header>

                <p>There is no limit to the amount of referrals we will pay for you, the more the merrier. If you get 50 of your friends to download an app, we will pay you an extra 50 bucks. It's as simple as that.
                </p>

            </div>
        </section>

        <!-- Question 3 -->
        <section id="" class="three">
            <div class="container">

                <header>
                    <h2>4</h2>
                </header>

                <p>You can complete as many surveys as you'd like per week.
                </p>

            </div>
        </section>

        <!-- Question 3 -->
        <section id="" class="two">
            <div class="container">

                <header>
                    <h2>5</h2>
                </header>

                <p>Finally, please provide thoughtful, high quality feedback. We read each survey before sending it to the apps that hire us, and we have access to how long it takes you to complete the survey, so if you rush through it and finish in thirty seconds, we will know and you will be disqualified from completing future surveys. If we use any of your feedback in our recommendations to an app, we will notify you and you can put that on your resume.
                </p>

            </div>
        </section>

        <!-- Question 3 -->
        <section id="" class="three">
            <div class="container">

                <header>
                    <h2>6</h2>
                </header>

                <p>We hope you enjoy working for Nuversity and continue to come back and contributing to our service! Please always feel free to reach out with any questions, comments, or concerns you have or with any problems you encounter.
                </p>

            </div>
        </section>
    </div>

    <div id="faq">
        <!-- Intro -->
        <section id="top" class="one dark cover">
            <div class="container">

                <header>
                    <h2 class="alt"><strong>Frequently Asked Questions</strong></h2>
                </header>


            </div>
        </section>

        <!-- Question 1 -->
        <section id="portfolio" class="two">
            <div class="container">

                <header>
                    <h2>How will I get paid? </h2>
                </header>

                <p>We use Google Wallet. With Google Wallet, you can send money to someone with just their email address or phone number. Once you receive a link to be paid, all you have to do is enter your debit card info, and the amount will be deposited into your account within one business day. </p>


            </div>
        </section>

        <section id="" class="three">
            <div class="container">

                <header>
                    <h2>Why do I have to get two people to download each app to complete a survey?</h2>
                </header>

                <p>We have to structure our pay this way so we get a high volume of apps interested in our services so that you get as many opportunities to make $15/hr as possible.
                </p>

            </div>
        </section>

        <!-- Question 2 -->
        <section id="about" class="four">
            <div class="container">

                <header>
                    <h2>How do the referrals work?</h2>
                </header>

                <p>We work jointly with the apps that hire us, so after we put a survey for an app on the Nuversity site, each new download for the app will be sent to us, and we will cross reference this list with the names that people put for referrals. Referrals are only paid when the referred person downloads the app and signs up by entering their information (i.e. username, email, password, etc.)
                </p>

            </div>
        </section>

        <!-- Question 3 -->
        <section id="" class="three">
            <div class="container">

                <header>
                    <h2>How many hours per week do I have to work?</h2>
                </header>

                <p>You pick your own hours. There is no required amount that you have to work.
                </p>

            </div>
        </section>

        <!-- Question 4 -->
        <section id="" class="two">
            <div class="container">

                <header>
                    <h2>Can I put this on my resume? What do I say?</h2>
                </header>

                <p>Yes, we hope you do. You can say you are a Market Research Analyst or App Tester for Nuversity.
                </p>

            </div>
        </section>

        <!-- Question 5 -->
        <section id="" class="three">
            <div class="container">

                <header>
                    <h2>Do I have to have any prior experience?</h2>
                </header>

                <p>No prior experience is necessary.
                </p>

            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="one dark cover">
            <div class="container">

                <header>
                    <h2>Still Have Questions</h2>
                </header>

                <p>Email us and we'll get back to as soon as we can</p>

                <form method="post" action="#">
                    <div class="row">
                        <div class="12u$">
                            <textarea name="message" placeholder="Message"></textarea>
                        </div>
                        <div class="12u$">
                            <input type="submit" value="Send Message" />
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
    </div>

    </div>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.scrolly.min.js"></script>
<script src="js/jquery.scrollzer.min.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/util.js"></script>
<!--[if lte IE 8]><script src="js/workspace/ie/respond.min.js"></script><![endif]-->
<script src="js/workspace/main.js"></script>
    <script><?php echo "var surveys = '$surveys'"; ?></script>
<script src="js/site.js"></script>

</body>
</html>