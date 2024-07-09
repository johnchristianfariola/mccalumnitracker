

<!DOCTYPE html>
<html lang="en">


<?php include 'includes/header.php' ?>


<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

 
    <!-- Navbar Start -->
    <?php include 'includes/navbar.php' ?>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5" style="height: 40%">
    <div class="position-relative">
        <img class="img-fluid" src="homepage/img/carousel-1.png" alt="" style="height: 150px; width: 100%; object-fit: cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
            style="background: rgba(24, 29, 56, .7);">
            <div class="container">
                <div class="row justify-content-start">
                    <!-- Your content here -->
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Carousel End -->
    <div class="unique-container">
  <header class="unique-header">
    <i class="fa fa-lock"></i>
  </header>
  <h4>Enter OTP Code</h4>
  <form class="unique-form" action="user-otp-action.php" method="post">
    <div class="unique-input-field">
      <input type="number" name="otp[]" maxlength="1" required />
      <input type="number" name="otp[]" maxlength="1" required />
      <input type="number" name="otp[]" maxlength="1" required />
      <input type="number" name="otp[]" maxlength="1" required />
      <input type="number" name="otp[]" maxlength="1" required />
      <input type="number" name="otp[]" maxlength="1" required />
    </div>
    <button type="submit" name="check">Verify OTP</button>
  </form>
</div>

    <!-- Testimonial End -->


    <!-- Footer Start -->
    <?php include 'includes/footer.php' ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="homepage/lib/wow/wow.min.js"></script>


  
    <!-- Template Javascript -->
    <script src="homepage/js/main.js"></script>


    <!-- Modal -->
    <?php include 'includes/auth.php' ?>
</body>

</html>


<style>
 /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

:where(.unique-container, .unique-form, .unique-input-field, .unique-header) {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.unique-container {
  background: #fff;
  padding: 30px 65px;
  border-radius: 12px;
  row-gap: 20px;
  
}
.unique-container .unique-header {
  height: 65px;
  width: 65px;
  background: #333;
  color: #fff;
  font-size: 2.5rem;
  border-radius: 50%;
}
.unique-container h4 {
  font-size: 1.25rem;
  color: #333;
  font-weight: 500;
}
.unique-form .unique-input-field {
  flex-direction: row;
  column-gap: 10px;
}
.unique-input-field input {
  height: 45px;
  width: 42px;
  border-radius: 6px;
  outline: none;
  font-size: 1.125rem;
  text-align: center;
  border: 1px solid #ddd;
  background: silver;
}
.unique-input-field input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.unique-input-field input::-webkit-inner-spin-button,
.unique-input-field input::-webkit-outer-spin-button {
  display: none;
}
.unique-form button {
  margin-top: 25px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  border: none;
  padding: 9px 0;
  cursor: pointer;
  border-radius: 6px;
  pointer-events: none;
  background: #6e93f7;
  transition: all 0.2s ease;
}
.unique-form button.active {
  background: #4070f4;
  pointer-events: auto;
}
.unique-form button:hover {
  background: #0e4bf1;
}

</style>
<script>
  // Encapsulate the entire script inside an anonymous function
  (function() {
    const inputs = document.querySelectorAll(".unique-container input"),
          button = document.querySelector(".unique-container button");

    // iterate over all inputs
    inputs.forEach((input, index1) => {
      input.addEventListener("keyup", (e) => {
        const currentInput = input,
              nextInput = input.nextElementSibling,
              prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
          currentInput.value = "";
          return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
          nextInput.removeAttribute("disabled");
          nextInput.focus();
        }

        if (e.key === "Backspace") {
          inputs.forEach((input, index2) => {
            if (index1 <= index2 && prevInput) {
              input.setAttribute("disabled", true);
              input.value = "";
              prevInput.focus();
            }
          });
        }

        if (!inputs[3].disabled && inputs[3].value !== "") {
          button.classList.add("active");
          return;
        }
        button.classList.remove("active");
      });
    });

    window.addEventListener("load", () => inputs[0].focus());
  })();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(isset($_GET['error'])): ?>
        let timerInterval;
        Swal.fire({
            title: "Try Again!",
            html: "<?php echo htmlspecialchars($_GET['error']); ?>",
            timer: 4000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log("Alert was closed by the timer");
            }
        });
        <?php endif; ?>
    });
    </script>