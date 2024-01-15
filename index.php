<?php

// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "login_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบการลงชื่อเข้า
if (isset($_POST['login'])) {
    $username = $_POST['username'];

    // บันทึกข้อมูลลงชื่อเข้า
    $query = "INSERT INTO user_logs (username, login_time) VALUES ('$username', NOW())";
    mysqli_query($conn, $query);
}

// ตรวจสอบการลงชื่อออก
if (isset($_POST['logout'])) {
    $username = $_POST['username'];

    // อัปเดตข้อมูลลงชื่อออก
    $query = "UPDATE user_logs SET logout_time = NOW() WHERE username = '$username' AND logout_time IS NULL";
    mysqli_query($conn, $query);
}

// ดึงข้อมูลจากฐานข้อมูล
$query = "SELECT * FROM user_logs";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class='flex justify-center'>
        <div class='p-10'>
            <h2 class='text-center text-indigo-500 text-4xl drop-shadow-md'>Login <span class='text-orange-500'>System</span></h2>
            <div class='bg-orange-500 rounded-full w-6 h-1'></div>
        </div>
    </div>
    <form method="post">
        <div>
            <div class='flex justify-center pb-5'>
                <label for="username" class='text-orange-500'>Username</label>
            </div>
            <div class='flex justify-center'>
                <input type="text" name="username" required class='border border-orange-500 rounded-md pl-2'>
            </div>
        </div>
        <div class='flex justify-center gap-10 py-10'>
            <button type="submit" name="login" class='bg-indigo-200 text-indigo-700 shadow-md rounded-md px-10 py-1'>Login</button>
            <button type="submit" name="logout" class='bg-orange-200 text-orange-700 shadow-md rounded-md px-10 py-1'>Logout</button>
        </div>
    </form>

    <div class='flex justify-center'>
        <div>
            <h3 class='text-orange-600 pb-5'>Activity Log</h3>

            <table class='border shadow-md'>
                <tr class='border'>
                    <th class='text-zinc-700 p-2'>ID</th>
                    <th class='text-zinc-700 p-2'>Username</th>
                    <th class='text-zinc-700 p-2'>Login Time</th>
                    <th class='text-zinc-700 p-2'>Logout Time</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='border'>";
                    echo "<td class='border p-3 text-orange-600'>{$row['id']}</td>";
                    echo "<td class='border p-3 text-indigo-600'>{$row['username']}</td>";
                    echo "<td class='border p-3 text-green-600'>{$row['login_time']}</td>";
                    echo "<td class='border p-3 text-rose-600'>{$row['logout_time']}</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>