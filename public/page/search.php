<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once __DIR__ . '/../../assets/includes/meta.php';
        require_once __DIR__ . '/../../app/controllers/auth.php';
        require_once __DIR__ . '/../../app/controllers/search.php';
        $category = $_GET['category'] ?? 'img';
        $searchTerm = isset($_GET['search-term']) ? htmlspecialchars($_GET['search-term']) : '';
    ?>
    <title>Home | Catalog-Z</title>
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
                <a class="nav-link nav-link-1 active" aria-current="page" href="/public">Photos</a>
            <?php else: ?>
                <a class="nav-link nav-link-1" aria-current="page" href="/public">Photos</a>
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
            <a class="nav-link nav-link-4" aria-current="page" href="auth.php?logout=1">Log out</a>
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


    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll">
        <form action="search.php" method="get" class="d-flex tm-search-form">
            <input name="search-term" value="<?= $_GET['search-term'] ?>" class="form-control tm-search-input" type="search" placeholder="Search" aria-label="Search">
            <select name="category" class="form-control" style="width: 17%">
                <option value="img" <?= ($category === 'img') ? 'selected' : '' ?>>Images</option>
                <option value="vid" <?= ($category === 'vid') ? 'selected' : '' ?>>Videos</option>
            </select>
            <button class="btn btn-outline-success tm-search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                Search results
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    Page <input type="number" value="1" size="1" class="tm-input-paging tm-text-primary"> of Unknown
                </form>
            </div>
        </div>
        <div class="row tm-mb-90 tm-gallery">

<!--            Nothing found       -->
            <?php if (empty($searchResult)): ?>
            <h4 class="text-primary bg-light px-3 py-4" style="border-radius: 10px">Nothing found by your search <i class="bi bi-ban"></i></h4>
<!--                Image search results            -->
            <?php elseif (isset($_GET['search-term']) && $_GET['category'] === 'img'): ?>
                <?php foreach ($searchResult as $image): ?>
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

<!--                Video search results            -->
            <?php elseif (isset($_GET['search-term']) && $_GET['category'] === 'vid'): ?>
                <?php foreach ($searchResult as $video): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <video style="max-height: 400px; max-width: 350px" src="/assets/storage/video/<?= $video['vid'] ?>" class="img-fluid"></video>
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

            <?php endif; ?>
        </div>
<!--   Pagination     -->
        <div class="row tm-mb-90">

        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <?php require_once __DIR__ . '/../../assets/includes/footer.php' ?>
</body>
</html>