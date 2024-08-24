<!--Page to track or cancel the orders placed -->
<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
function getPendingOrders($database) {
    $query = "SELECT * FROM mealorder WHERE Status = 'Pending'";
    $result = mysqli_query($database, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    $delete_query = "DELETE FROM mealorder WHERE Order_ID = ?";
    $stmt = mysqli_prepare($database, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $order_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: order.php"); 
}
$pendingOrders = getPendingOrders($database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Orders</title>
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
<main class="order-container">
    <h2>Pending Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Date/Time</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($pendingOrders as $order): ?>
        <tr>
            <td><?php echo $order['Order_ID']; ?></td>
            <td><?php echo $order['Order_date_time']; ?></td>
            <td><?php echo $order['T_price']; ?></td>
            <td><?php echo $order['Status']; ?></td>
            <td>
                <form method="post" action="order.php">
                    <input type="hidden" name="order_id" value="<?php echo $order['Order_ID']; ?>">
                    <button type="submit" name="cancel_order" class="btn-cancel">Cancel Order</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</main>

</body>
</html>
