<?php 
require_once("components/navbar.php");
require_once("components/footer.php");
require_once("models/Database.php");
require_once("models/Product.php"); 

$dbContext = new Database(); // Anslut till databasen

$q = $_GET['q'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Product info page</title>
    <link rel="stylesheet" href="../styles/landingPage.css">
</head>
<body>
    <?php navBar(); ?>

    
    <section class="products">
        <div class="container">
        <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q;?>" class="btn btn-secondary">Title asc</a>
                        <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q;?>" class="btn btn-secondary">Title desc</a>
                        <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q;?>" class="btn btn-secondary">Price asc</a>
                        <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q;?>" class="btn btn-secondary">Price desc</a>
                        
            <div class="product-grid">

                <?php foreach($dbContext->searchProducts($q,$sortCol,$sortOrder) as $products){ 
                    ?>
                    <div class="product-card">
                        <?php if($products->price < 10): ?>
                            <div class="badge">Sale</div>
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars($products->imageUrl ?? 'public/images/default.jpg') ?>" alt="product-img">

                        
                        <div class="product-info">
                        
                            <h5 class="product-title"><?= htmlspecialchars($products->title) ?></h5>  
                            <p class="product-price"><?= number_format($products->price, 2) ?> kr</p>
                        </div>
                        <div class="product-action">
                            <a href="info?id=<?= $products->id ?>" class="btn">Visa produkt</a>
                            
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    
    <?php footer(); ?>
</body>
</html>