<?php
require_once 'lib/common.php';
require_once 'lib/edit-post.php';
require_once 'lib/view-post.php';

session_start();
//Blocks non-auth users from seeing this screen
if (!isLoggedIn())
{
    redirectAndExit('index.php');
}

//Empty defaults
$title = $body = '';

//Initialize database and get handle
$pdo = getPDO();


// Post operation
$errors = array();
if ($_POST)
{
    // simple Form Validation checks
    $title = $_POST['post-title'];
    if (!$title)
    {
        $errors[] = 'The post must have a title';
    }
    $body = $_POST['post-body'];
    if (!$body)
    {
        $errors[] = 'The post must have a body';
    }

    if (!$errors)
    {
        $pdo = getPDO();
        $userId = getAuthUserId($pdo);
        $postId = addPost(
            $pdo,
            $title,
            $body,
            $userId
        );

        if ($postId === false)
        {
            $errors[] = 'Post operation failed';
        }
    }

    if (!$errors)
    {
        redirectAndExit('edit-post.php$post_id=' . $postId);
    }
}
elseif (isset($_GET['post_id']))
{
    $post = getPostRow($pdo, $_GET['post_id']);
    if ($post)
    {
        $title = $post['title'];
        $body = $post['body'];
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>My CMS/BLOG | New post</title>
    <?php require 'templates/head.php' ?>
</head>
<body>
<?php require 'templates/title.php' ?>

<?php if ($errors): ?>
<div class = "error box">
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?>
<form method="post" class="post-form user-form">
    <div>
        <label for="post-title">Title:</label>
        <input
            id="post-title"
            name="post-title"
            type="text"
            value="<?php echo htmlEscape($title) ?>"
        />
    </div>
    <div>
        <label for="post-body">Body:</label>
                <textarea
                    id="post-body"
                    name="post-body"
                    rows="12"
                    cols="70"
                ><?php echo htmlEscape($body) ?></textarea>
    </div>
    <div>
        <input
            type="submit"
            value="Save post"
        />
    </div>
</form>
</body>
</html>