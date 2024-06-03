<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../assets/includes/meta.php' ?>
    <?php require_once __DIR__ . '/../app/controllers/admin.php' ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Posts | Admin - Catalog-Z</title>
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
        .table th, .table td {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row mb-3">
        <div class="col">
            <h1 class="mb-2">Manage Posts | Catalog-Z</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <span class="mr-3">Image Posts: <span class="text-primary"><?= $imagesCount ?></span></span>
                    <span class="mr-3">Video Posts: <span class="text-primary"><?= $videosCount ?></span></span>
                    <span>All Posts: <span class="text-primary"><?= $allCount ?></span></span>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="categories.php" class="btn btn-success mr-2">Categories</a>
                    <a href="invisiblePosts.php" class="btn btn-primary">Invisible Posts</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40%">Post Name</th>
                    <th style="width: 20%" class="text-right">Format</th>
                    <th style="width: 20%" class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allPosts as $post): ?>
                <tr>
                    <td><?= $post['title'] ?></td>
                    <td class="text-right"><?= $post['format'] ?></td>
                    <td class="text-right">
                        <?php if ($post['visibility'] === 1): ?>
                        <a href="/app/controllers/admin.php?invisible_id=<?= $post['id'] ?>&frmt=<?= $post['format'] ?>"><button class="btn btn-secondary btn-sm">Make Invisible</button></a>
                        <?php else: ?>
                        <a href="/app/controllers/admin.php?visible_id=<?= $post['id'] ?>&frmt=<?= $post['format'] ?>"><button class="btn btn-primary btn-sm">Make Visible</button></a>
                        <?php endif; ?>
                        <a href="/app/controllers/admin.php?del_id=<?= $post['id'] ?>&frmt=<?= $post['format'] ?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
