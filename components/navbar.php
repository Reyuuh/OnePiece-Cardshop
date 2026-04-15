<?php
require_once("models/Database.php");
require_once("models/Cart.php");

function navBar() {
    $db = new Database();

    $userId = null;
    $session_id = session_id();

    if ($db->getUsersDatabase()->getAuth()->isLoggedIn()) {
        $userId = $db->getUsersDatabase()->getAuth()->getUserId();
    }

    $cart = new Cart($db, $session_id, $userId);
    $categories = $db->getAllCategories();
    $isLoggedIn = $db->getUsersDatabase()->getAuth()->isLoggedIn();
?>
    <link rel="stylesheet" href="/styles/navBar.css">

    <nav class="navbar">

        <div class="nav-logo">
            <a href="/"><img src="/public/images/nav-logo.png" alt="Logo"></a>
        </div>

        <ul class="nav-links">
            <li class="nav-link"><a href="/">HOME</a></li>

            <li class="nav-link nav-dropdown">
                <a href="#">CATEGORIES</a>
                <ul class="drop-down">
                    <?php foreach ($categories as $category): ?>
                        <li><a href="/products?name=<?= urlencode($category) ?>"><?= htmlspecialchars($category) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>

            <?php if ($isLoggedIn): ?>
                <li class="nav-link"><a href="/user/logout">LOGOUT</a></li>
            <?php else: ?>
                <li class="nav-link"><a href="/user/login">LOGIN</a></li>
                <li class="nav-link"><a href="/user/register">CREATE ACCOUNT</a></li>
            <?php endif; ?>
        </ul>

        <div class="nav-right">
            <?php if ($isLoggedIn): ?>
                <span class="nav-username"><?= htmlspecialchars($db->getUsersDatabase()->getAuth()->getUsername()) ?></span>
            <?php endif; ?>

            <form action="/search" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search" class="form-control">
                <button type="submit" class="search-button">Search</button>
            </form>

            <a href="/checkout" class="cart-link">
                Cart (<?= $cart->getItemsCount() ?>)
            </a>
        </div>

    </nav>
<?php
}
?>
