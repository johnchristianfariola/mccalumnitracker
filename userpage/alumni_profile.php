<?php include '../includes/session.php'; ?>
<?php

// If the user is not logged in, redirect to the main index page
if (!isset($_SESSION['alumni'])) {
	header('location: ../index.php');
	exit();
}

// If forms_completed is true, redirect to the user home page
if (isset($_SESSION['forms_completed']) && $_SESSION['forms_completed'] == true) {
	header('location: index.php');
	exit();
}


?>



<?php


// Fetch data from Firebase
$courseKey = "course"; // Replace with your actual Firebase path or key for courses

$data = $firebase->retrieve($courseKey);
$data = json_decode($data, true); // Decode JSON data into associative arrays

$batchYears = $firebase->retrieve("batch_yr");
$batchYears = json_decode($batchYears, true); // Decode JSON data into associative arrays
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!----======== CSS ======== -->
	<link rel="stylesheet" href="style.css">

	<!----===== Iconscout CSS ===== -->
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

	<link rel="stylesheet" href="alumni_profile.css" />

	<title>Responsive Regisration Form </title>
</head>

<body>
	<div class="container">

		<form action="update_profile.php" method="POST" class="form">
			<!-- Hidden fields for alumni ID and CSRF token -->
			<input type="hidden" name="alumni_id" value="<?php echo htmlspecialchars($user['id']); ?>">
			<input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
			<input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($_SESSION['user']['batch_id']); ?>">
			<input type="hidden" name="course_id"
				value="<?php echo htmlspecialchars($_SESSION['user']['course_id']); ?>">


			<div class="form-section first">
				<div class="details personal">
					<header>
						<p class="step-icon"><span>01</span></p> Personal Information
					</header>
					<span class="title">Please correct mistake information and proceed to the next step so we can build
						your account.</span>

					<div class="fields">
						<div class="input-field">
							<label>First Name</label>
							<input type="text" name="firstname" placeholder="Enter your name"
								value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
						</div>

						<div class="input-field">
							<label>Middle Name</label>
							<input type="text" name="middlename" placeholder="Enter your middle name"
								value="<?php echo htmlspecialchars($user['middlename'] ?? ''); ?>">
						</div>

						<div class="input-field">
							<label>Last Name</label>
							<input type="text" name="lastname" placeholder="Enter your lastname"
								value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
						</div>

						<div class="input-field">
							<label>Auxiliary Name</label>
							<input type="text" name="auxiliaryname" placeholder="Enter auxiliary name"
								value="<?php echo htmlspecialchars($user['auxiliaryname']); ?>" required>
						</div>

						<div class="input-field">
							<label>Date of Birth</label>
							<input type="date" name="birthdate"
								value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
						</div>

						<div class="input-field">
							<label>Sex</label>
							<select name="gender" required>
								<option disabled>Select gender</option>
								<option value="Male" <?php echo ($user['gender'] === 'Male') ? 'selected' : ''; ?>>Male
								</option>
								<option value="Female" <?php echo ($user['gender'] === 'Female') ? 'selected' : ''; ?>>
									Female</option>
								<option value="Others" <?php echo ($user['gender'] === 'Others') ? 'selected' : ''; ?>>
									Others</option>
							</select>
						</div>

						<div class="input-field">
							<label>Civil Status</label>
							<input type="text" name="civilstatus" placeholder="Enter your civil status"
								value="<?php echo htmlspecialchars($user['civilstatus']); ?>" required>
						</div>
					</div>
				</div>

				<div class="details">
					<span class="title">Contact Details</span>

					<div class="fields">
						<div class="input-field">
							<label>Address</label>
							<input type="text" name="addressline1" placeholder="Enter your address"
								value="<?php echo htmlspecialchars($user['addressline1']); ?>" required>
						</div>

						<div class="input-field">
							<label>City</label>
							<input type="text" name="city" placeholder="Enter your city"
								value="<?php echo htmlspecialchars($user['city']); ?>" required>
						</div>

						<div class="input-field">
							<label>State | Province | Region</label>
							<input type="text" name="state" placeholder="Enter your state"
								value="<?php echo htmlspecialchars($user['state']); ?>" required>
						</div>

						<div class="input-field">
							<label>Zip Code</label>
							<input type="text" name="zipcode" placeholder="Enter your zip code"
								value="<?php echo htmlspecialchars($user['zipcode']); ?>" required>
						</div>

						<div class="input-field">
							<label>Email</label>
							<input type="email" name="email" placeholder="Enter your email"
								value="<?php echo htmlspecialchars($user['email']); ?>" required>
						</div>

						<div class="input-field">
							<label>Contact</label>
							<input type="text" name="contactnumber" placeholder="Enter your contact number"
								value="<?php echo htmlspecialchars($user['contactnumber']); ?>" required>
						</div>
					</div>
				</div>

				<div class="buttons">
					<button type="button" class="nextBtn">
						<span class="btnText">Next</span>
						<i class="uil uil-navigator"></i>
					</button>
				</div>
			</div>

			<div class="form-section second">
				<div class="details address">
					<header>
						<p class="step-icon"><span>02</span></p> Additional Information
					</header>

					<div class="fields">
						<div class="input-field">
							<label>Course</label>

							<select class="form-control" id="course" name="course" required>
								<option value="<?php echo htmlspecialchars($_SESSION['user']['course_id']); ?>">
									<?php echo htmlspecialchars($_SESSION['user']['course']); ?>
									<?php
									if (is_array($data)) {
										foreach ($data as $courseId => $details) {
											$courseCode = isset($details['courCode']) ? htmlspecialchars($details['courCode']) : 'Unknown';
											echo "<option value=\"" . htmlspecialchars($courseId) . "\">" . $courseCode . "</option>";
										}
									}
									?>
							</select>

						</div>

						<div class="input-field">
							<label>Batch</label>

							<select class="form-control" id="batch" name="batch" required>
								<option value="<?php echo htmlspecialchars($_SESSION['user']['batch_id']); ?>">
									<?php echo htmlspecialchars($_SESSION['user']['batch']); ?>
								</option>
								<?php
								if (!empty($batchYears) && is_array($batchYears)) {
									foreach ($batchYears as $batchId => $batchDetails) {
										$batchYear = isset($batchDetails['batch_yrs']) ? htmlspecialchars($batchDetails['batch_yrs']) : 'Unknown';
										echo "<option value=\"" . htmlspecialchars($batchId) . "\">" . $batchYear . "</option>";
									}
								}
								?>
							</select>


						</div>


						<div class="input-field">
							<label>Current Work Status</label>
							<select class="form-control" name="work_status" id="work-status" required>
								<option value="">Select Status</option>
								<option value="Employed">Employed</option>
								<option value="Unemployed">Unemployed</option>
							</select>
						</div>

						<div class="input-field">
							<label>Date of 1st Employment</label>
							<input type="date" class="form-control" id="first_employment_date"
								name="first_employment_date" placeholder="Date of 1st Employment">
						</div>

						<div class="input-field">
							<label>Date of Current Employment</label>
							<input type="date" class="form-control" id="date_for_current_employment"
								name="date_for_current_employment" placeholder="Date of Current Employment">
						</div>

						<div class="input-field">
							<label>Type of Work</label>
							<input type="text" class="form-control" id="type_of_work" name="type_of_work"
								placeholder="Type of Work">
						</div>

						<div class="input-field">
							<label>Work Position</label>
							<input type="text" class="form-control" id="work_position" name="work_position"
								placeholder="Work Position">
						</div>

						<div class="input-field">
							<label>Current Monthly Income</label>
							<input type="number" class="form-control" id="current_monthly_income"
								name="current_monthly_income" placeholder="Current Monthly Income">
						</div>

						<div class="input-field">
							<label style="font-size:10px">Is your job related to your undergraduate program?</label>
							<select class="form-control" name="work_related" id="work_related">
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</div>



					</div>
				</div>

				<div class="buttons">
					<button type="button" class="backBtn">
						<i class="uil uil-navigator"></i>
						<span class="btnText">Back</span>
					</button>
					<button type="submit" class="submitBtn">
						<span class="btnText">Submit</span>
						<i class="uil uil-navigator"></i>
					</button>
				</div>
			</div>
		</form>
	</div>

	<script src="script.js"></script>
