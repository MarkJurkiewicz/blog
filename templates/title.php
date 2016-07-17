<div class="top-menu">
    <div class="menu-options">
        <?php if (isLoggedIn()): ?>
            How ya doing tonight <?php echo htmlEscape(getAuthUser()) ?>?!?
            <a href="logout.php">Log out</a>
        <?php else: ?>
            <a href="login.php">Log in</a>
        <?php endif ?>
    </div>

    <a href="index.php">
    <h1>jurkCMS</h1>
</a>
<p>The struggle continues...</p>