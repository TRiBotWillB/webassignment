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
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 mt-5">

            <h1 class="text-center mb-2 title-large">IMGER</h1>

            <form class="register-form mt-5" method="POST">
                <h4 class="form-title title-medium text-center">Register</h4>

                <?php
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
                ?>

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                           required>
                </div>

                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" id="password1" name="password1" class="form-control" placeholder="Password"
                           required>
                </div>

                <div class="form-group">
                    <label for="password2">Repeat Password:</label>
                    <input type="password" id="password2" name="password2" class="form-control"
                           placeholder="Repeat password" required>
                </div>

                <button type="submit" class="btn btn-blue btn-block">Register</button>
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