</body>

</html>


<script>
	const form = document.querySelector(".form"),
		nextBtn = form.querySelector(".nextBtn"),
		backBtn = form.querySelector(".backBtn"),
		formSections = form.querySelectorAll(".form-section");

	let currentSection = 0; // Track current section index

	// Initialize form navigation
	function initializeForm() {
		// Hide all sections except the first one
		formSections.forEach((section, index) => {
			if (index !== currentSection) {
				section.style.display = "none";
			}
		});

		// Show the current section
		formSections[currentSection].style.display = "block";

		// Add event listeners to navigation buttons
		nextBtn.addEventListener("click", goToNextSection);
		backBtn.addEventListener("click", goToPreviousSection);
	}

	// Function to navigate to the next section
	function goToNextSection() {
		// Validate current section inputs if needed
		const inputsValid = validateInputs(formSections[currentSection]);

		// Proceed to the next section if inputs are valid
		if (inputsValid) {
			formSections[currentSection].style.display = "none";
			currentSection++;
			formSections[currentSection].style.display = "block";
		}
	}

	// Function to navigate to the previous section
	function goToPreviousSection() {
		formSections[currentSection].style.display = "none";
		currentSection--;
		formSections[currentSection].style.display = "block";
	}

	// Example input validation function (customize as per your requirements)
	function validateInputs(section) {
		const inputs = section.querySelectorAll("input[required]");
		let isValid = true;

		inputs.forEach(input => {
			if (!input.value.trim()) {
				isValid = false;
				// Optionally show error messages or other validation feedback
			}
		});

		return isValid;
	}

	// Initialize the form
	initializeForm();




</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function () {
		function toggleEmploymentFields() {
			const selectedStatus = $('#work-status').val();
			if (selectedStatus === 'Employed') {
				$('#first_employment_date').closest('.input-field').show();
				$('#date_for_current_employment').closest('.input-field').show();
				$('#type_of_work').closest('.input-field').show();
				$('#work_position').closest('.input-field').show();
				$('#current_monthly_income').closest('.input-field').show();
				$('#work_related').closest('.input-field').show();
				$('#first_employment_date, #date_for_current_employment, #type_of_work, #work_position, #current_monthly_income, #work_related').attr('required', true);
			} else {
				$('#first_employment_date').closest('.input-field').hide();
				$('#date_for_current_employment').closest('.input-field').hide();
				$('#type_of_work').closest('.input-field').hide();
				$('#work_position').closest('.input-field').hide();
				$('#current_monthly_income').closest('.input-field').hide();
				$('#work_related').closest('.input-field').hide();
				$('#first_employment_date, #date_for_current_employment, #type_of_work, #work_position, #current_monthly_income, #work_related').removeAttr('required');
			}
		}

		$('#work-status').change(toggleEmploymentFields);

		// Initial toggle based on current value
		toggleEmploymentFields();
	});

</script>