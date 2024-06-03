<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/config.php';

use Medoo\Medoo;

// Get all images
$images = $db->pdo->prepare('SELECT * FROM `images` WHERE visibility != 0 ORDER BY `id` DESC');
$images->execute();

// Get all videos
$videos = $db->pdo->prepare('SELECT * FROM `videos` WHERE visibility != 0 ORDER BY `id` DESC');
$videos->execute();

if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_COOKIE['ut']) && $_COOKIE['ut'] === 'sssRPYVTr/3nX2fBVH6ymE41ZHEktVGyV6rcwrB6cDcq8Q=='):
$categories = $db->select('categories', ['id', 'name']);
else:
$categories = $db->select('categories', ['id', 'name'], ['visibility' => 1]);
endif;

$msg = null;

//      Upload/Create post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uploadPost'])) {
    $postName = strip_tags(htmlspecialchars(trim($_POST['postName'])));
    $postDesc = strip_tags(htmlspecialchars(trim($_POST['postDescription'])));
    $selectedCategories = $_POST['categories'];

    if (mb_strlen($postName, 'UTF-8') < 3): $msg = 'Name can\'t be shorter than 3 characters!';
    elseif (mb_strlen($postName, 'UTF-8') > 30): $msg = 'Name can\'t be longer than 30 characters!';
    elseif (mb_strlen($postDesc, 'UTF-8') > 350): $msg = 'Description can\'t be longer than 350 characters!';
    endif;

    if (!empty($msg)): return;
    endif;

//    Check media
    $fileFullName = time() . '_' . $_FILES['media']['name'];
    $fileTmpName = $_FILES['media']['tmp_name'];

    $getID3 = new getID3();
    $media = $getID3->analyze($fileTmpName);

//        Set vars
    $format = $media['fileformat'];
    $width = $media['video']['resolution_x'];
    $height = $media['video']['resolution_y'];
    // MB = Byte / 1000^2
    $size = sprintf('%.2f', ($media['filesize']) / 1000000) . ' MB';
    $dimension = $width . 'x' . $height;

    $imgDestination = __DIR__ . '/../../assets/storage/img/' . $fileFullName;
    $videoDestination = __DIR__ . '/../../assets/storage/video/' . $fileFullName;

    $author = $_SESSION['user'] ?? $db->select('users', ['username'], ['user_token' => $_COOKIE['ut']])[0]['username'];

//    Check if it's actually an image or not
    if (str_contains($media['mime_type'], 'image')): $isImage = true;
    elseif (str_contains($media['mime_type'], 'video')): $isImage = false;
    else: $msg = 'Something went wrong please try again later'; return;
    endif;

//    Instruction if its an image
    if ($isImage) {
        if (!in_array($format, ['png', 'jpg', 'jpeg'])): $msg = 'Provided image is in incorrect format! Allowed formats: png, jpg, jpeg'; return;
        endif;

        $db->insert('images', [
            'author' => $author,
            'title' => $postName,
            'description' => $postDesc,
            'img' => $fileFullName,
            'dimension' => $dimension,
            'size' => $size,
            'format' => $format,
            'categories' => implode(', ', $selectedCategories),
            'created' => date('d M Y'),
        ]);

        foreach ($selectedCategories as $category) {
            $Cctegory = $db->select('categories', ['id', 'use_count'], ['id' => $category])[0];
            $db->update("categories", ['use_count' => $Cctegory['use_count'] + 1], ['id' => $Cctegory['id']]);
        }

        move_uploaded_file($fileTmpName, $imgDestination);

        header('Location: /public');

//    Instruction if its a video
    } elseif (!$isImage) {
        if ($format !== 'mp4'): $msg = 'Provided video is in incorrect format! Allowed format: mp4'; return;
        endif;

        $playtime = $media['playtime_string'];

        $db->insert('videos', [
            'author' => $author,
            'title' => $postName,
            'description' => $postDesc,
            'vid' => $fileFullName,
            'dimension' => $dimension,
            'playtime' => $playtime,
            'size' => $size,
            'format' => $format,
            'categories' => implode(', ', $selectedCategories),
            'created' => date('d M Y'),
        ]);

        foreach ($selectedCategories as $category) {
            $Cctegory = $db->select('categories', ['id', 'use_count'], ['id' => $category])[0];
            $db->update("categories", ['use_count' => $Cctegory['use_count'] + 1], ['id' => $Cctegory['id']]);
        }

        move_uploaded_file($fileTmpName, $videoDestination);

        header('Location: /public/page/videos.php');
    }

} else {
    $postName = null;
    $postDesc = null;
    $selectedCategories = [];
    if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_COOKIE['ut']) && $_COOKIE['ut'] === 'sssRPYVTr/3nX2fBVH6ymE41ZHEktVGyV6rcwrB6cDcq8Q=='):
    $categories = $db->select('categories', ['id', 'name']);
    else:
    $categories = $db->select('categories', ['id', 'name'], ['visibility' => 1]);
    endif;
}

