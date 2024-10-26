    <?php
    require_once 'includes/firebaseRDB.php';
    require_once 'includes/config.php'; // Include your config file

    $firebase = new firebaseRDB($databaseURL);


    function getFirebaseData($firebase, $path) {
        $data = $firebase->retrieve($path);
        return json_decode($data, true);
    }

    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags($data));
    }

    $alumniData = getFirebaseData($firebase, "alumni");
    $batchData = getFirebaseData($firebase, "batch_yr");
    $courseData = getFirebaseData($firebase, "course");

    $filterCourse = isset($_GET['course']) ? sanitizeInput($_GET['course']) : '';
    $filterBatch = isset($_GET['batch']) ? sanitizeInput($_GET['batch']) : '';

    // Check if alumniData is an array before looping through it
    if (is_array($alumniData) && count($alumniData) > 0) {
        foreach ($alumniData as $id => $alumni) {
            $courseId = $alumni['course'];
            $batchId = $alumni['batch'];

            if ($filterCourse && $filterCourse != $courseId) {
                continue;
            }
            if ($filterBatch && $filterBatch != $batchId) {
                continue;
            }

            $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';
            $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';

            echo "<tr>
            <td style='display:none;'><input type='checkbox' class='modal-checkbox'  data-id='$id'></td>
            <td>{$alumni['studentid']}</td>
            <td>{$alumni['firstname']}</td>
            <td>{$alumni['middlename']}</td>
            <td>{$alumni['lastname']}</td>
            <td>{$alumni['email']}</td>
            <td>{$alumni['gender']}</td>
            <td>{$courseName}</td>
            <td>{$batchName}</td>
            <td>
            <a class='btn btn-success btn-sm btn-flat open-modal' data-id='$id'>EDIT</a>
            <!--<a class='btn btn-danger btn-sm btn-flat open-delete' data-id='$id'>DELETE</a>-->
            </td>
            </tr>";
        } 
    } 
    ?>

    <!-- Modal for Delete Confirmation -->
