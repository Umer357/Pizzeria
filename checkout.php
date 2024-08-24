<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
$orderPlaced = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $query = "SELECT SUM(Total_price) AS Total FROM shoppingcart";
    $result = mysqli_query($database, $query);
    $row = mysqli_fetch_assoc($result);
    $total_price = $row['Total'];

    $insert_order = "INSERT INTO mealorder (Order_date_time, T_price, Status) VALUES (NOW(), ?, 'Pending')";
    $stmt = mysqli_prepare($database, $insert_order);
    mysqli_stmt_bind_param($stmt, 'd', $total_price);
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($database);
    if ($order_id) {
        $clear_cart = "DELETE FROM shoppingcart";
        mysqli_query($database, $clear_cart);
    }

    mysqli_stmt_close($stmt);
    $orderPlaced = true;
    $success_message = "Order placed successfully. Your order number is " . $order_id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php if ($orderPlaced): ?>
    <script type="text/javascript">
        alert('<?php echo $success_message; ?>');
        window.location.href = 'home.html'; 
    </script>
    <?php endif; ?>
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
<main class="checkout-form">
    <h2>Checkout</h2>
    <form action="checkout.php" method="post">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <fieldset>
            <legend>Payment Details</legend>
            <input type="text" id="cardholder" name="cardholder" placeholder="Card Holder Name" required>
            <input type="text" id="cardnumber" name="cardnumber" pattern="\d{16}" placeholder="Valid Card Number" required>
            <input type="text" id="expmonth" name="expmonth" placeholder="Card Expiry Month" required>
            <input type="text" id="expyear" name="expyear" placeholder="Card Expiry Year" required>
            <input type="text" id="cvv" name="cvv" pattern="\d{3}" placeholder="Security Code" required>
        </fieldset>

        <button type="submit" name="place_order" class="btn">Place Order</button>
    </form>
</main>

</body>
</html>
