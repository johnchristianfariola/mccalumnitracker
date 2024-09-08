<?php
include '../includes/session.php';
require_once '../includes/firebaseRDB.php';
require_once '../includes/config.php';

$firebase = new firebaseRDB($databaseURL);

// Get the survey_set_unique_id from the URL parameter
$survey_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$survey_id) {
    die("No survey ID provided");
}

// Retrieve the survey details
$surveyData = $firebase->retrieve("survey_set/$survey_id");
$surveyData = json_decode($surveyData, true);

// Retrieve all questions
$questionData = $firebase->retrieve("questions");
$questionData = json_decode($questionData, true);

// Filter questions based on survey_set_unique_id
$filteredQuestions = array_filter($questionData, function($question) use ($survey_id) {
    return isset($question['survey_set_unique_id']) && $question['survey_set_unique_id'] == $survey_id;
});

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumni_id = $_SESSION['alumni_id']; // Assuming the alumni ID is stored in the session
    $date_created = date('Y-m-d H:i:s');

    foreach ($filteredQuestions as $questionId => $question) {
        $answer = isset($_POST["question_$questionId"]) ? $_POST["question_$questionId"] : null;

        if ($answer !== null) {
            $answerData = [
                'survey_id' => $survey_id,
                'alumni_id' => $alumni_id,
                'answer' => is_array($answer) ? json_encode($answer) : $answer,
                'question_id' => $questionId,
                'date_created' => $date_created
            ];

            $result = $firebase->insert("answers", $answerData);

            if ($result === null) {
                // Handle error
                echo "Error inserting answer for question $questionId<br>";
            }
        }
    }

    // Log the survey completion in the survey_log
    $logData = [
        'alumni_id' => $alumni_id,
        'survey_id' => $survey_id,
        'completion_date' => $date_created,
        'status' => 'done'
    ];
    $firebase->insert("survey_log", $logData);

    // Set a session variable to trigger the SweetAlert
    $_SESSION['survey_completed'] = true;

    // Redirect back to the view_survey.php page
    header("Location: view_survey.php");
    exit();
}

// Function to generate question HTML based on question type
function generateQuestionHTML($question, $questionId)
{
    $html = '<div class="form-group">';
    $html .= '<label class="survey-question-modern">' . htmlspecialchars($question['question']) . '</label>';

    switch ($question['type']) {
        case 'radio_opt':
            $html .= '<div class="radio-group-modern">';
            $options = json_decode($question['frm_option'], true);
            foreach ($options as $optionId => $optionText) {
                $html .= '<label class="radio-modern">';
                $html .= '<input type="radio" name="question_' . $questionId . '" value="' . htmlspecialchars($optionId) . '">';
                $html .= '<span class="custom-radio"></span>' . htmlspecialchars($optionText);
                $html .= '</label>';
            }
            $html .= '</div>';
            break;
        case 'check_opt':
            $html .= '<div class="checkbox-group-modern">';
            $options = json_decode($question['frm_option'], true);
            foreach ($options as $optionId => $optionText) {
                $html .= '<label class="checkbox-modern">';
                $html .= '<input type="checkbox" name="question_' . $questionId . '[]" value="' . htmlspecialchars($optionId) . '">';
                $html .= '<span class="custom-checkbox"></span>' . htmlspecialchars($optionText);
                $html .= '</label>';
            }
            $html .= '</div>';
            break;
        case 'text_opt':
            $html .= '<textarea class="form-control-modern" name="question_' . $questionId . '" rows="4" placeholder="Type your answer here..."></textarea>';
            break;
        default:
            $html .= '<p>Unsupported question type</p>';
    }

    $html .= '</div>';
    return $html;
}
?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include 'includes/header.php' ?>
    <style>
        .survey-form-modern {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3), 0 2px 6px 2px rgba(60, 64, 67, 0.15);
            margin-top: 20px;
        }

        .form-header {
            border-top: 10px solid #4285f4;
            margin: -40px -40px 30px;
            padding: 20px 40px;
            background-color: #f8f9fa;
        }

        .form-title {
            font-size: 32px;
            font-weight: 400;
            color: #202124;
            margin-bottom: 10px;
        }

        .form-description {
            font-size: 14px;
            color: #5f6368;
        }

        .survey-question-modern {
            font-size: 16px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 12px;
        }

        .radio-group-modern,
        .checkbox-group-modern {
            margin-bottom: 24px;
        }

        .radio-modern,
        .checkbox-modern {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #202124;
        }

        .custom-radio,
        .custom-checkbox {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 2px solid #5f6368;
            transition: all 0.2s ease;
        }

        .custom-radio {
            border-radius: 50%;
        }

        .custom-checkbox {
            border-radius: 2px;
        }

        .radio-modern input[type="radio"],
        .checkbox-modern input[type="checkbox"] {
            display: none;
        }

        .radio-modern input[type="radio"]:checked~.custom-radio,
        .checkbox-modern input[type="checkbox"]:checked~.custom-checkbox {
            background-color: #4285f4;
            border-color: #4285f4;
        }

        .custom-radio::after,
        .custom-checkbox::after {
            content: "";
            display: block;
            width: 10px;
            height: 10px;
            margin: 3px;
            border-radius: 50%;
            background-color: white;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .radio-modern input[type="radio"]:checked~.custom-radio::after,
        .checkbox-modern input[type="checkbox"]:checked~.custom-checkbox::after {
            opacity: 1;
        }

        .form-control-modern {
            width: 100%;
            border: 1px solid #dadce0;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            color: #202124;
            transition: border-color 0.2s ease;
        }

        .form-control-modern:focus {
            border-color: #4285f4;
            outline: none;
        }

        .btn-modern {
            background-color: #4285f4;
            color: #ffffff;
            padding: 10px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.2s ease;
        }

        .btn-modern:hover {
            background-color: #3367d6;
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="main-content">
        <div class="sale-statistic-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <form class="survey-form-modern" method="POST">
                            <div class="form-header">
                                <h1 class="form-title"><?php echo htmlspecialchars($surveyData['survey_title']); ?></h1>
                                <p class="form-description"><?php echo htmlspecialchars($surveyData['survey_desc']); ?></p>
                            </div>

                            <?php
                            foreach ($filteredQuestions as $questionId => $question) {
                                echo generateQuestionHTML($question, $questionId);
                            }
                            ?>

                            <div class="form-group">
                                <button type="submit" class="btn-modern">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="right-section">
                            <!-- Event, Job, and Forum sections will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>