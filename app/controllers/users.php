<?php


class users extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = $this->model('User');
    }

    public function index()
    {

    }

    public function register()
    {

        //if post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Get all the POST data, check if it exits, else make the var and empty string
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $password1 = isset($_POST["password1"]) ? $_POST["password1"] : "";
            $password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";

            $errors = array();

            //check errors, send register [errors] if any

            // Check if a username has been entered and is at least 5 characters long
            if (empty(trim($username)) || strlen($username) < 5) {
                $errors[] = 'Username must be at least 5 characters long';
            }

            // Check if an email has been entered and is a valid email
            if (empty(trim($email)) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            // Check if a password has been entered and is at least 5 characters long
            if (empty(trim($password1)) || strlen($password1) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }

            // Check if the second password is equal to first (No need to check length etc here since it's already done on the first)
            if ($password1 != $password2) {
                $errors[] = 'Passwords must match';
            }

            // If there are some errors
            if (sizeof($errors) > 0) {

                // Render the view, sending the errors as data to be displayed on the page
                $this->view('users/register', [
                    'errors' => $errors
                ]);
            } else {

                // No errors, register the user then redirect to login page
                // do registration here

                // Send a location header to redirect the user to the login page
                header('Location: login');

                exit();
            }
        }

        // Default page render (if no POST etc)
        $this->view('users/register');
    }

    public function login()
    {
        echo 'login';
    }
}