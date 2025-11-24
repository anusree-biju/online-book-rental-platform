<?php
include '../db/connection.php';

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $q = mysqli_query($con, "SELECT * FROM book_tb WHERE bid = '$edit_id'");
    $data = mysqli_fetch_assoc($q);
}

if (isset($_POST['update'])) {
    $bid = $_POST['bid'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    mysqli_query($con, "UPDATE book_tb SET title='$title', author='$author', category='$category', price='$price' WHERE bid='$bid'");
    echo "<script>alert('Book updated successfully'); window.location.href='index2.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <style>
        body {
            background-color: #f2f6fc;
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
        }

        .edit-form {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .edit-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .edit-form label {
            display: block;
            margin-bottom: 8px;
            margin-top: 20px;
            font-weight: 600;
        }

        .edit-form input[type="text"],
        .edit-form input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .edit-form button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #0056b3;
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
