<!DOCTYPE html>
<html lang="zxx" class="no-js">

<?php include('layouts/head.php'); ?>

<body>

	<?php include('layouts/header.php'); ?>

	<!-- start banner Area -->
	<section class="banner-area relative">
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Contact Me
					</h1>
					<p class="link-nav">
						<span class="box">
							<a href="index.php">Home </a>
							<a href="about.php">About me</a>
						</span>
					</p>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- Start contact-page Area -->
	<section class="contact-page-area section-gap-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 d-flex flex-column address-wrap margin-bottom-2">
					<h4 class="margin-bottom-2">Send me a message on Linkedin</h4>
					<div class="align-items-center horizontal-center">
						<?php include('components/linkedin-badge.php'); ?>
					</div>
				</div>
				<div class="col-lg-8 margin-bottom-2">
					<h4 class="contact-h4">Send me an email</h4>
					<form class="form-area " id="myForm" action="mail.php" method="post" class="contact-form text-right">
						<div class="row">
							<div class="col-lg-6 form-group form-group-top">
								<input name="firstname" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
								 class="common-input mb-20 form-control" required="" type="text">

								<input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''"
								 onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

								<input name="subject" placeholder="Enter your subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your subject'"
								 class="common-input mb-20 form-control" required="" type="text">
							</div>
							<div class="col-lg-6 form-group">
								<textarea class="common-textarea form-control" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'"
								 required=""></textarea>
							</div>
							<div class="col-lg-12">
								<div class="alert-msg" style="text-align: left;"></div>

								<button class="primary-btn" style="float: right;" data-text="Send Message">
									<span>S</span>
									<span>e</span>
									<span>n</span>
									<span>d</span>
									<span> </span>
									<span>M</span>
									<span>e</span>
									<span>s</span>
									<span>s</span>
									<span>a</span>
									<span>g</span>
									<span>e</span>

								</button>
							</div>
						</div>
					</form>
				</div>

				<!--<div class="col-lg-12">
					<div class="map-wrap" style="width:100%; height: 445px;" id="map"></div>
				</div>-->
			</div>
		</div>

	</section>
	</hr>
	<!-- End contact-page Area -->

	<?php include('layouts/footer.php'); ?>

	<!-- ####################### Start Scroll to Top Area ####################### -->
	<div id="back-top">
		<a title="Go to Top" href="#">
			<i class="lnr lnr-arrow-up"></i>
		</a>
	</div>
	<!-- ####################### End Scroll to Top Area ####################### -->

	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
	<script src="js/easing.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.min.js"></script>
	<script src="js/mn-accordion.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/isotope.pkgd.min.js"></script>
	<script src="js/jquery.circlechart.js"></script>
	<script src="js/mail-script.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>