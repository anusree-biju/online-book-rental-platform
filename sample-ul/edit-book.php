<?php
include('../db/connection.php'); // make sure your DB connection file is included

// ✅ 1. Check if a book ID is passed via GET
if (isset($_GET['bid'])) {
    $bid = $_GET['bid'];

    // ✅ 2. Fetch book details from the database
    $query = "SELECT * FROM book_tb WHERE bid = '$bid'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Book not found!";
        exit;
    }
} else {
    echo "Invalid request — missing book ID.";
    exit;
}

// ✅ 3. Handle update form submission
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $update_query = "UPDATE book_tb SET 
                        title = '$title',
                        author = '$author',
                        category = '$category',
                        price = '$price'
                     WHERE bid = '$bid'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Book updated successfully!'); 
              window.location.href='myrental.php';</script>";
        exit;
    } else {
        echo "Error updating book: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-form {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        .edit-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .edit-form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .edit-form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .edit-form button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<form class="edit-form" method="POST" action="">
    <h2>Edit Book</h2>
    <input type="hidden" name="bid" value="<?php echo $data['bid']; ?>">

    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $data['title']; ?>" required>

    <label for="author">Author:</label>
    <input type="text" name="author" value="<?php echo $data['author']; ?>" required>

    <label for="category">Category:</label>
    <input type="text" name="category" value="<?php echo $data['category']; ?>" required>

    <label for="price">Price:</label>
    <input type="number" name="price" value="<?php echo $data['price']; ?>" step="0.01" required>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
