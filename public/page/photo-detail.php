<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once __DIR__ . '/../../assets/includes/meta.php';
        require_once __DIR__ . '/../../app/controllers/auth.php';
        require_once __DIR__ . '/../../app/controllers/post.php';
        $postVisibility = $db->select('images', ['visibility'], ['id' => $_GET['img_id']])[0]['visibility'];

        // Check if user is not admin or cookie is not set to 'secretcode' and post visibility is 0
        if ($postVisibility == 0 && (isset($_SESSION['user']) && $_SESSION['user'] != 'admin') || (isset($_COOKIE['ut']) && $_COOKIE['ut'] != 'sssRPYVTr/3nX2fBVH6ymE41ZHEktVGyV6rcwrB6cDcq8Q==')) {
            header('Location: /public/errors/404.php');
        }
        $isPhotos = true;
    ?>
    <title><?= $image['title'] ?? 'Not found' ?> | Catalog-Z</title>
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
<!--
    
TemplateMo 556 Catalog-Z

https://templatemo.com/tm-556-catalog-z

-->
</head>
<body>

    <?php require_once __DIR__ . '/../../assets/includes/header.php' ?>

    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 d-flex flex-lg-row justify-content-center">
        <li class="nav-item">
            <?php if (isset($isPhotos)): ?>
                <a class="nav-link nav-link-1 active" aria-current="page" href="/public/index.php">Photos</a>
            <?php else: ?>
                <a class="nav-link nav-link-1" aria-current="page" href="/public/index.php">Photos</a>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <?php if (isset($isVideos)): ?>
                <a class="nav-link nav-link-2 active" aria-current="page" href="videos.php">Videos</a>
            <?php else: ?>
                <a class="nav-link nav-link-2" aria-current="page" href="videos.php">Videos</a>
            <?php endif; ?>
        </li>
        <?php if (!empty($_SESSION['user']) || !empty($_COOKIE['ut'])): ?>
        <li class="nav-item">
            <a class="nav-link nav-link-4" aria-current="page" href="addMedia.php">Add media</a>
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

<!--    Main        -->
    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary text-break"><?= $image['title'] ?></h2>
        </div>
        <div class="row tm-mb-90">            
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 d-flex justify-content-center">
                <img src="/assets/storage/img/<?= $image['img'] ?>" alt="Image" class="img-fluid center">
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <p class="mb-4 text-break">
                        <?= $image['description'] ?>
                    </p>
                    <hr><br>
                    <div class="text-center mb-5">
                        <a href="/assets/storage/img/<?= $image['img'] ?>" download="<?= $image['img'] ?>" class="btn btn-primary tm-btn-big">Download &nbsp; <i class="bi bi-download"></i></a>
                    </div>                    
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Dimension: </span><span class="tm-text-primary"><?= $image['dimension'] ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Size: </span><span class="tm-text-primary"><?= $image['size'] ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary"><?= $image['format'] ?></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3"><i class="bi bi-person-square"></i> Author: <?= $image['author'] ?></h3>
                        <hr>
                        <p>
                            <b><i class="bi bi-shield-fill-exclamation"></i> Non-commercial Use:</b> Images may be used for non-commercial purposes only. Commercial use of images without explicit permission from the original author is prohibited.
                            <br>
                        </p>
                        <h6 class="tm-text-gray-dark">You can get acquainted with the full license <a href="/public/page/license.php" target="_blank" class="font-weight-bold text-decoration-underline">here</a></h6>
                    </div>
                    <hr>
                    <div>
                        <h3 class="tm-text-gray-dark mb-3">Tags <i class="bi bi-tags-fill"></i></h3>
                        <?php foreach ($imagesCategories as $id => $category): ?>
                            <a href="/public/page/img-category.php?id=<?= $id ?>" class="tm-text-primary mr-2 mb-2 d-inline-block bg-primary text-white card p-2"><i class="bi bi-tag"></i> <?= $category ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Photos
            </h2>
        </div>
        <?php if (!empty($relatedImages)): ?>
            <div class="row mb-3 tm-gallery">
                <?php foreach ($relatedImages as $image): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <img style="max-height: 400px; max-width: 350px" src="/assets/storage/img/<?= $image['img'] ?>" alt="Image" class="img-fluid">
                            <figcaption class="d-flex align-items-center justify-content-center">
                                <h2><?= strlen($image['title']) > 15
                                        ? substr($image['title'], 0, 15) . '...'
                                        : $image['title']
                                    ?></h2>
                                <a href="/public/page/photo-detail.php?img_id=<?= $image['id'] ?>">View more</a>
                            </figcaption>
                        </figure>
                        <div class="d-flex justify-content-between tm-text-gray">
                            <span class="tm-text-gray-light"><?= $image['created'] ?></span>
                            <span><?= $image['views'] ?? 0 ?> views</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
        <h4 class="text-primary bg-light px-3 py-4" style="border-radius: 10px">No related photos found <i class="bi bi-ban"></i></h4>
        <?php endif; ?>
    </div> <!-- container-fluid, tm-container-content -->

    <?php require_once __DIR__ . '/../../assets/includes/footer.php' ?>
</body>
</html>