//      Single IMAGE post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['img_id'])) {
    $image = $db->select('images', '*', ['id' => $_GET['img_id']])[0] ?? header('Location: /public/errors/404.php');

    $db->update('images', ['views' => $image['views'] + 1], ['id' => $_GET['img_id']]);

    $imgCategories = $db->select('images', ['categories'], ['id' => $_GET['img_id']])[0]['categories'];
    $imgCategories = explode(', ', $imgCategories);

//    Get categories
    $imagesCategories = [];

    foreach ($imgCategories as $imgCat) {
        $query = $db->pdo->prepare("SELECT id, name FROM categories WHERE id = ?");
        $query->execute([$imgCat]);
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res): $imagesCategories[$res['id']] = $res['name'];
        endif;
    }

//      Get related images by categories
    $query = 'SELECT * FROM `images` WHERE visibility = 1 AND id != ' . $_GET['img_id'] . ' AND (';
    $str = '';
    foreach ($imagesCategories as $key => $category){
        if ($key != array_key_last($imagesCategories)): $str .= 'categories LIKE ' . "'%$key%'" . ' OR ';
        else: $str .= 'categories LIKE ' . "'%$key%') ORDER BY views DESC";
        endif;
    }

    $sql = $query . $str;

    $stmt = $db->pdo->prepare($sql);
    $stmt->execute();

    $relatedImages = $stmt->fetchAll();
}

//      Single VIDEO post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vid_id'])) {
    $video = $db->select('videos', '*', ['id' => $_GET['vid_id']])[0] ?? header('Location: /public/errors/404.php');

    $db->update('videos', ['views' => $video['views'] + 1], ['id' => $_GET['vid_id']]);

    $vidCategories = $db->select('videos', ['categories'], ['id' => $_GET['vid_id']])[0]['categories'];
    $vidCategories = explode(', ', $vidCategories);

//    Get categories
    $videosCategories = [];

    foreach ($vidCategories as $vidCat) {
        $query = $db->pdo->prepare("SELECT id, name FROM categories WHERE id = ?");
        $query->execute([$vidCat]);
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res): $videosCategories[$res['id']] = $res['name'];
        endif;
    }

//      Get related videos by categories
    $query = 'SELECT * FROM `videos` WHERE visibility = 1 AND id != ' . $_GET['vid_id'] . ' AND (';
    $str = '';
    foreach ($videosCategories as $key => $category){
        if ($key != array_key_last($videosCategories)): $str .= 'categories LIKE ' . "'%$key%'" . ' OR ';
        else: $str .= 'categories LIKE ' . "'%$key%') ORDER BY views DESC";
        endif;
    }

    $sql = $query . $str;

    $stmt = $db->pdo->prepare($sql);
    $stmt->execute();

    $relatedVideos = $stmt->fetchAll();
}