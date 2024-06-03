<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once __DIR__ . '/../assets/includes/meta.php';
        require_once __DIR__ . '/../app/controllers/auth.php';
        require_once __DIR__ . '/../app/controllers/admin.php';
    ?>
    <title>Invisible Posts | Admin -  Catalog-Z</title>
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
    <?php require_once __DIR__ . '/../assets/includes/header.php' ?>

    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 d-flex flex-lg-row justify-content-center">
        <?php if (!empty($_SESSION['user']) || !empty($_COOKIE['ut'])): ?>
        <li class="nav-item">
            <a class="nav-link nav-link-4" aria-current="page" href="../public/page/addMedia.php">Add media</a>
        </li>
        <?php endif; ?>
<!--       Admin  E1DALZjh/GKE+hz9es3TovqWrFyePJygq0Js3FsYxQjnVyM=     -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin' || isset($_COOKIE['ut']) && $_COOKIE['ut'] === 'sssRPYVTr/3nX2fBVH6ymE41ZHEktVGyV6rcwrB6cDcq8Q=='): ?>
        <li class="nav-item">
            <a class="nav-link nav-link-4 text-warning" aria-current="page" href="/admin/posts.php">Admin</a>
        </li>
        <?php endif; ?>
<!--         _____        -->
        <li class="nav-item">
            <a class="nav-link nav-link-4" aria-current="page" href="../app/controllers/auth.php?logout=1">Log out</a>
        </li>
    </ul>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                Invisible posts
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    Page <input type="number" value="1" size="1" class="tm-input-paging tm-text-primary"> of Unknown
                </form>
            </div>
        </div>
        <div class="row tm-mb-90 tm-gallery">
<!--              Post            -->
            <?php foreach ($invisiblePosts as $post): ?>
        	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <?php if ($post['format'] !== 'mp4'): ?>
                    <img style="max-height: 400px; max-width: 350px" src="/assets/storage/img/<?= $post['vid'] ?>" alt="Image" class="img-fluid">
                    <?php else: ?>
                    <video style="max-height: 400px; max-width: 350px" src="/assets/storage/video/<?= $post['vid'] ?>" alt="Image" class="img-fluid"></video>
                    <?php endif; ?>
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2><?= strlen($post['title']) > 15
                                ? substr($post['title'], 0, 15) . '...'
                                : $post['title']
                            ?></h2>
                        <?php if ($post['format'] !== 'mp4'): ?>
                        <a href="/public/page/photo-detail.php?img_id=<?= $post['id'] ?>">View more</a>
                        <?php else: ?>
                        <a href="/public/page/video-detail.php?vid_id=<?= $post['id'] ?>">View more</a>
                        <?php endif; ?>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?= $post['created'] ?></span>
                    <span><?= $post['views'] ?? 0 ?> views</span>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
<!--   Pagination     -->
        <div class="row tm-mb-90">

        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <?php require_once __DIR__ . '/../assets/includes/footer.php' ?>
</body>
</html>