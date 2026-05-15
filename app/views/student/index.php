<?php
/** @var array $students */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>

    <style>
        body{
            font-family: Arial;
            padding: 40px;
            background: #f4f4f4;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td{
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th{
            background: #007bff;
            color: white;
        }

        h1{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Danh sách sinh viên</h1>

    <table>
        <tr>
            <th>Mã SV</th>
            <th>Họ tên</th>
            <th>Lớp</th>
        </tr>

        <?php foreach($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= $student['name'] ?></td>
                <td><?= $student['class'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>
</html>