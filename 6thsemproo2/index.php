<?php
// 1. Precise connection to your database
$conn = new mysqli("localhost", "root", "", "6thsemproo2");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AgroMarket | Professional Organic Marketplace</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    /* ... (All your existing CSS remains exactly the same) ... */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    :root { --brand-gold: #e2b048; --brand-purple: #7c4dff; --bg-dark: #0f172a; --card-bg: rgba(30, 41, 59, 0.7); --border-color: rgba(255, 255, 255, 0.1); }
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body { background-color: var(--bg-dark); color: #f8fafc; min-height: 100vh; }
    header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 8%; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 1000; }
    .logo { font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
    nav a { margin-left: 2rem; text-decoration: none; color: #94a3b8; font-weight: 500; }
    .hero { text-align: center; padding: 60px 20px; max-width: 800px; margin: 0 auto; }
    .hero h1 { font-size: 3.5rem; font-weight: 800; background: linear-gradient(to bottom right, #fff 30%, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .rec-header { padding: 0 8% 20px 8%; color: var(--brand-gold); font-weight: 600; display: none; }
    .products { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; padding: 0 8% 80px 8%; }
    .product-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .product-card:hover { border-color: rgba(226, 176, 72, 0.4); transform: translateY(-8px); }
    .image-container { position: relative; height: 240px; }
    .product-card img { width: 100%; height: 100%; object-fit: cover; }
    .status-badge { position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.8); color: var(--brand-gold); padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; border: 1px solid var(--brand-gold); }
    .content { padding: 24px; }
    .btn-buy { width: 100%; background: var(--brand-gold); color: #1e1b4b; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; }
  </style>
</head>

<body>

<header>
  <div class="logo"><span>💜</span> AgroMarket</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  </nav>
</header>

<div class="hero">
  <h1>The Purest Choice.</h1>
  <p>Your personalized selection of farmer-direct organic goods.</p>
</div>

<div id="recommendation-msg" class="rec-header">✨ Recommended based on your interests</div>

<div class="products" id="product-list">
  <?php
  // FETCH ALL ITEMS FROM 6thsemproo2
  $result = $conn->query("SELECT * FROM products ORDER BY id DESC");

  if ($result && $result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          ?>
          <div class="product-card" data-category="<?php echo htmlspecialchars($row['category']); ?>">
            <div class="image-container">
              <span class="status-badge">Fresh Harvest</span>
              <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product">
            </div>
            <div class="content">
              <h4><?php echo htmlspecialchars($row['name']); ?></h4>
              <span class="price-tag" style="color: #cbd5e1; margin-bottom: 24px; display: block;">Rs. <?php echo htmlspecialchars($row['price']); ?></span>
              <button class="btn-buy" onclick="buyProduct('<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>, '<?php echo $row['category']; ?>')">Buy Now</button>
            </div>
          </div>
          <?php
      }
  } else {
      echo "<p style='grid-column: 1/-1; text-align: center;'>No products found. Use admin.php to upload!</p>";
  }
  ?>
</div>

<script>
  // --- YOUR ORIGINAL RECOMMENDATION ALGORITHM ---
  window.onload = function() {
    applyRecommendations();
  };

  function applyRecommendations() {
    const favoriteCategory = localStorage.getItem("favCategory");
    if (!favoriteCategory) return;

    const productList = document.getElementById("product-list");
    const products = Array.from(productList.getElementsByClassName("product-card"));
    
    document.getElementById("recommendation-msg").style.display = "block";

    // Sort: Items matching your favCategory move to the top
    products.sort((a, b) => {
      let catA = a.getAttribute("data-category");
      let catB = b.getAttribute("data-category");
      
      if (catA === favoriteCategory && catB !== favoriteCategory) return -1;
      if (catA !== favoriteCategory && catB === favoriteCategory) return 1;
      return 0;
    });

    productList.innerHTML = "";
    products.forEach(p => productList.appendChild(p));
  }

  function buyProduct(name, price, category) {
    localStorage.setItem("productName", name);
    localStorage.setItem("price", price);
    
    // This "trains" the algorithm for the next visit
    localStorage.setItem("favCategory", category);

    const user = localStorage.getItem("loggedUser");
    if (user) {
      window.location.href = "consumer.html";
    } else {
      window.location.href = "login.php";
    }
  }
</script>

</body>
</html>