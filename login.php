<?php
require_once 'lib/common.php';
require_once 'vendor/password_compat/lib/password.php';
// Tests for a minimum version of PHP, because earlier versions have bugs that affect security
if (version_compare(PHP_VERSION, '5.3.7') < 0)
{
    throw new Exception(
        'This system needs PHP 5.3.7 or later'
    );
}

session_start();


// Handle the form posting
$username = '';
if ($_POST)
{
    // Init the database
    $pdo = getPDO();

    // We redirect only if the password is correct
    $username = $_POST['username'];
    $ok = tryLogin($pdo, $username, $_POST['password']);
    if ($ok)
    {
        login($username);
        redirectAndExit('index.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application | Login
        </title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php require 'templates/title.php' ?>

        <p>Login here:</p>

        <?php // error checking in case we have a username, something is wrong ?>
        <?php if ($username): ?>
            <div class="error box">
                The username or password is incorrect, try again
            </div>
        <?php endif ?>

        <form method="post">
            <p>Username:
            <input type="text" name="username" value="<?php echo htmlEscape($username) ?>">
            </p>
            <p>Password
            <input type="password" name="password">
            </p>
            <input type="submit" name="submit" value="Login">
        </form>
    </body>
</html>