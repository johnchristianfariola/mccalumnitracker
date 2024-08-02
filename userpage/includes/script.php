<script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector(".form");
    const nextBtn = form.querySelector(".nextBtn");
    const backBtn = form.querySelector(".backBtn");
    const formSections = form.querySelectorAll(".form-section");

    let currentSection = 0;

    function showSection(index) {
        formSections.forEach((section, i) => {
            if (i === index) {
                section.classList.add("active");
                section.classList.remove("hidden");
            } else {
                section.classList.remove("active");
                section.classList.add("hidden");
            }
        });
    }

    nextBtn.addEventListener("click", function () {
        if (validateInputs(formSections[currentSection])) {
            currentSection++;
            showSection(currentSection);
        } else {
            document.body.classList.add('no-scroll'); // Disable scrolling
            Swal.fire({
                title: 'Incomplete Form',
                text: 'Please fill in all required fields before proceeding.',
                icon: 'warning',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
            }).then(() => {
                document.body.classList.remove('no-scroll'); // Re-enable scrolling
            });
        }
    });

    backBtn.addEventListener("click", function () {
        currentSection--;
        showSection(currentSection);
    });

    function validateInputs(section) {
        const inputs = section.querySelectorAll("input[required], select[required]");
        let isValid = true;
        let firstInvalidInput = null;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = "red";
                if (!firstInvalidInput) {
                    firstInvalidInput = input;
                }
            } else {
                input.style.borderColor = "";
            }
        });

        if (firstInvalidInput) {
            firstInvalidInput.focus();
        }

        return isValid;
    }

    function toggleEmploymentFields() {
        const selectedStatus = document.getElementById('work-status').value;
        if (selectedStatus === 'Employed') {
            document.querySelectorAll('#first_employment_date, #date_for_current_employment, #type_of_work, #work_position, #current_monthly_income, #work_related').forEach(field => {
                field.closest('.input-field').style.display = 'block';
                field.setAttribute('required', true);
            });
        } else {
            document.querySelectorAll('#first_employment_date, #date_for_current_employment, #type_of_work, #work_position, #current_monthly_income, #work_related').forEach(field => {
                field.closest('.input-field').style.display = 'none';
                field.removeAttribute('required');
            });
        }
    }

    document.getElementById('work-status').addEventListener('change', toggleEmploymentFields);
    toggleEmploymentFields();

    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profileDisplay').style.backgroundImage = `url(${e.target.result})`;
                document.querySelector('.custom-label').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('profileImageInput').addEventListener('change', function () {
        displayImage(this);
    });

    // Initialize the form
    showSection(currentSection);

    // Improve user experience by showing which fields are required
    document.querySelectorAll('input[required], select[required]').forEach(element => {
        element.addEventListener('blur', function () {
            if (!this.value.trim()) {
                this.style.borderColor = "red";
            } else {
                this.style.borderColor = "";
            }
        });
    });
        });

      
document.addEventListener('DOMContentLoaded', function () {
  var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
    keyboard: false
  });
  
  welcomeModal.show();
  
  // Remove any inline padding-right that Bootstrap might add
  document.body.style.paddingRight = '';
  document.querySelector('.modal').style.paddingRight = '';
  
  // Ensure body doesn't scroll when modal is open
  var modalElement = document.getElementById('welcomeModal');
  modalElement.addEventListener('show.bs.modal', function () {
    document.body.classList.add('modal-open');
  });
  modalElement.addEventListener('hidden.bs.modal', function () {
    document.body.classList.remove('modal-open');
  });
});


    </script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../homepage/lib/wow/wow.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../homepage/lib/wow/wow.min.js"></script>
    <script src="../homepage/lib/easing/easing.min.js"></script>
    <script src="../homepage/lib/waypoints/waypoints.min.js"></script>
    <script src="../homepage/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../homepage/js/main.js"></script>