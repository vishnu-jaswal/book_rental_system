<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Welcome <?php echo $_GET['user']; ?></h1>

    <h2>Available Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Price per Rent</th>
            <th>Action</th>
        </tr>
        <?php
        include('db.php');

        $username = $_GET['user'];
        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            // Check if the user has rented this book
            $book_id = $row['id'];
            $rental_sql = "SELECT * FROM rentals WHERE user='$username' AND book_id='$book_id'";
            $rental_result = $conn->query($rental_sql);

            if ($rental_result->num_rows > 0) {
                // User has rented this book
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['price_per_rent']}</td>
                        <td><a href='return.php?book_id=$book_id&user=$username'>Return Book</a></td>
                      </tr>";
            } else {
                // User has not rented this book
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['price_per_rent']}</td>
                        <td><a href='rent.php?book_id=$book_id&user=$username'>Rent Book</a></td>
                      </tr>";
            }
        }
        ?>
    </table>

    <button onclick="location.href='index.php'">Logout</button>
</body>

</html>