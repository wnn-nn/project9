<?php
// Include the database connection file
include('koneksi.php');

// Query to fetch product data
$sql = "SELECT id, nama_produk, harga, deskripsi, gambar, kategori FROM produk";
$result = $conn->query($sql);

// Array to store product data
$products = array();

if ($result->num_rows > 0) {
    // Storing product data in array
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();

// Encode product data to JSON format
$productsJson = json_encode($products);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Additional styling for the table */
        .cart-table td, .cart-table th {
            vertical-align: middle;
        }

        .btn-custom {
            background-color: #d19c56;
        }

        .cart-actions button {
            margin-left: 10px;
        }

        .total-price {
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-bright bg-black" style="background: linear-gradient(to right, #d19c56, #f8e0a1);">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-cup-hot"></i> Mycoffee</a>
        </div>
    </nav>

    <!-- Shopping Cart Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Shopping Cart</h2>

        <!-- Cart Table -->
        <table class="table table-striped cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="cart-list">
                <!-- Cart items will be populated here dynamically -->
            </tbody>
        </table>

        <!-- Total Price -->
        <div class="text-end">
            <p class="total-price" id="cart-total">Total: Rp 0</p>
        </div>

        <div class="text-center">
            <button class="btn btn-custom" onclick="checkout()">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Function to get the cart from localStorage
        function getCart() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }

        // Function to update the cart display on the shopping cart page
        function updateCart() {
            const cart = getCart();
            const cartList = document.getElementById('cart-list');
            const cartTotal = document.getElementById('cart-total');
            cartList.innerHTML = ''; // Clear existing items

            let totalPrice = 0;

            // Loop through each product in the cart and display it
            cart.forEach(product => {
                const row = `
                    <tr>
                        <td>${product.nama_produk}</td>
                        <td>Rp ${parseFloat(product.harga).toLocaleString()}</td>
                        <td>
                            <input type="number" value="${product.quantity}" min="1" id="quantity-${product.id}" 
                                onchange="updateQuantity(${product.id})" class="form-control" style="width: 80px;">
                        </td>
                        <td>Rp ${parseFloat(product.harga * product.quantity).toLocaleString()}</td>
                        <td class="cart-actions">
                            <button class="btn btn-danger" onclick="removeFromCart(${product.id})">Remove</button>
                        </td>
                    </tr>
                `;
                cartList.innerHTML += row;
                totalPrice += product.harga * product.quantity;
            });

            // Update the total price
            cartTotal.textContent = `Total: Rp ${totalPrice.toLocaleString()}`;
        }

        // Function to update the quantity of a product in the cart
        function updateQuantity(productId) {
            const quantity = document.getElementById(`quantity-${productId}`).value;
            let cart = getCart();

            // Update the quantity of the product in the cart
            cart = cart.map(product => {
                if (product.id === productId) {
                    product.quantity = parseInt(quantity);
                }
                return product;
            });

            // Save the updated cart back to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart(); // Update the display
        }

        // Function to remove a product from the cart
        function removeFromCart(productId) {
            let cart = getCart();

            // Remove the product from the cart
            cart = cart.filter(product => product.id !== productId);

            // Save the updated cart back to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart(); // Update the display
        }

        // Function to proceed to checkout
        function checkout() {
            const cart = getCart();

            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cart is empty',
                    text: 'You cannot proceed to checkout with an empty cart!',
                });
                return;
            }

            // Proceed with checkout process (e.g., redirect to payment page)
            alert('Proceeding to checkout...');
        }

        // Initialize the cart display when the page loads
        updateCart();
    </script>
</body>
</html>
