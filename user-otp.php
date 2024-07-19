

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