<?php

class home extends BaseController
{

    public function index()
    {
        session_start();

        $data = array();

        if(isset($_SESSION["username"])) {
            $data["username"] = $_SESSION["username"];
        }
        $this->view('home/index', $data);

    }

}