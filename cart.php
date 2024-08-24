<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
function getCartItems($database) {
    $query = "
        SELECT sc.Meal_name, sc.Quantity, sc.Total_price, m.M_image
        FROM shoppingcart sc
        JOIN meals m ON sc.Meal_name = m.M_name";
    $result = mysqli_query($database, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_from_cart'])) {
    $meal_name = $_POST['meal_name'];
    $delete_query = "DELETE FROM shoppingcart WHERE Meal_name = ?";
    $stmt = mysqli_prepare($database, $delete_query);
    mysqli_stmt_bind_param($stmt, 's', $meal_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: cart.php"); 
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_quantity'])) {
    $meal_name = $_POST['meal_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;
    $update_query = "UPDATE shoppingcart SET Quantity = ?, Total_price = ? WHERE Meal_name = ?";
    $stmt = mysqli_prepare($database, $update_query);
    mysqli_stmt_bind_param($stmt, 'ids', $quantity, $total_price, $meal_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: cart.php"); 
}
$cartItems = getCartItems($database);
$total_bill = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function updateTotal(id, price) {
            var quantity = document.getElementById('quantity' + id).value;
            var newTotal = parseFloat(price) * parseInt(quantity);
            document.getElementById('total' + id).innerText = newTotal.toFixed(2) + ' SR';
        }
    </script>
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

<main class="cart-container">
    <h2>Your Cart</h2>
    <table>
        <tr>
            <th>Image</th>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($cartItems as $index => $item): ?>
        <tr>
            <td><img src="<?php echo $item['M_image']; ?>" alt="<?php echo $item['Meal_name']; ?>" class="cart-item-image"></td>
            <td><?php echo $item['Meal_name']; ?></td>
            <td><?php echo $item['Total_price'] / $item['Quantity']; ?> SR</td>
            <form action="cart.php" method="post">
                <td>
                    <input type="number" id="quantity<?php echo $index; ?>" name="quantity" value="<?php echo $item['Quantity']; ?>" min="1"
                           onchange="updateTotal(<?php echo $index; ?>, '<?php echo $item['Total_price'] / $item['Quantity']; ?>')">
                    <input type="hidden" name="price" value="<?php echo $item['Total_price'] / $item['Quantity']; ?>">
                    <input type="hidden" name="meal_name" value="<?php echo $item['Meal_name']; ?>">
                </td>
                <td id="total<?php echo $index; ?>"><?php echo $item['Total_price']; ?> SR</td>
                <td>
                    <button type="submit" name="edit_quantity">Update</button>
                    <button type="submit" name="delete_from_cart">Delete</button>
                </td>
            </form>
        </tr>
        <?php 
            $total_bill += $item['Total_price'];
        endforeach; ?>
        <tr>
            <td colspan="4" style="text-align: right;">Total Bill:</td>
            <td colspan="2"><?php echo $total_bill; ?> SR</td>
        </tr>
    </table>
    <div class="checkout">
        <form action="checkout.php" method="post">
            <button type="submit" name="checkout">Proceed to Checkout</button>
        </form>
    </div>
</main>

</body>
</html>
