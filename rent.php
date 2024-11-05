<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $book_id = $_GET['book_id'];
    $username = $_GET['user'];

    // Check user's rental history
    $sql = "SELECT * FROM rentals WHERE user='$username' AND WEEK(rent_date) = WEEK(CURDATE())";
    $result = $conn->query($sql);
    $rental_count = $result->num_rows;

    // Calculate discount
    $discount = 0;
    if ($rental_count >= 2) {
        $discount = 0.3; // 30% discount
    }

    // Get book details
    $sql = "SELECT * FROM books WHERE id='$book_id'";
    $book_result = $conn->query($sql);
    $book = $book_result->fetch_assoc();
    $final_price = $book['price_per_rent'] - ($book['price_per_rent'] * $discount);

    // Insert rental into the database
    $sql = "INSERT INTO rentals (user, book_id, rent_date, final_price) VALUES ('$username', '$book_id', NOW(), '$final_price')";
    if ($conn->query($sql) === TRUE) {
        echo "Book rented successfully! Total cost: $" . number_format($final_price, 2);
    } else {
        echo "Error renting book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Rent Confirmation</h1>
    <p><a href="dashboard.php?user=<?php echo $_GET['user']; ?>">Back to Dashboard</a></p>
</body>

</html>