<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "6thsemproo2");

// --- 1. HANDLE DELETE ACTION ---
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    // Fetch the image path first to delete the actual file from the folder
    $img_query = $conn->query("SELECT image FROM products WHERE id = $id");
    $img_data = $img_query->fetch_assoc();
    
    if ($img_data) {
        $file_path = $img_data['image'];
        if (file_exists($file_path)) {
            unlink($file_path); // This removes the file from the 'uploads/' folder
        }
    }

    // Delete the record from the database
    $conn->query("DELETE FROM products WHERE id = $id");
    
    header("Location: admin.php"); // Refresh to show updated list
    exit();
}

// --- 2. HANDLE PRODUCT UPLOAD ---
if (isset($_POST['submit_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $image_name = time() . "_" . basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $name, $price, $target_file, $category);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php"); // Stay on admin page after upload
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgroMarket | Admin Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        :root { --brand-gold: #e2b048; --bg-dark: #0f172a; --card-bg: rgba(30, 41, 59, 0.7); --danger: #ef4444; }
        body { background: var(--bg-dark); color: white; font-family: 'Inter', sans-serif; margin: 0; }
        
        .admin-panel { background: rgba(30, 41, 59, 0.9); padding: 30px 8%; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .admin-form { display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        input, select { padding: 10px; border-radius: 8px; border: 1px solid #334155; background: #1e293b; color: white; }
        .btn-upload { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }

        .products { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; padding: 40px 8%; }
        .product-card { background: var(--card-bg); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); overflow: hidden; text-align: center; position: relative; }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .content { padding: 20px; }
        
        .btn-delete { 
            display: inline-block;
            margin-top: 10px;
            background: var(--danger); 
            color: white; 
            text-decoration: none; 
            padding: 8px 15px; 
            border-radius: 6px; 
            font-size: 0.85rem; 
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-delete:hover { background: #dc2626; }
    </style>
</head>
<body>

<section class="admin-panel">
    <h3 style="color: var(--brand-gold);">Admin: Add New Product</h3>
    <form class="admin-form" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <select name="category">
            <option value="fruit">Fruit</option>
            <option value="vegetable">Vegetable</option>
            <option value="grain">Grain</option>
        </select>
        <input type="file" name="product_image" required>
        <button type="submit" name="submit_product" class="btn-upload">Upload Product</button>
    </form>
</section>

<div class="products">
    <?php
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while($row = $result->fetch_assoc()) {
    ?>
    <div class="product-card">
        <img src="<?php echo $row['image']; ?>">
        <div class="content">
            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
            <p>Rs. <?php echo $row['price']; ?></p>
            
            <a href="admin.php?delete_id=<?php echo $row['id']; ?>" 
               class="btn-delete" 
               onclick="return confirm('Are you sure you want to delete this product?')">
               Delete Product
            </a>
        </div>
    </div>
    <?php } ?>
</div>

</body>
</html>