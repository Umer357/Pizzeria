<!-- Page to update the customer's details-->
<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php'); 
    exit();
}
$username = $_SESSION['logged_in'];
$query = "SELECT * FROM customer WHERE Email = ?";
$stmt = mysqli_prepare($database, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $delivery_address = $_POST['delivery_address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_query = "UPDATE customer SET Name = ?, Phone = ?, Delivery_address = ?, Email = ?, Password = ? WHERE Email = ?";
    $stmt = mysqli_prepare($database, $update_query);
    mysqli_stmt_bind_param($stmt, 'ssssss', $name, $phone, $delivery_address, $email, $password, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['logged_in'] = $email;
    header("Location: profile.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile - Crust & Crumb Pizzeria</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
    <div id="logo_container">
        <img src="pizza_logo.jpg" alt="Crust & Crumb Pizzeria Logo">
    </div>
    <nav>
        <ul id="navlist">
            <li><a href="home.html">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="reviews.html">Reviews</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="aboutus.html">About Us</a></li>
            <li><button onclick="location.href='index.html'">Logout</button></li>
        </ul>
    </nav>
</header>
<main>
    <div id="profile_div" style="width: 30%; margin: 0 auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <form id="form" method="post" action="profile.php">
            <h2>Update Your Profile</h2>
            <div class="form_group">
                <label for="name">Name:</label>
                <input class="form_control" id="name" name="name" type="text" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
            </div>
            <div class="form_group">
                <label for="phone">Phone:</label>
                <input class="form_control" id="phone" name="phone" type="text" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
            </div>
            <div class="form_group">
                <label for="delivery_address">Delivery Address:</label>
                <input class="form_control" id="delivery_address" name="delivery_address" type="text" value="<?php echo htmlspecialchars($user['Delivery_address']); ?>" required>
            </div>
            <div class="form_group">
                <label for="email">Email:</label>
                <input class="form_control" id="email" name="email" type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            </div>
            <div class="form_group">
                <label for="password">Password:</label>
                <input class="form_control" id="password" name="password" type="password" value="<?php echo htmlspecialchars($user['Password']); ?>" required>
            </div>
            <div class="form_group">
                <button type="submit" name="update_profile" class="btn">Update Profile</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
