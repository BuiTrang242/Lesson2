<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
        input[type=text],
        input[type=number] {
            width: 300px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 4px;
            padding: 12px 10px 12px 10px;
            margin-bottom: 10px;
        }

        input[type=submit] {

            height: 55px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        #submit {
            border-radius: 2px;
            padding: 10px 32px;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Quản lý danh sách sản phẩm</h1>

    <form action="index.php" method="POST">
        <label for="name">Tên sản phẩm:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Giá:</label><br>
        <input type="text" id="price" name="price" required><br><br>

        <label for="quantity">Số lượng:</label><br>
        <input type="text" id="quantity" name="quantity" required><br><br>

        <input type="submit" name="action" value="Thêm sản phẩm">
        <input type="submit" name="action" value="Hiển thị sản phẩm">
        <input type="submit" name="action" value="Sắp xếp theo tên">
    </form>


    <h2>Tìm kiếm sản phẩm</h2>
    <form action="index.php" method="GET">
        <label for="keyword">Từ khóa:</label>
        <input type="text" id="keyword" name="keyword">
        <input type="submit" value="Tìm kiếm">
    </form>

    <?php

    session_start();
    if (!isset($_SESSION['products'])) {
        $_SESSION['products'] = [];
    }


    function addProduct($name, $price, $quantity)
    {
        if (empty($name) || !is_numeric($price) || !is_numeric($quantity)) {
            echo "<p style='color: red;'>Thông tin sản phẩm không hợp lệ.</p>";
            return;
        }
        $product = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
        $_SESSION['products'][] = $product;
        echo "<p style='color: green;'>Thêm sản phẩm thành công!</p>";
    }


    function displayProducts($products)
    {
        if (empty($products)) {
            echo "<p>Không có sản phẩm nào.</p>";
            return;
        }
        echo "<h3>Danh sách sản phẩm:</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th></tr>";
        foreach ($products as $product) {
            printf(
                "<tr><td>%s</td><td>%s</td><td>%s</td></tr>",
                htmlspecialchars($product['name']),
                number_format($product['price'], 2),
                $product['quantity']
            );
        }
        echo "</table>";
    }


    function searchProduct($products, $keyword)
    {
        $results = [];
        foreach ($products as $product) {
            if (strpos(strtolower($product['name']), strtolower($keyword)) !== false) {
                $results[] = $product;
            }
        }
        return $results;
    }


    function sortProductsByName(&$products)
    {
        usort($products, function ($a, $b) {
            return strcmp(strtolower($a['name']), strtolower($b['name']));
        });
        echo "<p>Danh sách đã được sắp xếp theo tên.</p>";
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        if ($action == "Thêm sản phẩm") {
            addProduct($_POST['name'], $_POST['price'], $_POST['quantity']);
        } elseif ($action == "Hiển thị sản phẩm") {
            displayProducts($_SESSION['products']);
        } elseif ($action == "Sắp xếp theo tên") {
            sortProductsByName($_SESSION['products']);
            displayProducts($_SESSION['products']);
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $foundProducts = searchProduct($_SESSION['products'], $keyword);
        if (!empty($keyword)) {
            displayProducts($foundProducts);
        }
    }
    ?>
</body>

</html>