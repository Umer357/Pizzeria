<!--Registeration page-->
<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($database, $_POST['name']);
    $phone = mysqli_real_escape_string($database, $_POST['phone']);
    $address = mysqli_real_escape_string($database, $_POST['address']);
    $email = mysqli_real_escape_string($database, $_POST['email']);
    $password = mysqli_real_escape_string($database, $_POST['password']);
    $email_check_query = "SELECT Email FROM customer WHERE Email = ?";
    $stmt = mysqli_prepare($database, $email_check_query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>alert('Unsuccessful: Email already registered.'); window.location.href='register.php';</script>";
    } else {
        $insert_query = "INSERT INTO customer (Name, Phone, Delivery_address, Email, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($database, $insert_query);
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $phone, $address, $email, $password);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registration successful!'); window.location.href='index.html';</script>";
        } else {
            echo "Error: " . mysqli_error($database);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($database);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register - Crust & Crumb Pizzeria</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
    <div id="logo_container" style="display: flex; align-items: center; padding-left: 20px;">
        <img src="pizza_logo.jpg" alt="Crust & Crumb Pizzeria Logo">
        <h2 style="margin: 0; margin-left: 10px; color: white;">Crust & Crumb Pizzeria</h2>
    </div>
</header>
<main>
    <div id="login_div" style="margin-top: 50px; text-align: center;">
        <form id="register_form" method="post" action="register.php">
            <h2>Register an Account</h2>
            <div class="form_group" style="margin-bottom: 15px;">
                <input class="form_control" id="name" name="name" type="text" placeholder="Full Name" required>
            </div>
            <div class="form_group" style="margin-bottom: 15px;">
                <input class="form_control" id="phone" name="phone" type="tel" placeholder="Phone Number" required>
            </div>
            <div class="form_group" style="margin-bottom: 15px;">
                <textarea class="form_control" id="address" name="address" placeholder="Delivery Address" required></textarea>
            </div>
            <div class="form_group" style="margin-bottom: 15px;">
                <input class="form_control" id="email" name="email" type="email" placeholder="Email" required>
            </div>
            <div class="form_group" style="margin-bottom: 15px;">
                <input class="form_control" id="password" name="password" type="password" placeholder="Password" required>
            </div>
            <div class="form_group" style="margin-bottom: 15px;">
                <button type="submit" class="btn">Register</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
