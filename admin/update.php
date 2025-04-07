<?php
// Include the database connection file
include('../koneksi.php');

// Get the product ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch the product details from the database
$sql = "SELECT * FROM produk WHERE id = $id";
$result = $conn->query($sql);

// If the product does not exist
if ($result->num_rows == 0) {
    echo "<p>Product not found!</p>";
    exit();
}

$product = $result->fetch_assoc(); // Assign fetched data to $product

// Check if the form is submitted for update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input values
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $gambar = $_POST['gambar'];  // Get the image URL

    // Update the product in the database
    $sql = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', deskripsi='$deskripsi', kategori='$kategori', stok='$stok', gambar='$gambar' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Product updated successfully!</p>";
        echo "<a href='table.php'>Back to Dashboard</a>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Close the database connection
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
        <h2 class="container-fluid text-center mb-4" style="color:  #d19c56;">Update Product</h2>
        <form method="POST">
            <div class="form-group mb-3">
                <label for="nama_produk">Product Name</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo isset($product['nama_produk']) ? htmlspecialchars($product['nama_produk']) : ''; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="harga">Price</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo isset($product['harga']) ? htmlspecialchars($product['harga']) : ''; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="deskripsi">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo isset($product['deskripsi']) ? htmlspecialchars($product['deskripsi']) : ''; ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="kategori">Category</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo isset($product['kategori']) ? htmlspecialchars($product['kategori']) : ''; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="stok">Stock</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo isset($product['stok']) ? htmlspecialchars($product['stok']) : ''; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="gambar">Product Image URL</label>
                <input type="text" class="form-control" id="gambar" name="gambar" value="<?php echo isset($product['gambar']) ? htmlspecialchars($product['gambar']) : ''; ?>" required>
                <!-- Display the current image if exists -->
                <?php if (isset($product['gambar']) && $product['gambar']) { ?>
                    <br>
                    <img src="<?php echo $product['gambar']; ?>" width="100" alt="Product Image">
                <?php } ?>
            </div>
            <button type="submit" class="btn p-2" style="color: white; background-color: #d19c56;">Update Product</button>
        </form>
    </div>
</body>
