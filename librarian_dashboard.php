<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Welcome Librarian</h1>

    <!-- Add Book Form -->
    <h2>Add a Book</h2>
    <form action="librarian_dashboard.php" method="POST">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <input type="text" name="genre" placeholder="Genre" required>
        <input type="number" name="price_per_rent" placeholder="Price per Rent" required>
        <button type="submit" name="add_book">Add Book</button>
    </form>

    <h2>Current Books</h2>
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
        // Include database connection
        include('db.php');

        // Handle book addition
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $genre = $_POST['genre'];
            $price_per_rent = $_POST['price_per_rent'];

            $sql = "INSERT INTO books (title, author, genre, price_per_rent) VALUES ('$title', '$author', '$genre', '$price_per_rent')";
            if ($conn->query($sql) === TRUE) {
                header("Location: librarian_dashboard.php"); // Redirect after adding book
                exit();
            } else {
                echo "<p>Error adding book: " . $conn->error . "</p>";
            }
        }

        // Handle book removal
        if (isset($_GET['remove_id'])) {
            $remove_id = $_GET['remove_id'];
            $sql = "DELETE FROM books WHERE id='$remove_id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: librarian_dashboard.php"); // Redirect after removing book
                exit();
            } else {
                echo "<p>Error removing book: " . $conn->error . "</p>";
            }
        }

        // Display current books
        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['genre']}</td>
                    <td>{$row['price_per_rent']}</td>
                    <td>
                        <a href='librarian_dashboard.php?remove_id={$row['id']}' onclick='return confirm(\"Are you sure you want to remove this book?\");'>Remove</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <button onclick="location.href='index.php'">Logout</button>
    <button onclick="location.href='rented_books.php'">View All Rented Books</button>
</body>

</html>