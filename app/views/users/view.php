<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="/public/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Roboto&display=swap" rel="stylesheet">

    <title>Register</title>
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-md navbar-light bf-faded">
        <a class="navbar-brand" href="/">
            IMGER
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/home/images">Image Search</a>
                </li>
                <li class="nav-item active ">
                    <a class="nav-link" href="/users/upload">Upload</a>
                </li>
            </ul>

            <span class="navbar-text">
                <?php

                if (isset($data["username"])) {
                    ?>
                    <b><a href="/users/images"> <?= $data["username"] ?> </a></b>
                    <b class="ml-3"><a href="/users/images"> My Images</a></b>
                    <b class="ml-3"><a href="/users/logout">Logout</a></b>

                    <?php
                } else {
                    ?>

                    <a href="/users/login">Login</a>
                    <a href="/users/register">Register</a>
                    <?php
                }
                ?>
            </span>

        </div>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 mt-5">

            <h1 class="text-center mb-2 title-large">Edit Your Image!</h1>

            <form class="register-form mt-5" method="POST" enctype="multipart/form-data">
                <h4 class="form-title title-medium text-center">Edit Image</h4>

                <?php

                if(isset($data['updated'])) {
                    ?>

                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        updated!
                    </div>

                    <?php
                }

                if (isset($data['errors'])) {
                    foreach ($data['errors'] as $error) {
                        ?>

                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $error ?>
                        </div>

                        <?php
                    }
                }

                if (isset($data['image'])) {
                    ?>

                    <h1 class="title-small mb-3"><?= $data['image']['imgName']?></h1>

                    <input name="imgId" value="<?= $data['image']['id']?>" hidden>

                    <div class="form-group">
                        <label for="imageDescription">Edit Description:</label>
                        <textarea class="form-control" id="imageDescription" name="imageDescription"
                                  rows="3"><?= $data['image']['description']?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="imageDescription">Edit tags:</label>
                        <input type="text" class="form-control" id="imageTags" name="imageTags"
                               placeholder="Venince,2020" value="<?= $data['image']['group_concat(T.tag)']?>">
                    </div>

                    <?php
                }

                ?>
                <button type="submit" class="btn btn-blue btn-block">Update!</button>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>