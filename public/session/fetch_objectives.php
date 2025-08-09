<?php
include('../../includes/database.php');

// Define the start and end dates for the current week
$start_date = date('Y-m-d', strtotime('monday this week'));
$end_date = date('Y-m-d', strtotime('friday this week'));

// Query to get subject objectives for the current week
$sql = "
    SELECT subject_name, objective, start_date, end_date
    FROM subject_objectives
";
$conn->connect($sql);

$conn->close();
?>