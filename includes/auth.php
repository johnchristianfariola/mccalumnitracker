<? require_once '../controllerUserData.php'; ?>

<link rel="stylesheet" href="../dist/css/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<style>
  .hidden {
    display: none;
  }
</style>



<div class="modal " id="uniqueModal">
  <div class="modal_popup_container wow fadeInDown" data-wow-delay="0.1s" id="uniqueContainer">
    <div class="form_container sign_up_container">
      <form class="form_action" action="signup_action.php" method="POST" autocomplete="">
        <h1 class="form_title" style="font-size:30px">Enter Your Alumni Information</h1>
        <input class="form_input" type="text" name="schoolId" placeholder="Alumni ID (e.g., 1234-5678)" required
          pattern="\d{4}-\d{4}" maxlength="9"
          oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');"
          onkeyup="if(this.value.length == 4) this.value += '-';"
          title="Please enter 8 digits in the format 1234-5678" />
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
      <form class="form_action" method="POST" action="login.php" id="signInForm">
        <h1 class="form_title">Sign in</h1>
        <div class="social_container">
        </div>
        <input class="form_input" type="email" placeholder="Email" name="email" required />
        <input class="form_input" type="password" placeholder="Password" name="password" required />
        <a class="form_link" href="#" id="forgotPasswordLink">Forgot your password?</a>
        <button class="form_button" type="submit" name="login">Sign In</button>
      </form>

      <form class="form_action" id="forgotPasswordForm" method="POST" action="controllerUserData.php">
        <h1 class="form_title">Reset Password</h1>
        <input class="form_input" type="email" placeholder="Enter your email" name="email" required />
        <button class="form_button" type="submit" name="check-email">Reset Password</button>
        <a class="form_link" href="#" id="backToSignIn">Back to Sign In</a>
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
  document.addEventListener('DOMContentLoaded', function () {
    const openFormButtons = document.querySelectorAll('.openFormButton');
    const modal = document.getElementById('uniqueModal');
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('uniqueContainer');
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const backToSignInLink = document.getElementById('backToSignIn');
    const signInForm = document.getElementById('signInForm');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');

    // Function to safely add event listener
    function addSafeEventListener(element, event, handler) {
      if (element) {
        element.addEventListener(event, handler);
      } else {
        console.warn(`Element not found for event: ${event}`);
      }
    }

    // Existing modal open/close logic
    function openModal() {
      if (modal) modal.style.display = "block";
    }

    openFormButtons.forEach(button => {
      addSafeEventListener(button, 'click', openModal);
    });

    if (modal) {
      window.addEventListener('click', (event) => {
        if (event.target === modal) {
          modal.style.display = "none";
        }
      });
    }

    addSafeEventListener(signUpButton, 'click', () => {
      if (container) container.classList.add("right_panel_active");
    });

    addSafeEventListener(signInButton, 'click', () => {
      if (container) container.classList.remove("right_panel_active");
    });

    // New functionality for toggling between sign in and forgot password forms
    addSafeEventListener(forgotPasswordLink, 'click', (e) => {
      e.preventDefault();
      if (signInForm) signInForm.classList.add('hidden');
      if (forgotPasswordForm) forgotPasswordForm.classList.remove('hidden');
    });

    addSafeEventListener(backToSignInLink, 'click', (e) => {
      e.preventDefault();
      if (forgotPasswordForm) forgotPasswordForm.classList.add('hidden');
      if (signInForm) signInForm.classList.remove('hidden');
    });

    // Handle forgot password form submission

  });
</script>