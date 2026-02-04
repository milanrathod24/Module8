<!DOCTYPE html>
<html>
<head>
    <title>Product Catalog</title>
    <script>
        function fetchProducts() {
            let keyword = document.getElementById("keyword").value;
            let category = document.getElementById("category").value;
            let minPrice = document.getElementById("minPrice").value;
            let maxPrice = document.getElementById("maxPrice").value;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_products.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                document.getElementById("result").innerHTML = this.responseText;
            };

            xhr.send(
                "keyword=" + keyword +
                "&category=" + category +
                "&minPrice=" + minPrice +
                "&maxPrice=" + maxPrice
            );
        }
    </script>
</head>
<body>

<h2>Product Catalog</h2>

<input type="text" id="keyword" placeholder="Search product" onkeyup="fetchProducts()">

<select id="category" onchange="fetchProducts()">
    <option value="">All Categories</option>
    <option value="Electronics">Electronics</option>
    <option value="Clothing">Clothing</option>
</select>

<input type="number" id="minPrice" placeholder="Min Price" onkeyup="fetchProducts()">
<input type="number" id="maxPrice" placeholder="Max Price" onkeyup="fetchProducts()">

<hr>

<div id="result"></div>

</body>
</html>
