<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập mảng 2 chiều</title>
</head>

<body>
    <form method="post">
        <label for="rows">Nhập số hàng:</label><br>
        <input type="number" name="rows" id="rows" required><br><br>

        <label for="cols">Nhập số cột:</label><br>
        <input type="number" name="cols" id="cols" required><br><br>

        <label for="elements">Nhập các phần tử của mảng (cách nhau bằng dấu phẩy):</label><br>
        <textarea name="elements" id="elements" rows="5" cols="30" placeholder="Ví dụ: 3,5,2,8,1,9,6"
            required></textarea><br><br>

        <input type="submit" value="Tìm giá trị lớn nhất">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $rows = $_POST['rows'];
        $cols = $_POST['cols'];
        $input = $_POST['elements'];


        $elements = array_map('intval', explode(',', $input));


        if (count($elements) != $rows * $cols) {
            echo "Số phần tử không khớp với số hàng và cột.";
        } else {

            $matrix = [];
            $index = 0;
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $cols; $j++) {
                    $matrix[$i][$j] = $elements[$index++];
                }
            }


            function findMax($matrix)
            {
                $max = $matrix[0][0];
                $maxRow = $maxCol = 0;
                foreach ($matrix as $i => $row) {
                    foreach ($row as $j => $value) {
                        if ($value > $max) {
                            $max = $value;
                            $maxRow = $i;
                            $maxCol = $j;
                        }
                    }
                }
                return ['max' => $max, 'row' => $maxRow, 'col' => $maxCol];
            }


            $maxInfo = findMax($matrix);
            echo "Mảng: <br>";
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $cols; $j++) {
                    echo $matrix[$i][$j] . " ";
                }
                echo "<br>";
            }
            echo "<br>";
            echo "Giá trị lớn nhất là: " . $maxInfo['max'] . "<br>";
            echo "Vị trí của giá trị lớn nhất là: Hàng " . ($maxInfo['row'] + 1) . ", Cột " . ($maxInfo['col'] + 1) . "<br>";
        }
    }
    ?>
</body>

</html>