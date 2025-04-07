<?php
// Mengimpor file koneksi.php
include ('koneksi.php');

// Query untuk mengambil data produk
$sql = "SELECT id, nama_produk, harga, deskripsi, gambar, kategori FROM produk";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Menyimpan data produk ke dalam array
    while($row = $result->fetch_assoc()) {
        // Pastikan id adalah integer
        $row['id'] = (int) $row['id']; // Mengkonversi id ke integer jika perlu
        $products[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

// Mengencode data produk menjadi format JSON
$productsJson = json_encode($products);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop E-Commerce</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .bg {
            background-image: url(https://i.pinimg.com/474x/f4/b4/68/f4b468c720a97521602be6095de1abec.jpg);
            background-position: center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            text-align: center;
        }

        .center-container {
            color: white;
            max-width: 600px;
        }

        h1 {
            font-weight: 500;
            font-size: 5em;
        }

        p {
            font-size: 1.2em;
        }

        .btn-custom {
            background-color: #d19c56;
        }

        .btn-outline-custom {
            background-color: none;
            border: 2px solid #d19c56;
            color: #d19c56;
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
        }

        @media screen and (max-width: 768px) {
            h1 {
                font-size: 4em;
            }

            .contact-info {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-bright bg-black" style="background: linear-gradient(to right, #d19c56, #f8e0a1); z-index: 100;">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-cup-hot"></i> Mycoffee</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#Home">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#OurProduct">Our Product</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#AboutUs">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- section 1 -->
    <div class="container-fluid bg" id="Home">
        <div class="container center-container">
            <h1>Welcome to Mycoffee</h1>
            <p>where every sip brings warmth and delight. Indulge in our carefully crafted coffees and delectable treats, perfect for making every moment feel special.</p>
            <button class="btn btn-custom"><a href="#OurProduct" style="color: rgb(200, 199, 199); text-decoration: none;">Order Now</a></button>
        </div>
    </div>

    <!-- section 2 -->
    <div class="container my-5" id="OurProduct" style="min-height: 500px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <h2 class="text-center mb-4"><b>Our Products</b></h2>

        <!-- Filter Buttons -->
        <div class="d-flex justify-content-center mb-4">
            <button class="btn btn-custom mx-2" onclick="filterProducts('all')">All</button>
            <button class="btn btn-outline-custom mx-2" onclick="filterProducts('Coffe')">Coffee</button>
            <button class="btn btn-outline-custom mx-2" onclick="filterProducts('Snack')">Snacks</button>
        </div>

        <!-- Product List -->
        <div class="col-dm-4 row" id="product-list"></div>
    </div>

    <!-- section 3 -->
    <div class="container-fluid align-items-center justify-content-center" id="AboutUs" style="color: white; margin-top: 40px;background: linear-gradient(to left, #2c2c2c, #2c3e50)">
        <div class="container p-4 ">
            <h2 class="mb-4" style="color: #d19c56;"><b>About Us</b></h2>
            <div class="contact-info" style="font-size: 1rem">
                <p><i class="bi bi-instagram"></i><a href="https://instagram.com" class="text-white"> @mycoffee</a></p>
                <p><i class="bi bi-envelope"></i> <a href=" mailto:contact@mycoffee.com" class="text-white">contact@mycoffee.com</a></p>
                <p><i class="bi bi-telephone"></i><a href=" tel:+62123456789" class="text-white">+62 123 456 789</a></p>
                <p><i class="bi bi-geo-alt"></i> Jl. Coffee No. 123, Jakarta, Indonesia</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Produk JSON yang dikirim dari PHP
        const products = <?php echo $productsJson; ?>;

        // Fungsi untuk menampilkan produk
        function displayProducts(productsToDisplay) {
            const productList = document.getElementById("product-list");
            productList.innerHTML = ''; // Clear existing products

            productsToDisplay.forEach(product => {
                const productCard = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card product-card">
                            <img src="${product.gambar}" class="card-img-top" alt="${product.nama_produk}">
                            <div class="card-body">
                                <h5 class="card-title">${product.nama_produk}</h5>
                                <p class="card-text">${product.deskripsi}</p>
                                <p class="card-text"><strong>Rp ${parseFloat(product.harga).toLocaleString()}</strong></p>

                                <!-- Quantity Selector and Add to Cart Button -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="number" id="quantity-${product.id}" class="form-control" value="1" min="1" style="width: 70px;">
                                    <button class="btn btn-custom" onclick="addToCart(${product.id})">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productList.innerHTML += productCard;
            });
        }

        // Fungsi untuk menambahkan produk ke dalam cart
        function addToCart(productId) {
            console.log(`Product ID: ${productId}`); // Debugging log untuk melihat ID produk yang dikirim
            const quantity = document.getElementById(`quantity-${productId}`).value;

            // Pastikan ID yang dikirim (productId) adalah integer dan melakukan pencocokan dengan ID produk
            const product = products.find(p => p.id === productId);

            console.log(product); // Debugging log untuk melihat produk yang ditemukan

            if (product) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                const productInCart = cart.find(item => item.id === productId);

                if (productInCart) {
                    productInCart.quantity += parseInt(quantity);
                } else {
                    cart.push({ ...product, quantity: parseInt(quantity) });
                }

                localStorage.setItem('cart', JSON.stringify(cart));

                alert(`Added ${quantity} of ${product.nama_produk} to your cart.`);
            } else {
                alert("Product not found!");
            }
        }




        // Fungsi untuk filter produk berdasarkan kategori
        function filterProducts(category) {
            if (category === 'all') {
                displayProducts(products); // Tampilkan semua produk
            } else {
                // Filter berdasarkan kategori yang sesuai dengan huruf kapital di database
                const filteredProducts = products.filter(product => product.kategori === category);
                displayProducts(filteredProducts); // Tampilkan produk yang difilter
            }
        }

        // Tampilkan semua produk saat pertama kali halaman dimuat
        displayProducts(products);
    </script>

</body>
</html>

