<?php


class User
{

    public $username;
    public $email;
    public $password1;
    public $password2;

    public function login()
    {
        require '../app/bin/config.php';
        $errors = array();

        // Check if a username has been entered and is at least 5 characters long
        if (empty(trim($this->username))) {
            $errors[] = 'Please enter your username';
        }

        if (empty(trim($this->password1))) {
            $errors[] = 'Please enter your password';
        }

        // Check if the password is incorrect, if so add to errors
        // Session should be setup if no errors return
        if(!$this->validatePassword($this->username, $this->password1)) {
            $errors[] = "Username or password incorrect";
            $errors[] = "Username: $this->username, password: $this->password1";
        }

        return $errors;
    }

    public function register()
    {
        require '../app/bin/config.php';
        $errors = array();

        // Check if a username has been entered and is at least 5 characters long
        if (empty(trim($this->username)) || strlen($this->username) < 5) {
            $errors[] = 'Username must be at least 5 characters long';
        }

        // Check if an email has been entered and is a valid email
        if (empty(trim($this->email)) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        }

        // Check if a password has been entered and is at least 5 characters long
        if (empty(trim($this->password1)) || strlen($this->password1) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        // Check if the second password is equal to first (No need to check length etc here since it's already done on the first)
        if ($this->password1 != $this->password2) {
            $errors[] = 'Passwords must match';
        }

        // If there are some errors
        if (sizeof($errors) == 0) {

            if ($this->userExists($this->username)) {

                $errors[] = "Username taken.";

            } else {

                $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
                $hashedPw = password_hash($this->password1, PASSWORD_DEFAULT);

                if ($stmt = $conn->prepare($sql)) {

                    $stmt->bind_param("sss", $this->username, $hashedPw, $this->email);
                    $stmt->execute();

                    $stmt->store_result();

                    $stmt->close();
                }
            }
        }

        return $errors;
    }


    function userExists($user)
    {
        require '../app/bin/config.php';

        $sql = "SELECT username FROM USERS where username = ?";
        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $user);
            $stmt->execute();

            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->close();

                return true;
            } else {
                $stmt->close();

                return false;
            }
        }

    }

    function validatePassword($user, $pass) {
        require '../app/bin/config.php';

        $sql = "SELECT id,  username, password FROM USERS where username = ?";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $user);
            $stmt->execute();

            $stmt->store_result();

            $id = "";
            $usern = "";
            $hashedPassword ="";

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $usern, $hashedPassword);
                $stmt->fetch();

                if(password_verify($pass, $hashedPassword)) {
                    session_start();

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $usern;

                    $stmt->close();

                    return true;
                }

                $stmt->close();

                return false;
            } else {
                $stmt->close();

                return false;
            }
        }
    }

}