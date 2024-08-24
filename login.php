<!-- Action upon submission of login form -->
<?php
$database = mysqli_connect("localhost", "root", "", "pizzeria") or die("Could not connect to database");
$username = mysqli_real_escape_string($database, $_POST['username']);
$password = mysqli_real_escape_string($database, $_POST['password']);
$adminQuery = "SELECT * FROM admin WHERE A_email = '$username' AND A_password = '$password'";
$adminResult = mysqli_query($database, $adminQuery);

if (mysqli_num_rows($adminResult) == 1) {
    session_start();
    $_SESSION['logged_in'] = $username;
    $_SESSION['user_role'] = 'admin';
    header('Location: additem.php');
    exit();
} else {
    $userQuery = "SELECT * FROM customer WHERE Email = '$username' AND Password = '$password'";
    $userResult = mysqli_query($database, $userQuery);

    if (mysqli_num_rows($userResult) == 1) {
        session_start();
        $_SESSION['logged_in'] = $username;
        $_SESSION['user_role'] = 'customer';
        header('Location: home.html');
        exit();
    } else {
        echo "Username or password is incorrect.";

    }
}
mysqli_close($database);
?>
