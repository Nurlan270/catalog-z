<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once __DIR__ . '/../../assets/includes/meta.php';
        require_once __DIR__ . '/../../app/controllers/auth.php';
        require_once __DIR__ . '/../../app/controllers/post.php';
        require_once __DIR__ . '/../../app/database/config.php';
        require_once __DIR__ . '/../../vendor/autoload.php';

        if (!isset($_GET['id'])): header('Location: /public');
        endif;

        $isCategory = true;

        $categoryName = $db->pdo->prepare('SELECT name FROM categories WHERE id = ?');
        $categoryName->execute([$_GET['id']]);
        $categoryName = $categoryName->fetch()['name'] ?? header('Location: /public/page/vid-category.php?id=' . $_GET['id']);

//         Pagination
        $page = $_GET['page'] ?? 1;

        if ($page <= 0 || !is_numeric($page)): header('Location: /public/page/vid-category.php?id=' . $_GET['id']);
        endif;

        $limit = 8;
        $offset = $limit * ($page - 1);
        // Get count
        $query = $db->pdo->prepare('SELECT COUNT(*) AS c FROM videos WHERE categories LIKE ? AND visibility = 1');
        $query->execute(['%'.$_GET['id'].'%']);
        $cnt = $query->fetch()['c'];
        $total_pages = ceil($cnt / $limit);

        if ($page > $total_pages): header('Location: /public/page/vid-category.php?id=' . $_GET['id']);
        endif;

        $videos = $db->pdo->prepare("SELECT * FROM videos WHERE visibility = ? AND categories LIKE ? ORDER BY id DESC LIMIT $limit OFFSET $offset");
        $videos->execute([1, '%'.$_GET['id'].'%']);
        $videos = $videos->fetchAll();

    ?>
    <title><?= $categoryName ?> | Catalog-Z</title>
    <style>
        @media (max-width: 425px) {
            .navbar-nav {
                flex-direction: column !important;
                text-align: center;
                margin: 0 auto;
            }
            .nav-item { margin: 0 75px; }
            .nav-item:last-child { margin: 0 75px; }
        }

        @media (min-width: 426px) {
            .navbar-nav {
                justify-content: center !important;
                flex-direction: row;
            }
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../assets/includes/header.php' ?>

    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 d-flex flex-lg-row justify-content-center">
        <li class="nav-item">
            <?php if (isset($isPhotos)): ?>
                <a class="nav-link nav-link-1" aria-current="page" href="/public">Photos</a>
            <?php else: ?>
                <a class="nav-link nav-link-1" aria-current="page" href="/public">Photos</a>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <?php if (isset($isVideos)): ?>
                <a class="nav-link nav-link-2 active" aria-current="page" href="../page/videos.php">Videos</a>
            <?php else: ?>
                <a class="nav-link nav-link-2 active" aria-current="page" href="../page/videos.php">Videos</a>
            <?php endif; ?>
        </li>
        <?php if (!empty($_SESSION['user']) || !empty($_COOKIE['ut'])): ?>
        <li class="nav-item">
            <a class="nav-link nav-link-4" aria-current="page" href="../page/addMedia.php">Add media</a>
        </li>
<!--       Admin      -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_COOKIE['ut']) && $_COOKIE['ut'] === 'sssRPYVTr/3nX2fBVH6ymE41ZHEktVGyV6rcwrB6cDcq8Q=='): ?>
        <li class="nav-item">
            <a class="nav-link nav-link-4 text-warning" aria-current="page" href="/admin/posts.php">Admin</a>
        </li>
        <?php endif; ?>
<!--         _____        -->
        <li class="nav-item">
            <a class="nav-link nav-link-4" aria-current="page" href="../../app/controllers/auth.php?logout=1">Log out</a>
        </li>
        <?php else: ?>
        <li class="nav-item">
            <?php if (isset($isAbout)): ?>
                <a class="nav-link nav-link-3 active" aria-current="page" href="/public/auth/reg.php">Sign Up</a>
            <?php else: ?>
                <a class="nav-link nav-link-3" aria-current="page" href="/public/auth/reg.php">Sign Up</a>
            <?php endif; ?>
        </li>
        <?php endif; ?>
    </ul>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                Images with category: <i><b><?= $categoryName ?></b></i>
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form method="get" action="vid-category.php" class="tm-text-primary">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    Page <input type="text" name="page" value="<?= $_GET['page'] ?? 1 ?>" size="1" class="tm-input-paging tm-text-primary"> of <?= $total_pages ?>
                </form>
            </div>
        </div>
        <div class="row tm-mb-90 tm-gallery">
<!--              Post            -->
            <?php foreach ($videos as $video): ?>
        	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <video style="max-height: 400px; max-width: 350px" src="/assets/storage/video/<?= $video['vid'] ?>" alt="Video" class="img-fluid"></video>
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2><?= strlen($video['title']) > 15
                                ? substr($video['title'], 0, 15) . '...'
                                : $video['title']
                            ?></h2>
                        <a href="/public/page/video-detail.php?vid_id=<?= $video['id'] ?>">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?= $video['created'] ?></span>
                    <span><?= $video['views'] ?? 0 ?> views</span>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
<!--   Pagination     -->
        <div class="row tm-mb-90">
            <?php require_once __DIR__ . '/../../assets/includes/pagination.php' ?>
        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <?php require_once __DIR__ . '/../../assets/includes/footer.php' ?>
</body>
</html>