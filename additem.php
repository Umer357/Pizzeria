<!-- Landing page after admin login -->
<!-- View, Add, Update, & Delete items -->
<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] != 'admin') {
    header('Location: index.html'); 
    exit();
}
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal_name = mysqli_real_escape_string($database, $_POST['M_name']); 
    if (isset($_POST['add'])) {
        $meal_type = mysqli_real_escape_string($database, $_POST['M_type']);
        $ingredients = mysqli_real_escape_string($database, $_POST['Ingredient']);
        $price = mysqli_real_escape_string($database, $_POST['Price']);
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["M_image"]["name"]);
        move_uploaded_file($_FILES["M_image"]["tmp_name"], $target_file);
        $sql = "INSERT INTO meals (M_name, M_type, Ingredient, Price, M_image) VALUES ('$meal_name', '$meal_type', '$ingredients', '$price', '$target_file')";
        mysqli_query($database, $sql);
    } elseif (isset($_POST['update'])) {
        $meal_type = mysqli_real_escape_string($database, $_POST['M_type']);
        $ingredients = mysqli_real_escape_string($database, $_POST['Ingredient']);
        $price = mysqli_real_escape_string($database, $_POST['Price']);
        $sql = "UPDATE meals SET M_type='$meal_type', Ingredient='$ingredients', Price='$price' WHERE M_name='$meal_name'";
        mysqli_query($database, $sql);
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM meals WHERE M_name='$meal_name'";
        mysqli_query($database, $sql);
    }
}
$result = mysqli_query($database, "SELECT * FROM meals");
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel - Add/Update/Delete Menu Items</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <div id="logo_container">
        <img src="pizza_logo.jpg" alt="Crust & Crumb Pizzeria Logo">
    </div>
    <nav>
        <ul id="navlist">
            <li><button onclick="location.href='index.html'">Logout</button></li>
        </ul>
    </nav>
</header>

<main class="admin-panel">
    <div class="admin_form">
        <form action="additem.php" method="post" enctype="multipart/form-data">
            <div class="form_group">
                <input type="file" id="meal_image" name="M_image" class="form_control">
            </div>
            <div class="form_group">
                <input type="text" id="meal_name" name="M_name" class="form_control" placeholder="Meal Name">
            </div>
            <div class="form_group">
                <input type="text" id="meal_type" name="M_type" class="form_control" placeholder="Meal Type">
            </div>
            <div class="form_group">
                <textarea id="ingredients" name="Ingredient" class="form_control" placeholder="Ingredients"></textarea>
            </div>
            <div class="form_group">
                <input type="text" id="price" name="Price" class="form_control" placeholder="Price">
            </div>
            <div class="form_group">
                <button type="submit" name="add" class="btn">Add Item</button>
                <button type="submit" name="update" class="btn">Update Item</button>
                <button type="submit" name="delete" class="btn">Delete Item</button>
            </div>
        </form>
    </div>
    <div class="admin_table">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Ingredients</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><img src="<?php echo $item['M_image']; ?>" alt="Menu Item" class="item_image" style="width: 80px; height: 80px;"></td>
                        <td><?php echo $item['M_name']; ?></td>
                        <td><?php echo $item['M_type']; ?></td>
                        <td><?php echo $item['Ingredient']; ?></td>
                        <td><?php echo $item['Price']; ?> SR</td>
                        <td>
                            <button onclick="editItem('<?php echo htmlspecialchars($item['M_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['M_type'], ENT_QUOTES); ?>', 
                            '<?php echo htmlspecialchars($item['Ingredient'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['Price'], ENT_QUOTES); ?>')" class="edit_btn">Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<script>
function editItem(name, type, ingredients, price) {
    document.getElementById('meal_name').value = name;
    document.getElementById('meal_type').value = type;
    document.getElementById('ingredients').value = ingredients;
    document.getElementById('price').value = price;
}
</script>

</body>
</html>
