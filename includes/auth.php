<!-- Bootstrap CSS -->
<style>


  .modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
  }

  .modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
    margin: 0;
    
  }

  .modal-dialog {
    position: relative;
   
    width: 100%;
    margin: 0.5rem;
    pointer-events: none;
  }

  .modal.fade .modal-dialog {
    transition: -webkit-transform 0.3s ease-out;
    transition: transform 0.3s ease-out;
    transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
    -webkit-transform: translate(0, -50px);
    transform: translate(0, -50px);
  }

  @media (prefers-reduced-motion: reduce) {
    .modal.fade .modal-dialog {
      transition: none;
    }
  }

  .modal.show .modal-dialog {
    -webkit-transform: none;
    transform: none;
  }

  .modal.modal-static .modal-dialog {
    -webkit-transform: scale(1.02);
    transform: scale(1.02);
  }

  .modal-dialog-scrollable {
    display: -ms-flexbox;
    display: flex;
    max-height: calc(100% - 1rem);
  }

  .modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 1rem);
    overflow: hidden;
  }

  .modal-dialog-scrollable .modal-footer,
  .modal-dialog-scrollable .modal-header {
    -ms-flex-negative: 0;
    flex-shrink: 0;
  }

  .modal-dialog-scrollable .modal-body {
    overflow-y: auto;
  }

  .modal-dialog-centered {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    min-height: calc(100% - 1rem);
  }

  .modal-dialog-centered::before {
    display: block;
    height: calc(100vh - 1rem);
    height: -webkit-min-content;
    height: -moz-min-content;
    height: min-content;
    content: "";
  }

  .modal-dialog-centered.modal-dialog-scrollable {
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    height: 100%;
  }

  .modal-dialog-centered.modal-dialog-scrollable .modal-content {
    max-height: none;
  }

  .modal-dialog-centered.modal-dialog-scrollable::before {
    content: none;
  }

  .modal-content {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.3rem;
    outline: 0;
  }

  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
  }

  .modal-backdrop.fade {
    opacity: 0;
  }

  .modal-backdrop.show {
    opacity: 0.5;
  }

  .modal-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
  }

  .modal-header .close {
    padding: 1rem 1rem;
    margin: -1rem -1rem -1rem auto;
  }

  .modal-title {
    margin-bottom: 0;
    line-height: 1.5;
  }

  .modal-body {
    position: relative;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1rem;
  }

  .modal-footer {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: end;
    justify-content: flex-end;
    padding: 0.75rem;
    border-top: 1px solid #dee2e6;
    border-bottom-right-radius: calc(0.3rem - 1px);
    border-bottom-left-radius: calc(0.3rem - 1px);
  }

  .modal-footer>* {
    margin: 0.25rem;
  }



  @media (min-width: 576px) {
    .modal-dialog {
      max-width: 500px;
      margin: 1.75rem auto;
      width: 100%;
    }

    .modal-dialog-scrollable {
      max-height: calc(100% - 3.5rem);
    }

    .modal-dialog-scrollable .modal-content {
      max-height: calc(100vh - 3.5rem);
    }

    .modal-dialog-centered {
      min-height: calc(100% - 3.5rem);
    }

    .modal-dialog-centered::before {
      height: calc(100vh - 3.5rem);
      height: -webkit-min-content;
      height: -moz-min-content;
      height: min-content;
    }

    .modal-sm {
      max-width: 300px;
    }
  }

  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 800px;
    }
  }

  @media (min-width: 1200px) {
    .modal-xl {
      max-width: 1140px;
    }

  }

  .close {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
  }

  .close span {
    font-size: 1.5rem;
    line-height: 1;
    color: #000;
    opacity: 0.5;
  }

  .close span:hover {
    color: #000;
    text-decoration: none;
    opacity: 0.75;
  }

  /* Form styles */
  .form-group {
    margin-bottom: 1rem;
  }

  label {
    display: inline-block;
    margin-bottom: 0.5rem;
  }

  .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }


  .form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }
</style>
<!-- Modal -->
<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signInModalLabel">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='callout callout-danger text-center mt20'>
                <p>" . $_SESSION['error'] . "</p> 
            </div>
          ";
          unset($_SESSION['error']);
        }
        ?>
        <form class="form-horizontal" method="POST" action="login.php">
          <img src="assets/images/logo-dark.png" alt="" class="img-fluid mb-4">
          <h4 class="mb-3 f-w-400">Signin</h4>
          <div class="form-group mb-3">
            <label class="floating-label" for="Email">Email address</label>
            <input type="email" class="form-control" name="username" placeholder="Input Username" required autofocus>
          </div>
          <div class="form-group mb-4">
            <label class="floating-label" for="Password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Input Password" required>
          </div>
          <div class="custom-control custom-checkbox text-left mb-4 mt-2">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Save credentials.</label>
          </div>
          <button type="submit" name="login" class="btn btn-block btn-primary mb-4">Signin</button>
          <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p>
          <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>