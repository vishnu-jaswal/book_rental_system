<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $book_id = $_GET['book_id'];
    $username = $_GET['user'];

    // Remove rental record
    $sql = "DELETE FROM rentals WHERE user='$username' AND book_id='$book_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Book returned successfully!";
    } else {
        echo "Error returning book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Return Confirmation</h1>
    <p><a href="dashboard.php?user=<?php echo $_GET['user']; ?>">Back to Dashboard</a></p>
</body>

</html>