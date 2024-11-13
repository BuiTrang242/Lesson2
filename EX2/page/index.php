<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đăng ký người dùng</title>
</head>

<body>
    <h2>Trang Đăng ký người dùng</h2>
    <form action="index.php" method="POST">
        <label for="name">Tên người dùng:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Điện thoại:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" value="Đăng ký">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];


        $errors = [];


        if (empty($name)) {
            $errors[] = "Tên người dùng không được để trống.";
        }


        if (empty($email)) {
            $errors[] = "Email không được để trống.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ.";
        }


        if (empty($phone)) {
            $errors[] = "Số điện thoại không được để trống.";
        }


        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        } else {

            $filename = "users.json";
            if (saveDataJSON($filename, $name, $email, $phone)) {
                echo "<p style='color: green;'>Đăng ký thành công!</p>";
            } else {
                echo "<p style='color: red;'>Có lỗi khi lưu thông tin người dùng.</p>";
            }
        }
    }


    function saveDataJSON($filename, $name, $email, $phone)
    {

        if (!file_exists($filename)) {
            file_put_contents($filename, json_encode([]));
        }


        $users = json_decode(file_get_contents($filename), true);


        $user = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];


        $users[] = $user;


        return file_put_contents($filename, json_encode($users, JSON_PRETTY_PRINT));
    }
    ?>
</body>

</html>