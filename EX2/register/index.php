<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký người dùng(ex)</title>
    <style>
        input[type=submit] {
            cursor: pointer;
        }

        ,
    </style>
</head>

<body>
    <h2>Đăng ký người dùng</h2>
    <form action="index.php" method="POST">
        <label for="name">Username:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Đăng ký">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        echo "Username: $name<br>";
        echo "Email: $email<br>";
        echo "Password: $password<br>";
        $errors = [];
        if (empty($name)) {
            $errors[] = "Username cannot be empty.";
        }
        if (empty($email)) {
            $errors[] = "Email cannot be empty.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors[] = "Password cannot be empty.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>" . $error . "</p>";
            }
        } else {
            $filename = "users.json";
            saveDataJSON($filename, $name, $email, $password);
            echo "<p style='color: green;'>Registration successful!</p>";
        }
    }
    function saveDataJSON($filename, $name, $email, $password)
    {
        if (!file_exists($filename)) {
            file_put_contents($filename, json_encode([]));
        }
        $users = json_decode(file_get_contents($filename), true);
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];
        $users[] = $user;
        return file_put_contents($filename, json_encode($users, JSON_PRETTY_PRINT));
    }

    ?>

</body>

</html>