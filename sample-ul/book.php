<?php
session_start();
include '../db/connection.php';

// Handle status update
if(isset($_POST['update_status'])) {
    $bid = $_POST['bid'];
    $new_status = $_POST['status'];
    
    // Update book status
    $update_book = mysqli_query($con, "UPDATE book_tb SET status='$new_status' WHERE bid='$bid'");
    
    // If changing from rented to available, update rental_tb
    if($new_status == 'available') {
        $update_rental = mysqli_query($con, "UPDATE rental_tb SET status='returned' WHERE bid='$bid' AND status='rented'");
    }
    
    if($update_book) {
        $success = "Status updated successfully!";
    } else {
        $error = "Error updating status!";
    }
}

// Handle book details update
if(isset($_POST['update_book'])) {
    $bid = $_POST['bid'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $update = mysqli_query($con, "UPDATE book_tb SET 
        title='$title',
        author='$author',
        category='$category',
        description='$description',
        price='$price'
        WHERE bid='$bid'");
    
    if($update) {
        $success = "Book details updated successfully!";
    } else {
        $error = "Error updating book details!";
    }
}

// Fetch all books
$query = "SELECT * FROM book_tb WHERE uid='".$_SESSION['uid']."'";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Books</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f5f5f5;
      color: #333;
      padding: 20px;
    }

    header {
      background: #2c3e50;
      padding: 15px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }

    header h1 {
      font-size: 24px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #3498db;
      color: white;
      font-weight: 500;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .btn-edit {
      background: #3498db;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-delete {
      background: #e74c3c;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-update {
      background: #2ecc71;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    .status-available {
      color: #2ecc71;
      font-weight: 500;
    }

    .status-rented {
      color: #e74c3c;
      font-weight: 500;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #2c3e50;
      color: white;
      margin-top: 40px;
    }

     .button {
    background-color: #072441ff;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 16px;
    display: block;    /* makes it take full width line */
    width: fit-content;/* keeps button size just around text */
    margin: 0 auto 0 0;/* top right bottom left → pushes it left */
}
  </style>
</head>
<body>
  
<h2><a class="button" href="sampleui.php">GO BACK</a></h2>
  <header>
    <h1>📚 Manage Your Books</h1>
    <nav>
      <a href="home.php" class="text-white text-decoration-none">Home</a>
      <a href="profile.php" class="text-white text-decoration-none ms-3">Profile</a>
      <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a>
    </nav>
  </header>

  <div class="container">
    <?php if(isset($success)): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <h2>Your Books</h2>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo $row['bid']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td class="status-<?php echo $row['status']; ?>">
              <?php echo ucfirst($row['status']); ?>
            </td>
            <td>
              <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"
                data-bid="<?php echo $row['bid']; ?>"
                data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
                data-author="<?php echo htmlspecialchars($row['author'], ENT_QUOTES); ?>"
                data-category="<?php echo htmlspecialchars($row['category'], ENT_QUOTES); ?>"
                data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?>"
                data-price="<?php echo $row['price']; ?>"
                data-status="<?php echo $row['status']; ?>">
                Edit
              </button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Edit Book Modal (Bootstrap) -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Book Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="">
          <div class="modal-body">
            <input type="hidden" id="edit_bid" name="bid">
            
            <div class="mb-3">
              <label for="edit_title" class="form-label">Title</label>
              <input type="text" class="form-control" id="edit_title" name="title" required>
            </div>
            
            <div class="mb-3">
              <label for="edit_author" class="form-label">Author</label>
              <input type="text" class="form-control" id="edit_author" name="author" required>
            </div>
            
            <div class="mb-3">
              <label for="edit_category" class="form-label">Category</label>
              <input type="text" class="form-control" id="edit_category" name="category" required>
            </div>
            
            <div class="mb-3">
              <label for="edit_description" class="form-label">Description</label>
              <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
              <label for="edit_price" class="form-label">Price (₹)</label>
              <input type="number" class="form-control" id="edit_price" name="price" required>
            </div>
            
            <div class="mb-3">
              <label for="edit_status" class="form-label">Status</label>
              <select class="form-select" id="edit_status" name="status" required>
                <option value="available">Available</option>
                <option value="rented">Rented</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" name="update_book">Update Details</button>
            <button type="submit" class="btn btn-success" name="update_status">Update Status Only</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Set up modal data when edit button is clicked
    document.addEventListener('DOMContentLoaded', function() {
      var editModal = document.getElementById('editModal');
      editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var bid = button.getAttribute('data-bid');
        var title = button.getAttribute('data-title');
        var author = button.getAttribute('data-author');
        var category = button.getAttribute('data-category');
        var description = button.getAttribute('data-description');
        var price = button.getAttribute('data-price');
        var status = button.getAttribute('data-status');
        
        // Update the modal's content
        document.getElementById('edit_bid').value = bid;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_author').value = author;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_status').value = status;
      });
    });
  </script>
</body>
</html>