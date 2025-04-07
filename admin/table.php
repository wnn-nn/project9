<?php
// Include the database connection file
include('../koneksi.php');

// Fetch all products
$sql = "SELECT id, nama_produk, harga, deskripsi, gambar, kategori, stok FROM produk";
$result = $conn->query($sql);

echo "<div class='container my-5'>";
echo "<h2 class='text-center mb-4'>Admin Dashboard</h2>";

// Button to add new product
echo "<div class='text-center mb-4'>";
echo "<a href='input.php' class='btn btn-success btn-lg'>Add New Product</a>"; // Link to a page where users can add new products
echo "</div>";

// Check if there are any products
if ($result->num_rows > 0) {
    // Create the table to display the products with Bootstrap styling
    echo "<div class='d-flex justify-content-center'>";  // Add this div to center the table
    echo "<table class='table' style='width: 100%;'>";
    echo "<thead class='table-dark' style='background-color: #d19c56; color: white;'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
          </thead>";

    echo "<tbody>";
    // Loop through and display each product in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama_produk'] . "</td>";
        echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['deskripsi'] . "</td>";
        echo "<td>" . $row['kategori'] . "</td>";
        echo "<td><img src='" . $row['gambar'] . "' alt='" . $row['nama_produk'] . "' width='100'></td>";
        echo "<td>" . $row['stok'] . "</td>";
        echo "<td>
                <a href='update.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Update</a>
                <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
              </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";  // Close the center div
} else {
    echo "<p>No products found</p>";
}

// Close the database connection
$conn->close();
?>
