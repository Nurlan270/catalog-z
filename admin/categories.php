<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../assets/includes/meta.php' ?>
    <?php require_once __DIR__ . '/../app/controllers/admin.php' ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Categories | Admin - Catalog-Z</title>
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
            <h1 class="mb-2">Manage Categories | Catalog-Z</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <span>Categories: <span class="text-primary"><?= $categoriesCount ?></span></span>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="posts.php" class="btn btn-success mr-2">Posts</a>
                    <a href="addCategory.php" class="btn btn-primary">Add Category</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60%">Name</th>
                    <th style="width: 20%" class="text-right">Use</th>
                    <th style="width: 20%" class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allCategories as $category): ?>
                <tr>
                    <td><?= $category['name'] ?></td>
                    <td class="text-right"><?= $category['use_count'] ?></td>
                    <td class="text-right">
                        <a href="/app/controllers/admin.php?del_category_id=<?= $category['id'] ?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
