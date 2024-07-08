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


<div class="modal" id="uniqueModal">
  <div class="modal_popup_container" id="uniqueContainer">
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
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
          <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <span class="form_span">or use your account</span>
        <input class="form_input" type="email" placeholder="Email" name="email" />
        <input class="form_input" type="password" placeholder="Password" name="password" />
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

<style>
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 2000;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  .modal_popup_container {
    margin: 5% auto;
    /* 5% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    /* Could be more or less, depending on screen size */
  }

  @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');


  .form_title {
    font-weight: bold;
    font-size: 35px;
    margin: 0;
  }

  .overlay_title {
    font-weight: bold;
    margin: 0;
  }

  .form_span {
    font-size: 12px;
  }

  .form_link {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
  }

  .form_button {
    border-radius: 20px;
    border: 1px solid #FF4B2B;
    background-color: #FF4B2B;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
  }

  .form_button:active {
    transform: scale(0.95);
  }

  .form_button:focus {
    outline: none;
  }

  button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
  }

  .form_action {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
  }

  .form_input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
  }

  .modal_popup_container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
      0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;

    max-width: 100%;
    min-height: 550px;
  }

  .form_container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
  }

  .sign_in_container {
    left: 0;
    width: 50%;
    z-index: 2;
  }

  .modal_popup_container.right_panel_active .sign_in_container {
    transform: translateX(100%);
  }

  .sign_up_container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
  }

  .modal_popup_container.right_panel_active .sign_up_container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
  }

  @keyframes show {

    0%,
    49.99% {
      opacity: 0;
      z-index: 1;
    }

    50%,
    100% {
      opacity: 1;
      z-index: 5;
    }
  }

  .overlay_container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
  }

  .modal_popup_container.right_panel_active .overlay_container {
    transform: translateX(-100%);
  }

  .overlay {
    background: #FF416C;
    background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
    background: linear-gradient(to right, #da8cff, #9a55ff);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }

  .modal_popup_container.right_panel_active .overlay {
    transform: translateX(50%);
  }

  .overlay_panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }

  .overlay_left {
    transform: translateX(-20%);
  }

  .modal_popup_container.right_panel_active .overlay_left {
    transform: translateX(0);
  }

  .overlay_right {
    right: 0;
    transform: translateX(0);
  }

  .modal_popup_container.right_panel_active .overlay_right {
    transform: translateX(20%);
  }

  .social_container {
    margin: 20px 0;
  }

  .social_container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
  }

  footer {
    background-color: #222;
    color: #fff;
    font-size: 14px;
    bottom: 0;
    position: fixed;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 999;
  }

  footer p {
    margin: 10px 0;
  }

  footer i {
    color: red;
  }

  footer a {
    color: #3c97bf;
    text-decoration: none;
  }
</style>

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