<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once __DIR__ . '/../../assets/includes/meta.php';
        require_once __DIR__ . '/../../app/controllers/auth.php';
        require_once __DIR__ . '/../../app/controllers/post.php';
        $isVideos = true;
    ?>
    <title><?= $video['title'] ?> | Catalog-Z</title>
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

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary"><?= $video['title'] ?></h2>
        </div>
        <div class="row tm-mb-90">            
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                <video preload="metadata" controls id="tm-video">
                    <source src="/assets/storage/video/<?= $video['vid'] ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <p class="mb-4">
                        <?= $video['description'] ?>
                    </p>
                    <hr><br>
                    <div class="text-center mb-5">
                        <a href="/assets/storage/video/<?= $video['vid'] ?>" download="<?= $video['vid'] ?>" class="btn btn-primary tm-btn-big">Download &nbsp; <i class="bi bi-download"></i></a>
                    </div>                    
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Resolution: </span><span class="tm-text-primary"><?= $video['dimension'] ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary"><?= $video['format'] ?></span>
                        </div>
                        <div>
                            <span class="tm-text-gray-dark">Duration: </span><span class="tm-text-primary"><?= $video['playtime'] ?></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3"><i class="bi bi-person-square"></i> Author: <?= $video['author'] ?></h3>
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
                        <?php foreach ($videosCategories as $id => $category): ?>
                        <a href="/public/page/vid-category.php?id=<?= $id ?>" class="tm-text-primary mr-2 mb-2 d-inline-block bg-primary text-white card p-2"><i class="bi bi-tag"></i> <?= $category ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Videos
            </h2>
        </div>
        <?php if (!empty($relatedVideos)): ?>
            <div class="row mb-3 tm-gallery">
            <?php foreach ($relatedVideos as $video): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <video style="max-height: 400px; max-width: 350px" src="/assets/storage/video/<?= $video['vid'] ?>"></video>
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
        <?php else: ?>
        <h4 class="text-primary bg-light px-3 py-4" style="border-radius: 10px">No related videos found <i class="bi bi-ban"></i></h4>
        <?php endif; ?>

    </div> <!-- container-fluid, tm-container-content -->

    <?php require_once __DIR__ . '/../../assets/includes/footer.php' ?>

    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>