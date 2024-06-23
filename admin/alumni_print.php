<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for printing */
        @media print {
            body {
                margin: 1in; /* 1-inch margins */
            }
            .printable-table {
                width: 100%;
                border-collapse: collapse;
                page-break-inside: auto;
            }
            .printable-table th,
            .printable-table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            .printable-table th {
                background-color: #f2f2f2;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Alumni Data</h2>
        
        <!-- Table to Print -->
        <table id="printTable" class="printable-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Batch</th>
                </tr>
            </thead>
            <tbody id="printTableBody">
                <?php
                if (isset($_GET['data'])) {
                    $encodedData = $_GET['data'];
                    $dataToPrint = json_decode(urldecode($encodedData), true);
                    
                    foreach ($dataToPrint as $rowHtml) {
                        echo "<tr>" . $rowHtml . "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

      
    </div>
</body>
</html>
