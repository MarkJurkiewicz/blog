<div class="top-menu">
    <div class="menu-options">
        <?php if (isLoggedIn()): ?>
            <a href="edit-post.php">New post</a>

            How ya doing tonight <?php echo htmlEscape(getAuthUser()) ?>?!?
            <a href="logout.php">Log out</a>
        <?php else: ?>
            <a href="login.php">Log in</a>
        <?php endif ?>
    </div>