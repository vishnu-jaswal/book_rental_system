<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Welcome Admin</h1>

    <!-- Add User Form -->
    <h2>Add a User</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="librarian">Librarian</option>
        </select>
        <button type="submit" name="add_user">Add User</button>
    </form>

    <h2>Current Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php
        include('db.php');

        // Handle user addition
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p>Error adding user: " . $conn->error . "</p>";
            }
        }

        // Handle user removal
        if (isset($_GET['remove_user_id'])) {
            $remove_user_id = $_GET['remove_user_id'];
            $sql = "DELETE FROM users WHERE id='$remove_user_id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p>Error removing user: " . $conn->error . "</p>";
            }
        }

        // Display current users
        $sql = "SELECT * FROM users WHERE role IN ('admin', 'librarian')";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    <td>
                        <a href='admin_dashboard.php?remove_user_id={$row['id']}' onclick='return confirm(\"Are you sure you want to remove this user?\");'>Remove</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Add Book Form -->
    <h2>Add a Book</h2>
    <form action="admin_dashboard.php" method="POST">
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
        // Handle book addition
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $genre = $_POST['genre'];
            $price_per_rent = $_POST['price_per_rent'];

            $sql = "INSERT INTO books (title, author, genre, price_per_rent) VALUES ('$title', '$author', '$genre', '$price_per_rent')";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p>Error adding book: " . $conn->error . "</p>";
            }
        }

        // Handle book removal
        if (isset($_GET['remove_book_id'])) {
            $remove_book_id = $_GET['remove_book_id'];
            $sql = "DELETE FROM books WHERE id='$remove_book_id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin_dashboard.php");
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
                        <a href='admin_dashboard.php?remove_book_id={$row['id']}' onclick='return confirm(\"Are you sure you want to remove this book?\");'>Remove</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <button onclick="location.href='index.php'">Logout</button>
    <button onclick="location.href='rented_books.php'">View All Rented Books</button>
</body>

</html>