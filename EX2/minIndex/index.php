<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập mảng</title>
</head>

<body>
    <form method="post">
        <label for="elements">Nhập các phần tử của mảng, cách nhau bằng dấu phẩy:</label><br>
        <input type="text" name="elements" id="elements" placeholder="Ví dụ: 3,5,2,8,1,9,6" required><br><br>
        <input type="submit" value="Tìm giá trị nhỏ nhất">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = $_POST['elements'];
        $array = array_map('intval', explode(',', $input));


        function findMinIndex($array)
        {
            $min = $array[0];
            $index = 0;

            for ($i = 1; $i < count($array); $i++) {
                if ($array[$i] < $min) {
                    $min = $array[$i];
                    $index = $i;
                }
            }

            return $index;
        }


        $minIndex = findMinIndex($array);
        echo "Mảng: " . implode(', ', $array) . "<br>";
        echo "Vị trí phần tử nhỏ nhất trong mảng: " . $minIndex . "<br>";
        echo "Giá trị phần tử nhỏ nhất là: " . $array[$minIndex] . "<br>";
    }
    ?>
</body>

</html>