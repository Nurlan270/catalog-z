<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/config.php';

/*          POSTS           */
$imagesCount = $db->count('images');
$videosCount = $db->count('videos');
$allCount = $imagesCount + $videosCount;

$posts = $db->pdo->prepare("SELECT id, title, format, vid, visibility FROM videos 
                                  UNION
                                  SELECT id, title, format, img, visibility FROM images
                                  ");
$posts->execute();

$allPosts = $posts->fetchAll();

//      Get invisible posts
$invsbPosts = $db->pdo->prepare("SELECT id, title, format, vid, visibility, created FROM videos WHERE visibility = 0
                                       UNION
                                       SELECT id, title, format, img, visibility, created FROM images WHERE visibility = 0
                                      ");
$invsbPosts->execute();

$invisiblePosts = $invsbPosts->fetchAll();

//         Delete
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    if ($_GET['frmt'] !== 'mp4') {
        $img = $db->select('images', ['img', 'categories'], ['id' => $_GET['del_id']])[0];

        unlink(__DIR__ . '/../../assets/storage/img/' . $img['img']);

        $categoriesArr = explode(', ', $img['categories']);

        foreach ($categoriesArr as $category) {
            $Cctegory = $db->select('categories', ['id', 'use_count'], ['id' => $category])[0];
            $db->update("categories", ['use_count' => $Cctegory['use_count'] !== 0 ? $Cctegory['use_count'] - 1 : 0], ['id' => $Cctegory['id']]);
        }

        $db->delete('images', ['id' => $_GET['del_id']]);

    } else {
        $vid = $db->select('videos', ['vid', 'categories'], ['id' => $_GET['del_id']])[0];

        unlink(__DIR__ . '/../../assets/storage/video/' . $vid['vid']);

        $categoriesArr = explode(', ', $vid['categories']);

        foreach ($categoriesArr as $category) {
            $Cctegory = $db->select('categories', ['id', 'use_count'], ['id' => $category])[0];
            $db->update("categories", ['use_count' => $Cctegory['use_count'] !== 0 ? $Cctegory['use_count'] - 1 : 0], ['id' => $Cctegory['id']]);
        }

        $db->delete('videos', ['id' => $_GET['del_id']]);
    }

    header('Location: /admin/posts.php');
}

//      Make invisible
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['invisible_id'])) {
    if ($_GET['frmt'] !== 'mp4'): $db->update('images', ['visibility' => 0], ['id' => $_GET['invisible_id']]);
    else: $db->update('videos', ['visibility' => 0], ['id' => $_GET['invisible_id']]);
    endif;

    header('Location: /admin/posts.php');
}

//      Make visible
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['visible_id'])) {
    if ($_GET['frmt'] !== 'mp4'): $db->update('images', ['visibility' => 1], ['id' => $_GET['visible_id']]);
    else: $db->update('videos', ['visibility' => 1], ['id' => $_GET['visible_id']]);
    endif;

    header('Location: /admin/posts.php');
}

/*          CATEGORIES          */
$categoriesCount = $db->count('categories');

$categories = $db->pdo->prepare('SELECT * FROM categories');
$categories->execute();

$allCategories = $categories->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_category_id'])) {
    $db->delete('categories', ['id' => $_GET['del_category_id']]);
    header('Location: /admin/categories.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $visibility = $_POST['visibility'] ?? 0;

    $db->insert('categories', [
        'name' => $name,
        'visibility' => $visibility
    ]);
}