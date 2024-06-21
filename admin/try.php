<?php
// Include FirebaseRDB class
require_once 'includes/firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

// Retrieve data from Firebase
$alumniData = $firebase->retrieve("alumni");
$alumniData = json_decode($alumniData, 1);

$batchData = $firebase->retrieve("batch_yr");
$batchData = json_decode($batchData, 1);

$courseData = $firebase->retrieve("course");
$courseData = json_decode($courseData, 1);

if (is_array($alumniData)) {
    foreach ($alumniData as $id => $alumni) {
        // Get batch year name
        $batchId = $alumni['batch'];
        $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';

        // Get course name
        $courseId = $alumni['course'];
        $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

        echo "<tr>
        <td>{$alumni['studentid']}</td>
        <td>{$alumni['firstname']} {$alumni['middlename']} {$alumni['lastname']}</td>
        <td>{$alumni['email']}</td>
        <td>{$alumni['gender']}</td>
        <td>{$courseName}</td>
        <td>{$batchName}</td>
        <td><a class='btn btn-success  btn-sm btn-flat open-modal' data-id='$id'>EDIT</a></td>
        <td><a class='btn btn-danger btn-sm delete btn-flat' href='delete.php?id=$id'>DELETE</a></td>
    </tr>";

    }
}
?>


<?php
// Include FirebaseRDB class
require_once 'includes/firebaseRDB.php';

// Firebase Realtime Database URL
$databaseURL = "https://mccnians-bc4f4-default-rtdb.firebaseio.com";

// Instantiate FirebaseRDB object
$firebase = new firebaseRDB($databaseURL);

// Retrieve data from Firebase
$alumniData = $firebase->retrieve("alumni");
$alumniData = json_decode($alumniData, true);

$batchData = $firebase->retrieve("batch_yr");
$batchData = json_decode($batchData, true);

$courseData = $firebase->retrieve("course");
$courseData = json_decode($courseData, true);

// Filter variables
$filterCourse = isset($_GET['course']) ? $_GET['course'] : '';
$filterBatch = isset($_GET['batch']) ? $_GET['batch'] : '';



// Loop through alumni data
foreach ($alumniData as $id => $alumni) {
    // Retrieve course and batch IDs from alumni data
    $courseId = $alumni['course'];
    $batchId = $alumni['batch'];

    // Filter based on selected course and batch (if applicable)
    if ($filterCourse && $filterCourse != $courseId) {
        continue; // Skip this alumni record if course doesn't match
    }
    if ($filterBatch && $filterBatch != $batchId) {
        continue; // Skip this alumni record if batch doesn't match
    }

    // Get batch year name
    $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';

    // Get course name
    $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

    // Output table row
    echo "<tr>
    <td>{$alumni['studentid']}</td>
    <td>{$alumni['firstname']} {$alumni['middlename']} {$alumni['lastname']}</td>
    <td>{$alumni['email']}</td>
    <td>{$alumni['gender']}</td>
    <td>{$courseName}</td>
    <td>{$batchName}</td>
    <td><a class='btn btn-success  btn-sm btn-flat open-modal' data-id='$id'>EDIT</a></td>
    <td><a class='btn btn-danger btn-sm delete btn-flat' href='delete.php?id=$id'>DELETE</a></td>
</tr>";
}

?>













$(document).ready(function () {
      // Open edit modal when edit button is clicked
      $('.open-modal').click(function () {
        var id = $(this).data('id');
        $.ajax({
          url: 'alumni_row.php',
          type: 'GET',
          data: { id: id },
          dataType: 'json',
          success: function (response) {
            $('#editId').val(id);
            $('#editFirstname').val(response.firstname);
            $('#editLastname').val(response.lastname);
            $('#editMiddlename').val(response.middlename);
            $('#editAuxiliaryname').val(response.auxiliaryname);
            $('#editBirthdate').val(response.birthdate);
            $('#editCivilstatus').val(response.civilstatus);
            $('#editMale').prop('checked', response.gender === 'male');
            $('#editMemale').prop('checked', response.gender === 'female');
            $('#editAddressline1').val(response.addressline1);
            $('#editCity').val(response.city);
            $('#editState').val(response.state);
            $('#editZipcode').val(response.zipcode);
            $('#editContactnumber').val(response.contactnumber);
            $('#editEmail').val(response.email);
            $('#editCourse').val(response.course);
            $('#editBatch').val(response.batch);
            $('#editStudentid').val(response.studentid);



            $('#editModal').modal('show');
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
          }
        });
      });

    });
    $('.open-delete').click(function () {
      var id = $(this).data('id');

      // Make an AJAX request to fetch data for the specified ID
      $.ajax({
        url: 'alumni_row.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          // Populate modal fields with retrieved data
          $('#deleteId').val(id); // Assuming you have an input field with id 'deleteId'
          $('#editFirstname').val(response.firstname); // Assuming you have an input field with id 'editFirstname'
          // Populate other fields similarly

          // Show the modal
          $('#deleteModal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ' ' + error);
          // Handle error (e.g., display an error message)
        }
      });
    });


    // Make an AJAX request to fetch data for the specified ID
          $.ajax({
            url: 'alumni_row.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
              // Populate modal fields with retrieved data
              $('.deleteId').val(id); // Update value of deleteId input field
              $('.editFirstname').text(response.firstname); // Update text content of editFirstname element
              // Populate other fields similarly

              // Show the delete modal
              $('#deleteModal').modal('show');
            },
            error: function (xhr, status, error) {
              console.error('AJAX Error: ' + status + ' ' + error);
              // Handle error (e.g., display an error message)
            }
          });
        });
