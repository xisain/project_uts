<?php
include 'config.php';
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");

}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT * FROM account WHERE username='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['account_id'] = $row['account_id'];
            header("Location: ./");
        
        exit();
    } else {
        echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>
    <style>
        /* Add some custom styles if needed */
        body {
            background-color: #f3f3f3;
        }

        .animated-form {
            animation: fadeInDown 1s ease-out;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="h-screen flex justify-center items-center">

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full md:w-1/2 lg:w-1/3 animated-form">
        <p class="text-2xl font-bold mb-6 text-center">Login</p>
        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="username" type="text" placeholder="username" name="username" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" placeholder="Password" name="password" required>
            </div>
            <div class="mb-6">
                <button name="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Login
                </button>
            </div>
            <p class="text-sm text-gray-600 text-center">Belum punya akun? <a href="register.php" class="text-blue-500">Register</a></p>
        </form>
    </div>

    <script>
        // Animation using Anime.js
        anime({
            targets: '.animated-form',
            opacity: [0, 1],
            translateY: [-20, 0],
            easing: 'easeOutQuad',
            duration: 1000,
            delay: 500
        });
    </script>

</body>

</html>