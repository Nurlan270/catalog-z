<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['search-term']) || empty($_GET['category'])): header('Location: /public');
endif;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search-term']) && $_GET['category'] === 'img') {
    $sql = "SELECT id, title, img, created, views FROM `images` WHERE visibility = 1 AND (title LIKE '%" . $_GET['search-term'] . "%' OR description LIKE '%" . $_GET['search-term'] . "%')";
    $searchPosts = $db->pdo->prepare($sql);
    $searchPosts->execute();
    $searchResult = $searchPosts->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search-term']) && $_GET['category'] === 'vid') {
    $sql = "SELECT id, title, vid, created, views FROM `videos` WHERE visibility = 1 AND (title LIKE '%" . $_GET['search-term'] . "%' OR description LIKE '%" . $_GET['search-term'] . "%')";
    $searchPosts = $db->pdo->prepare($sql);
    $searchPosts->execute();
    $searchResult = $searchPosts->fetchAll();
}
