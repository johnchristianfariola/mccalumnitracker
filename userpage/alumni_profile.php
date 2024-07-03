<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>form-v1 by Colorlib</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css"
		href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
	<link rel="stylesheet" href="alumni_profile.css" />
</head>

<body>

	<div class="page-content">
		<div class="form-v1-content">
			<div class="wizard-form">
				<form class="form-register" action="#" method="post">
					<div id="form-total">
						<!-- SECTION 1 -->
						<h2>
							<p class="step-icon"><span>01</span></p>
							<span class="step-text">Peronal Infomation</span>
						</h2>
						<section>
							<div class="inner">
								<div class="wizard-header">
									<h3 class="heading">Peronal Infomation</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your
										accounts. </p>
								</div>
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>First Name</legend>
											<input type="text" class="form-control" id="first-name" name="first-name"
												placeholder="First Name" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Middle Name</legend>
											<input type="text" class="form-control" id="middle-name" name="last-name"
												placeholder="Last Name" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>Last Name</legend>
											<input type="text" class="form-control" id="last-name" name="first-name"
												placeholder="First Name" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Auxilary Name</legend>
											<input type="text" class="form-control" id="last-name" name="last-name"
												placeholder="Last Name" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>Birth Date</legend>
											<input type="date" class="form-control" id="birthdate" name="first-name"
												placeholder="First Name" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Civil Status</legend>
											<input type="text" class="form-control" id="last-name" name="last-name"
												placeholder="Last Name" required>
										</fieldset>
									</div>
								</div>


								<div class="form-row">
									<div class="form-holder">
										<legend for="edit_gender" class="col-form-label">Gender</legend>
										<input type="radio" id="editMale" name="edit_gender" value="Male"
											class="gender-radio" required>
										<label for="editMale" class="radio-label">Male</label>

										<input type="radio" id="editFemale" name="edit_gender" value="Female"
											class="gender-radio" required>
										<label for="editFemale" class="radio-label">Female</label>
									</div>

								</div>

								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>Address</legend>
											<input type="phone" class="form-control" id="address" name="address"
												placeholder="Address" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>City</legend>
											<input type="text" class="form-control" id="city" name="contact"
												placeholder="City" required>
										</fieldset>
									</div>
								</div>

								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>State | Province | Region</legend>
											<input type="text" class="form-control" id="state" name="state"
												placeholder="State" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Zip Code</legend>
											<input type="number" class="form-control" id="zip" name="zip"
												placeholder="Zip Code " required>
										</fieldset>
									</div>
								</div>

								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>Contact</legend>
											<input type="phone" class="form-control" id="contact" name="contact"
												placeholder="Contact" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Email</legend>
											<input type="email" class="form-control" id="email" name="email"
												placeholder="Email" required>
										</fieldset>
									</div>
								</div>

								

								
							</div>
						</section>
						<!-- SECTION 2 -->
						<h2>
							<p class="step-icon"><span>02</span></p>
							<span class="step-text">Connect Bank Account</span>
						</h2>
						<section>
							<div class="inner">
								<div class="wizard-header">
									<h3 class="heading">Connect Bank Account</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your
										accounts.</p>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-1">
										<input type="text" name="find_bank" id="find_bank" placeholder="Find Your Bank"
											class="form-control" required>
									</div>
								</div>
								<div class="form-row-total">
									<div class="form-row">
										<div class="form-holder form-holder-2 form-holder-3">
											<input type="radio" class="radio" name="bank-1" id="bank-1" value="bank-1"
												checked>
											<label class="bank-images label-above bank-1-label" for="bank-1">
												<img src="images/form-v1-1.png" alt="bank-1">
											</label>
											<input type="radio" class="radio" name="bank-2" id="bank-2" value="bank-2">
											<label class="bank-images label-above bank-2-label" for="bank-2">
												<img src="images/form-v1-2.png" alt="bank-2">
											</label>
											<input type="radio" class="radio" name="bank-3" id="bank-3" value="bank-3">
											<label class="bank-images label-above bank-3-label" for="bank-3">
												<img src="images/form-v1-3.png" alt="bank-3">
											</label>
										</div>
									</div>
									<div class="form-row">
										<div class="form-holder form-holder-2 form-holder-3">
											<input type="radio" class="radio" name="bank-4" id="bank-4" value="bank-4">
											<label class="bank-images bank-4-label" for="bank-4">
												<img src="images/form-v1-4.png" alt="bank-4">
											</label>
											<input type="radio" class="radio" name="bank-5" id="bank-5" value="bank-5">
											<label class="bank-images bank-5-label" for="bank-5">
												<img src="images/form-v1-5.png" alt="bank-5">
											</label>
											<input type="radio" class="radio" name="bank-6" id="bank-6" value="bank-6">
											<label class="bank-images bank-6-label" for="bank-6">
												<img src="images/form-v1-6.png" alt="bank-6">
											</label>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!-- SECTION 3 -->
						<h2>
							<p class="step-icon"><span>03</span></p>
							<span class="step-text">Set Financial Goals</span>
						</h2>
						<section>
							<div class="inner">
								<div class="wizard-header">
									<h3 class="heading">Set Financial Goals</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your
										accounts.</p>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<input type="radio" class="radio" name="radio1" id="plan-1" value="plan-1">
										<label class="plan-icon plan-1-label" for="plan-1">
											<img src="images/form-v1-icon-2.png" alt="pay-1">
										</label>
										<div class="plan-total">
											<span class="plan-title">Specific Plan</span>
											<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat
												mauris nunc congue nisi.</p>
										</div>
										<input type="radio" class="radio" name="radio1" id="plan-2" value="plan-2">
										<label class="plan-icon plan-2-label" for="plan-2">
											<img src="images/form-v1-icon-2.png" alt="pay-1">
										</label>
										<div class="plan-total">
											<span class="plan-title">Medium Plan</span>
											<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat
												mauris nunc congue nisi.</p>
										</div>
										<input type="radio" class="radio" name="radio1" id="plan-3" value="plan-3"
											checked>
										<label class="plan-icon plan-3-label" for="plan-3">
											<img src="images/form-v1-icon-3.png" alt="pay-2">
										</label>
										<div class="plan-total">
											<span class="plan-title">Special Plan</span>
											<p class="plan-text">Pellentesque nec nam aliquam sem et volutpat consequat
												mauris nunc congue nisi.</p>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/main_copy.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<style>
	.gender-radio {
		display: none;
		/* Hide the actual radio buttons */
	}

	.radio-label {
		display: inline-block;
		cursor: pointer;
		padding: 8px 20px;
		margin-right: 10px;
		font-size: 13px;
		border-radius: 5px;
		background-color: #e0e0e0;
		/* Default background color */
	}

	/* Styling when radio button is checked */
	.gender-radio:checked+.radio-label {
		background-color: #ff5252 !important;
		/* Change background color when checked */
		color: white;
		/* Change text color when checked */
	}
</style>