<?php
if (is_array($alumniData) && count($alumniData) > 0) {
    foreach ($alumniData as $id => $alumni) {
        if (!isset($alumni['forms_completed']) || $alumni['forms_completed'] !== true) {
            continue;
        }

        $courseId = $alumni['course'];
        $batchId = $alumni['batch'];
        $workStatus = $alumni['work_status'];
        $workClassification = isset($alumni['work_classification']) ? $alumni['work_classification'] : '';

        if ($filterCourse && $filterCourse != $courseId) {
            continue;
        }
        if ($filterBatch && $filterBatch != $batchId) {
            continue;
        }
        if ($filterStatus && $filterStatus != $workStatus) {
            continue;
        }
        if ($filterWorkClassification && $filterWorkClassification != $workClassification) {
            continue;
        }

        // Count based on work status
        if ($workStatus === 'Employed') {
            $status_html = '<span class="label label-success" style="font-size: 12px !important; padding: 5px 20px !important; background: #4caf50 !important">EMPLOYED</span>';
            $employedCount++;
        } elseif ($workStatus === 'Unemployed') {
            $status_html = '<span class="label label-danger" style="font-size: 12px !important; padding: 5px 20px !important; background: #ff5252 !important">UNEMPLOYED</span>';
            $unemployedCount++;
        } else {
            $status_html = '<span class="label label-default" style="font-size: 12px !important; padding: 5px 20px !important; background: #b0bec5 !important">UNKNOWN</span>';
        }
        $totalCount++;

        $batchName = isset($batchData[$batchId]['batch_yrs']) ? $batchData[$batchId]['batch_yrs'] : 'Unknown Batch';
        $courseName = isset($courseData[$courseId]['courCode']) ? $courseData[$courseId]['courCode'] : 'Unknown Course';
        $workClassificationName = isset($categoryData[$workClassification]['category_name']) ? $categoryData[$workClassification]['category_name'] : 'Unknown';

        // Add default image if no profile image is found
        $profileImage = isset($alumni['profile_url']) && !empty($alumni['profile_url']) ? $alumni['profile_url'] : 'uploads/profile.jpg';
        $image_html = "<img src='../userpage/{$profileImage}' alt='Profile Image' width='65px' height=65px'>";

        echo "<tr>
            <td style='display:none;'><input type='checkbox' class='modal-checkbox' data-id='$id'></td>
            <td>{$image_html}</td>
            <td>{$alumni['studentid']}</td>
            <td>{$alumni['firstname']} {$alumni['middlename']} {$alumni['lastname']}</td>
            <td>{$courseName}</td>
            <td>{$batchName}</td>
            <td style='text-align:center;'>{$status_html}</td>
            <td>{$workClassificationName}</td>
            <td>
                <a class='btn btn-warning btn-sm btn-flat open-modal' data-id='$id'>VIEW</a>
            </td>
        </tr>";
    }
}
?>
