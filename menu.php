<!-- Menu page to view items and then add to cart -->
<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");

function getItemsByType($database, $type) {
    $stmt = mysqli_prepare($database, "SELECT * FROM meals WHERE M_type = ?");
    mysqli_stmt_bind_param($stmt, 's', $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $items;
}
$pizzas = getItemsByType($database, 'Pizza');
$desserts = getItemsByType($database, 'Dessert');
$drinks = getItemsByType($database, 'Drink');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $meal_name = $_POST['meal_name'];
    $quantity = 1; 

    $cart_check_query = mysqli_prepare($database, "SELECT Quantity, Total_price FROM shoppingcart WHERE Meal_Name = ?");
    mysqli_stmt_bind_param($cart_check_query, 's', $meal_name);
    mysqli_stmt_execute($cart_check_query);
    $cart_result = mysqli_stmt_get_result($cart_check_query);
    $cart_item = mysqli_fetch_assoc($cart_result);
    
    if ($cart_item) {
        $new_quantity = $cart_item['Quantity'] + $quantity;
        $new_total = $cart_item['Total_price'] + ($_POST['price'] * $quantity);
        $update_query = mysqli_prepare($database, "UPDATE shoppingcart SET Quantity = ?, Total_price = ? WHERE Meal_Name = ?");
        mysqli_stmt_bind_param($update_query, 'ids', $new_quantity, $new_total, $meal_name);
        mysqli_stmt_execute($update_query);
    } else {
        $insert_query = mysqli_prepare($database, "INSERT INTO shoppingcart (Quantity, Meal_Name, Total_price) VALUES (?, ?, ?)");
        $total_price = $_POST['price'] * $quantity;
        mysqli_stmt_bind_param($insert_query, 'isd', $quantity, $meal_name, $total_price);
        mysqli_stmt_execute($insert_query);
    }
    
}
mysqli_close($database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Menu</title>
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
<div class="menu-container">
    <div class="category" id="mealitem">
        <h2>Pizzas</h2>
        <?php foreach ($pizzas as $item) { ?>
            <div class="item-card">
                <img src="<?php echo $item['M_image']; ?>" alt="Pizza" class="item-image">
                <div class="item-info">
                    <h3><?php echo $item['M_name']; ?></h3>
                    <p><?php echo $item['Ingredient']; ?></p>
                    <p>Price: <?php echo $item['Price']; ?> SR</p>
                    <form method="post">
                        <input type="hidden" name="meal_name" value="<?php echo $item['M_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $item['Price']; ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="category" id="mealitem">
        <h2>Desserts</h2>
        <?php foreach ($desserts as $item) { ?>
            <div class="item-card">
                <img src="<?php echo $item['M_image']; ?>" alt="Pizza" class="item-image">
                <div class="item-info">
                    <h3><?php echo $item['M_name']; ?></h3>
                    <p><?php echo $item['Ingredient']; ?></p>
                    <p>Price: <?php echo $item['Price']; ?> SR</p>
                    <form method="post">
                        <input type="hidden" name="meal_name" value="<?php echo $item['M_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $item['Price']; ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="category" id="mealitem">
        <h2>Drinks</h2>
        <?php foreach ($drinks as $item) { ?>
            <div class="item-card">
                <img src="<?php echo $item['M_image']; ?>" alt="Dessert" class="item-image">
                <div class="item-info">
                    <h3><?php echo $item['M_name']; ?></h3>
                    <p><?php echo $item['Ingredient']; ?></p>
                    <p>Price: <?php echo $item['Price']; ?> SR</p>
                    <form method="post">
                        <input type="hidden" name="meal_name" value="<?php echo $item['M_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $item['Price']; ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
