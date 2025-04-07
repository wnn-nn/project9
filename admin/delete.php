<?php
// Include the database connection file
include('../koneksi.php');

// Get the product ID
$id = $_GET['id'];

// Delete the product from the database
$sql = "DELETE FROM produk WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<p>Product deleted successfully!</p>";
    echo "<a href='admin_dashboard.php'>Back to Dashboard</a>";
} else {
    echo "<p>Error: " . $conn->error . "</p>";
}

$conn->close();
?>
