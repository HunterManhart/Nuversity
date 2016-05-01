<?php
require_once "classes/User.php";
session_start();
$user = $_SESSION['user'];
if(isset($user)) {
	$user_id = $user->getId();
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Nuversity</title>
		<meta charset="utf-8" />
		<link rel="icon" href="css/images/icon.png">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="js/index2/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="css/index2/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="css/index2/ie8.css" /><![endif]-->
        <link rel="stylesheet" href="css/site.css" />
	</head>
	<body>


    <!-- Header -->
    <header id="topbar" class="reveal white">
        <h1 id="logo"><a href="index.php">Nuversity</a></h1>
        <nav id="nav">
            <ul>
				<?php
				if(!isset($user_id)){
					echo '<li class="login">
                      <a data-dropdown="login">Login</a>
                      <ul id="login" class="f-dropdown small content" data-dropdown-content><li>
                          <form id="loginForm" method="post" class="box container 50%">
                              <div class="row 50%">
                                  <div class="12u"><input type="text" name="user" id="user" placeholder="Username" /></div>
                              </div>
                              <div class="row 50%">
                                  <div class="12u"><input type="password" name="pass" id="pass" placeholder="Password" /></div>
                              </div>
                              <div class="row 50%">
                              	<div class="12u"><input type="submit" value="Log In" class="fit special" /></div>
                              </div>
                              <div id="login-text" class="12u" style="display: none;"></div>
                              <a id="forgot-password" href="javascript: forgotPassword()">Forgot Password?</a>
                          </form>
                      </li></ul>
                  </li>';
					echo '<li><a href="signup.html" class="button special"  id="button-signup">Sign Up</a></li>';
				}else{
					echo "<li>
                    <a href=\"workspace.php\">Workspace</a>
                </li>";
				}
				?>
            </ul>
        </nav>
    </header>

		<!-- Header -->
			<div id="header">
				<span class="logo icon">Nu</span>
				<h1>Nuversity</h1>
				<p>A Nu Way to Market On College Campuses
				</p>
			</div>

		<!-- Main -->
			<div id="main">

				<header class="major container 75%">
					<h2>Traditional Campus Rep programs are flawed.<br> We decided to change that.</h2>
				</header>

				<div class="box alt container">
					<section class="feature left">
						<a href="#" class="image fa-signal"><img src="images/index/pic04.jpg" alt="" /></a>
						<div class="content">
							<h3>Marketing </h3>
							<p>
                                Why use two or three students when you can use hundreds of Nuversity reps to to promote your app on campus.
                            </p>
						</div>
					</section>
					<section class="feature right">
						<a href="#" class="image fa-code"><img src="images/index/user.jpg" alt="" /></a>
						<div class="content">
							<h3>User Feedback</h3>
							<p>
                                Gain insight into the nuanced desires of college students and millenials through thoughtful qualitative feedback and our data-driven analysis.</p>
						</div>
					</section>
					<section class="feature left">
						<a href="#" class="image fa-mobile"><img src="images/index/computer.jpg" alt="" /></a>
						<div class="content">
							<h3>Consulting</h3>
							<p>
                                Our student consultants review user feedback and generate informed recommendations about how to improve your product. </p>
						</div>
					</section>
				</div>

				<footer class="major container 75%">
					<h3>Interested?</h3>
					<p>No application necessary, become a Nuversity rep by signing up below.</p>
					<ul class="actions">
						<li><a href="signup.html" class="button">Join our crew</a></li>
					</ul>
				</footer>

			</div>

		<!-- Footer -->
			<div id="footer">
				<div class="container 75%">

					<header class="major last">
						<h2>Questions or comments?</h2>
					</header>

					<p>Let us know what you have to say</p>

					<form method="post" action="#">
						<div class="row">
							<div class="6u 12u(mobilep)">
								<input type="text" name="name" placeholder="Name" />
							</div>
							<div class="6u 12u(mobilep)">
								<input type="email" name="email" placeholder="Email" />
							</div>
						</div>
						<div class="row">
							<div class="12u">
								<textarea name="message" placeholder="Message" rows="6"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="12u">
								<ul class="actions">
									<li><input type="submit" value="Send Message" /></li>
								</ul>
							</div>
						</div>
					</form>

				</div>
			</div>

		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>

			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<!--[if lte IE 8]><script src="js/index2/ie/respond.min.js"></script><![endif]-->
			<script src="js/index2/main.js"></script>
            <script src="js/site.js"></script>
	</body>
</html>