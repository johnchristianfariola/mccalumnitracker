<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
function displaySurveyQuestionsAndAnswers($surveyId)
{
    global $firebase;

    // Fetch survey details
    $surveyData = $firebase->retrieve("survey_set/$surveyId");
    $survey = json_decode($surveyData, true);

    if (!$survey) {
        echo "<p>Survey not found.</p>";
        return;
    }

    echo "<h2>" . htmlspecialchars($survey['survey_title']) . "</h2>";
    echo "<p>" . htmlspecialchars($survey['survey_desc']) . "</p>";

    // Fetch questions for this survey
    $questionsData = $firebase->retrieve("questions");
    $questions = json_decode($questionsData, true);

    // Fetch answers for this survey
    $answersData = $firebase->retrieve("answers");
    $answers = json_decode($answersData, true);

    echo "<div class='box'>";
    echo "<div class='box-header'>";
    echo "<h3 class='box-title'>Survey Results</h3>";
    echo "</div>";
    echo "<div class='box-body no-padding'>";
    echo "<table class='table'>";
    echo "<tr><th style='width: 5%'>#</th><th style='width: 30%'>Question</th><th style='width: 55%'>Progress</th><th style='width: 10%'>Percentage</th></tr>";

    $questionCount = 0;
    foreach ($questions as $questionId => $question) {
        if ($question['survey_set_unique_id'] == $surveyId) {
            $questionCount++;
            $options = json_decode($question['frm_option'], true);
            $answerCounts = array_fill_keys(array_keys($options), 0);
            $respondents = [];

            // Count answers for this question
            foreach ($answers as $answerId => $answer) {
                if ($answer['question_id'] == $questionId) {
                    $answerValue = $answer['answer'];
                    if (isset($answerCounts[$answerValue])) {
                        $answerCounts[$answerValue]++;
                        $respondents[] = $answer['alumni_id'];
                    }
                }
            }

            $totalRespondents = count(array_unique($respondents));

            echo "<tr>";
            echo "<td rowspan='" . (count($options) + 1) . "'>" . $questionCount . "</td>";
            echo "<td rowspan='" . (count($options) + 1) . "'>" . htmlspecialchars($question['question']) . "</td>";
            echo "<td colspan='2'></td>";  // Empty cell for spacing
            echo "</tr>";

            foreach ($options as $optionId => $optionText) {
                $count = $answerCounts[$optionId];
                $percentage = $totalRespondents > 0 ? round(($count / $totalRespondents) * 100, 2) : 0;
                echo "<tr>";
                echo "<td>";
                echo "<div style='display: flex; justify-content: space-between;'>";
                echo "<span>" . htmlspecialchars($optionText) . "</span>";
                echo "<span>(" . $count . " responses)</span>";
                echo "</div>";
                echo "<div class='progress progress-xs'>";
                echo "<div class='progress-bar progress-bar-primary' style='width: " . $percentage . "%'></div>";
                echo "</div>";
                echo "</td>";
                echo "<td><span class='badge bg-light-blue'>" . $percentage . "%</span></td>";
                echo "</tr>";
            }

            echo "<tr><td colspan='4'>Total Respondents: " . $totalRespondents . "</td></tr>";
        }
    }

    echo "</table>";
    echo "</div>";
    echo "</div>";
}
?>

<style>
    .box-header {
        width: 100%;
        height: 35px;
        background: white !important;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header box-header-background">
                <h1>
                    Survey <i class="fa fa-angle-right"></i> Results
                </h1>
                <div class="box-inline">
                    <div class="search-container">
                        <input type="text" class="search-input" id="search-input" placeholder="Search...">
                        <button class="search-button" onclick="filterTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Survey</li>
                    <li class="active">Results</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-solid" style="border-radius: none !important;">
                            <div class="box-header with-border">
                                <h3 class="box-title">Surveys</h3>
                                <div class="box-tools">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body no-padding">
                                <ul class="nav nav-pills nav-stacked">
                                    <?php
                                    $surveysData = $firebase->retrieve("survey_set");
                                    $surveys = json_decode($surveysData, true);
                                    $surveyId = isset($_GET['id']) ? $_GET['id'] : null;
                                    foreach ($surveys as $id => $survey) {
                                        echo '<li' . ($id == $surveyId ? ' class="active"' : '') . '><a href="?id=' . $id . '">' . htmlspecialchars($survey['survey_title']) . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Survey Results</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php
                                if ($surveyId) {
                                    displaySurveyQuestionsAndAnswers($surveyId);
                                } else {
                                    echo "<p>No survey selected. Please choose a survey from the list.</p>";
                                }
                                ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/news_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>

    <script>
        $(function () {
            // Initialize iCheck for all checkboxes
            $('.mailbox-messages input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            // Check/uncheck all checkboxes functionality
            $('.checkbox-toggle').click(function () {
                var $this = $(this);
                var isChecked = $this.data('clicks');
                if (isChecked) {
                    // Uncheck all checkboxes
                    $('.mailbox-messages input[type="checkbox"]').iCheck('uncheck');
                    $this.find('i').removeClass('fa-check-square-o').addClass('fa-square-o');
                } else {
                    // Check all checkboxes
                    $('.mailbox-messages input[type="checkbox"]').iCheck('check');
                    $this.find('i').removeClass('fa-square-o').addClass('fa-check-square-o');
                }
                $this.data('clicks', !isChecked);
            });

            // Handle starring for glyphicon and font awesome
            $(".mailbox-star").click(function (e) {
                e.preventDefault();
                var $this = $(this).find("a > i");
                $this.toggleClass("glyphicon-star glyphicon-star-empty fa-star fa-star-o");
            });
        });

        function filterTable() {
            // Implement search functionality here
            console.log("Search functionality not implemented yet");
        }
    </script>

</body>

</html>