<?php


class users extends BaseController
{
    protected $user;
    protected $search;

    public function __construct()
    {
        $this->user = $this->model('User');
        $this->search = $this->model('Search');
    }

    public function index()
    {

    }

    public function images() {
        session_start();

        $data = array();
        if(isset($_SESSION["username"])) {
            $data["username"] = $_SESSION["username"];
            $id = $_SESSION["id"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["imgId"])) {
            $imgId = $_POST["imgId"];

            // Store the seach data and/or errors
            $returnedData = $this->search->search();

            // Combine the new data with the old data array to be sent to the page
            $data = array_merge($data, $returnedData);
        } else {

            // No POST data means no need to filter images, let's send them all
            $data['images'] = $this->search->findUserImages($id);
        }

        // Render the page with the data
        $this->view('users/user_images', $data);
    }

    public function upload()
    {
        session_start();

        $data = array();

        if (isset($_SESSION["username"])) {
            $data["username"] = $_SESSION["username"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Make sure user is logged in
            if (isset($_SESSION["username"])) {

                // Attempt to upload the image, POST data will be taken within the user model
                $errors = $this->user->upload();

                if (sizeof($errors) > 0) {
                    // Since there are errors, render the page showing those errors

                    $data['errors'] = $errors;
                } else {

                    // Image must be uploaded, send message back saying upload successful
                    $data['uploaded'] = true;

                }
            }
        }

        $this->view('users/upload', $data);

    }

    public function logout()
    {
        session_start();

        // Unset all sessions variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        header("Location: login");

        exit();
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->user->username = isset($_POST["username"]) ? $_POST["username"] : "";
            $this->user->password1 = isset($_POST["password"]) ? $_POST["password"] : "";

            $errors = $this->user->login();

            if (sizeof($errors) > 0) {
                $this->view('users/login', [
                    'errors' => $errors
                ]);
            } else {
                // Account must have logged in, Redirect to Index page
                header('Location: /');

                exit();
            }
        } else {
            $this->view('users/login');
        }
    }

    public function register()
    {

        //if post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Get all the POST data, check if it exists, else make the var and empty string, store in user model
            $this->user->username = isset($_POST["username"]) ? $_POST["username"] : "";
            $this->user->email = isset($_POST["email"]) ? $_POST["email"] : "";
            $this->user->password1 = isset($_POST["password1"]) ? $_POST["password1"] : "";
            $this->user->password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";

            // Attempt to register the user, grab any errors returned
            $errors = $this->user->register();

            // Check if any errors were returned by register function
            if (sizeof($errors) > 0) {

                // Render the Register page with the displayed errors
                $this->view('users/register', [
                    'errors' => $errors
                ]);
            } else {

                // Account must be created, Redirect to Login
                header('Location: login');

                exit();
            }
        }

        // Default page render (if no POST etc)
        $this->view('users/register');
    }
}