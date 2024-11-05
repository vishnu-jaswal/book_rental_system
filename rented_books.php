<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Rented Books</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>All Rented Books</h1>
    <table>
        <tr>
            <th>Rental ID</th>
            <th>User</th>
            <th>Book ID</th>
            <th>Rent Date</th>
            <th>Final Price</th>
        </tr>
        <?php
        include('db.php');

        $sql = "SELECT rentals.*, books.title, books.author FROM rentals JOIN books ON rentals.book_id = books.id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['user']}</td>
                    <td>{$row['book_id']}</td>
                    <td>{$row['rent_date']}</td>
                    <td>{$row['final_price']}</td>
                  </tr>";
        }
        ?>
    </table>

    <button onclick="location.href='librarian_dashboard.php'">Back to Dashboard</button>
    <button onclick="location.href='index.php'">Logout</button>
</body>

</html>