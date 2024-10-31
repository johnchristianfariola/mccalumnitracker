<?php
//fetch_deleteSurvey.php
require_once 'includes/firebaseRDB.php';

require_once 'includes/config.php'; // Include your config file

$firebase = new firebaseRDB($databaseURL);

$data = $firebase->retrieve("deleted_survey_set");
$data = json_decode($data, true);

if (is_array($data)) {
    foreach ($data as $id => $survey) {
        echo "<tr>
                <td>{$survey['survey_title']}</td>
                <td><i>{$survey['survey_desc']}</i> </td>
                <td>{$survey['survey_start']}</td>
                <td>{$survey['survey_end']}</td>
                <td>
                <a class='btn btn-success btn-sm btn-flat open-retrieve' data-id='$id'>RESTORE</a>
                <a class='btn btn-danger btn-sm btn-flat open-delete' data-id='$id'>DELETE</a>
                </td>
              </tr>";
    }
}
?>