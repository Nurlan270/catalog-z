<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <?php require_once __DIR__ . '/../../app/controllers/post.php' ?>
    <title>Add Post</title>
    <!-- Bootstrap CSS -->

    <style>
        /* Additional CSS styles */
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        #background-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8); /* Add transparency */
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .custom-file-label {
            overflow: hidden;
        }

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
    <!-- Background video -->
    <video autoplay muted loop id="background-video">
        <source src="../../assets/storage/video/background-upload-page.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <div class="row">
            <div class="col-7">
                <h2 class="mb-4">Add New Post</h2>
            </div>
            <div class="col-5 text-right">
                <p class="py-2 text-primary link-primary text-decoration-none"><a href="/public">Go back ←</a></p>
            </div>
        </div>
        <?php if (!empty($msg)): ?>
            <div class="alert alert-danger"><?= $msg ?></div>
        <?php endif; ?>
        <form action="addMedia.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="postName">Post Name:</label>
                <input type="text" class="form-control" id="postName" name="postName" value="<?= $postName ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="postDescription" rows="4" required><?= $postDesc ?></textarea>
            </div>

           <div class="form-group">
                <label for="categories">Categories:</label>
                <select class="form-control" id="categories" name="categories[]" required multiple>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= isset($selectedCategories) && in_array($category['id'], $selectedCategories) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="media">Upload Image or Video:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="media" name="media" accept="image/*, video/*" required>
                    <label class="custom-file-label" for="media">Choose file</label>
                </div>
            </div>

            <button type="submit" name="uploadPost" class="btn btn-primary w-50 d-block mx-auto">Add Post</button>
        </form>
    </div>
</body>
</html>
