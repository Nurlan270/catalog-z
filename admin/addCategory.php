<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../app/controllers/admin.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add category | Admin - Catalog-Z</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="row d-flex justify-content-between pl-3 pr-3 align-items-center">
                <h4>Category Form</h4>
                <a href="/admin/categories.php">Go back ←</a>
            </div>
          </div>
          <div class="card-body">
            <form action="addCategory.php" method="post">
              <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" name="category_name" class="form-control" id="categoryName" placeholder="Enter category name">
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="visibility" value="1" id="categoryVisible" checked>
                <label class="form-check-label" for="categoryVisible">Visible</label>
              </div>
              <button type="submit" name="add_category" class="btn btn-success w-50 d-block mx-auto">Add category</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
