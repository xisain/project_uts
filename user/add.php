<?php
require('../config.php');

if (isset($_POST["submit"])) {
    // Validate username and email
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Check if the username already exists
    $check_username_sql = "SELECT COUNT(*) FROM account WHERE username = ?";
    $check_username_stmt = mysqli_prepare($conn, $check_username_sql);
    mysqli_stmt_bind_param($check_username_stmt, "s", $username);
    mysqli_stmt_execute($check_username_stmt);
    mysqli_stmt_bind_result($check_username_stmt, $username_count);
    mysqli_stmt_fetch($check_username_stmt);
    mysqli_stmt_close($check_username_stmt);

    // Check if the email already exists
    $check_email_sql = "SELECT COUNT(*) FROM account WHERE email = ?";
    $check_email_stmt = mysqli_prepare($conn, $check_email_sql);
    mysqli_stmt_bind_param($check_email_stmt, "s", $email);
    mysqli_stmt_execute($check_email_stmt);
    mysqli_stmt_bind_result($check_email_stmt, $email_count);
    mysqli_stmt_fetch($check_email_stmt);
    mysqli_stmt_close($check_email_stmt);

    if ($username_count > 0) {
        echo "<script>Error: Username already exists.</script>";
    } elseif ($email_count > 0) {
        echo "<script>Error: Email already exists.<script>";
    } else {
        // If username and email are unique, proceed with user registration
        $encpass = hash('sha256', $_POST['password']);
        $sql_insert_user = "INSERT INTO account (username, email, password, createdAt) VALUES (?, ?, ?, NOW())";

        $stmt = mysqli_prepare($conn, $sql_insert_user);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $encpass);

        if (mysqli_stmt_execute($stmt)) {
            echo "User added successfully!";
            header('location: view.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <title>Add User</title>
</head>
<body class="bg-gray-100"> 

    <div class="container mx-auto my-8 p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-8">Add User</h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-600 font-bold">Username</label>
                <input type="text" name="username" id="username" class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-bold">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-bold">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded-md">
            </div>

            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700">Submit</button>
        </form>
    </div>

</body>
</html>
