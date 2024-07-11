<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

if (isset($_SESSION['error'])) {
  echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: '{$_SESSION['error']}',
                    imageUrl: 'homepage/img/sad-icon.png',
                    imageWidth: 90,
                    imageHeight: 90,
                    imageAlt: 'Custom image'
                });
              </script>";
  unset($_SESSION['error']);
}
?>




<div class="modal " id="uniqueModal">
  <div class="modal_popup_container wow fadeInDown" data-wow-delay="0.1s" id="uniqueContainer">
    <div class="form_container sign_up_container">
      <form class="form_action" action="signup_action.php" method="POST" autocomplete="">
        <h1 class="form_title" style="font-size:30px">Enter Your Alumni Information</h1>
        <input class="form_input" type="text" name="schoolId" placeholder="School ID" required />
        <input class="form_input" type="text" name="lastname" required
          value="<?php echo isset($lastname) ? $lastname : '' ?>" placeholder="Last Name" />
        <input class="form_input" type="email" name="email" required value="<?php echo isset($email) ? $email : '' ?>"
          placeholder="Email" />
        <input class="form_input" type="password" name="password" placeholder="Password" required />
        <input class="form_input" type="password" name="curpassword" placeholder="Confirm Password" required />
        <button class="form_button" type="submit" name="signup">Sign Up</button>
      </form>

    </div>
    <div class="form_container sign_in_container">
      <form class="form_action" method="POST" action="login.php">
        <h1 class="form_title">Sign in</h1>
        <div class="social_container">

        </div>

        <input class="form_input" type="email" placeholder="Email" name="email" required />
        <input class="form_input" type="password" placeholder="Password" name="password" required />
        <a class="form_link" href="#">Forgot your password?</a>
        <button class="form_button" type="submit" name="login">Sign In</button>
      </form>
    </div>
    <div class="overlay_container">
      <div class="overlay">
        <div class="overlay_panel overlay_left">
          <h1 class="overlay_title">Welcome Back!</h1>
          <p class="overlay_text">To keep connected with us please login with your personal info</p>
          <button class="form_button" id="signIn">Sign In</button>
        </div>
        <div class="overlay_panel overlay_right">
          <h1 class="overlay_title">Hello, Friend!</h1>
          <p class="overlay_text">Enter your personal details and start journey with us</p>
          <button class="form_button" id="signUp">Sign Up</button>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const openFormButtons = document.querySelectorAll('.openFormButton');
  const modal = document.getElementById('uniqueModal');
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('uniqueContainer');

  // Function to open modal when a button is clicked
  function openModal() {
    modal.style.display = "block";
  }

  // Event listener for each 'openFormButton'
  openFormButtons.forEach(button => {
    button.addEventListener('click', openModal);
  });

  // Close modal if user clicks outside it
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // Event listener for signUpButton
  signUpButton.addEventListener('click', () => {
    container.classList.add("right_panel_active");
  });

  // Event listener for signInButton
  signInButton.addEventListener('click', () => {
    container.classList.remove("right_panel_active");
  });


</script>