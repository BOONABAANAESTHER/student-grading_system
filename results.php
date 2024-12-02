<?php
include 'resultsdb.php';

$students = get_students();


function get_grade($marks) {
    if ($marks >= 80) return "D1";
    if ($marks >= 75) return "D2";
    if ($marks >= 70) return "C3";
    if ($marks >= 65) return "C4";
    if ($marks >= 60) return "C5";
    if ($marks >= 55) return "C6";
    if ($marks >= 50) return "P7";
    if ($marks >= 45) return "P8";
    return "F9";
}

function get_total_grade($eng, $mtc, $sci, $sst) {
    $num_eng = preg_replace('/\D/', '', $eng);
    $num_mtc = preg_replace('/\D/', '', $mtc);
    $num_sci = preg_replace('/\D/', '', $sci);
    $num_sst = preg_replace('/\D/', '', $sst);
    $total = $num_eng + $num_mtc + $num_sci + $num_sst;

    return $total;
}

function calculate_total_and_aggregate($student) {
    $total = $student['ENG'] + $student['MTC'] + $student['SCI'] + $student['SST'];
    $average = $total / 4;
    return [$total, get_grade($average)];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Student Results</h2>
        <a href="resultcreate.php" class="btn btn-success mb-3">Add marks</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>Student</th>
                    <th colspan = "2">ENG</th>
                    <th colspan = "2">MTC</th>
                    <th colspan = "2">SCI</th>
                    <th colspan = "2">SST</th>
                    <th>Total</th>
                    <th>Aggregate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $index => $student): 
                    list($total, $aggregate) = calculate_total_and_aggregate($student);
                ?>
                    <tr>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['ENG']; ?></td>
                        <td><?php echo get_grade($student['ENG']); ?></td>
                        <td><?php echo $student['MTC']; ?></td>
                        <td><?php echo get_grade($student['MTC']); ?></td>
                        <td><?php echo $student['SCI']; ?></td>
                        <td><?php echo get_grade($student['SCI']); ?></td>
                        <td><?php echo $student['SST']; ?></td>
                        <td><?php echo get_grade($student['SST']); ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo get_total_grade(get_grade($student['ENG']), get_grade($student['MTC']), get_grade($student['SCI']), get_grade($student['SST'])) ?></td>
                        <td>
                            <a href="resultupdate.php?id=<?php echo $student['id']; ?>" class="btn btn-primary" style="background-color: #2a2185;">Edit</a>
                            <a href="resultdelete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>