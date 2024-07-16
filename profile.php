<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: signup.php");
    exit;
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['email'];
$number = $_SESSION['number'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($firstname); ?>!!</h1>
    <p>First Name: <?php echo htmlspecialchars($firstname); ?></p>
    <p>Last Name: <?php echo htmlspecialchars($lastname); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Phone Number: <?php echo htmlspecialchars($number); ?></p>
</body>
</html>
