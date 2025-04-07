<?php
// Include the database connection file
include('../koneksi.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input values
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $gambar = $_POST['gambar'];  // The image URL input field
    
    // Insert the new product into the database
    $sql = "INSERT INTO produk (nama_produk, harga, deskripsi, kategori, stok, gambar) 
            VALUES ('$nama_produk', '$harga', '$deskripsi', '$kategori', '$stok', '$gambar')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Product added successfully!</p>";
        echo "<a href='table.php'>Back to Dashboard</a>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Update Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Update Product Form -->
    <div class="container mt-5">
        <h2 class="container-fluid text-center mb-4" style="color:  #d19c56;">Add New Product</h2>
        <form method="container POST">
        <div class="form-group mb-3">
            <label for="nama_produk">Product Name</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
        </div>
        <div class="form-group mb-3">
            <label for="harga">Price</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="form-group mb-3">
            <label for="deskripsi">Description</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="kategori">Category</label>
            <input type="text" class="form-control" id="kategori" name="kategori" required>
        </div>
        <div class="form-group mb-3">
            <label for="stok">Stock</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <div class="form-group mb-3">
            <label for="gambar">Product Image URL</label>
            <input type="text" class="form-control" id="gambar" name="gambar" required>
        </div>

        <button type="submit" class="btn p-2" style="color: white; background-color: #d19c56;">Add Product</button>
        </form>
    </div>
</body>


