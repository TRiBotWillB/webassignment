<?php

class home extends BaseController
{

    protected $search;

    public function __construct()
    {
        $this->search = $this->model('Search');
    }

    public function index()
    {
        session_start();

        $data = array();

        if(isset($_SESSION["username"])) {
            $data["username"] = $_SESSION["username"];
        }
        $this->view('home/index', $data);

    }

    public function images()
    {
        session_start();

        $data = array();

        if(isset($_SESSION["username"])) {
            $data["username"] = $_SESSION["username"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->search->description = isset($_POST["searchText"]) ? $_POST["searchText"] : "";

            // Default Search type as Description if not set
            $this->search->description = isset($_POST["searchType"]) ? $_POST["searchType"] : "Description";

            // Store the seach data and/or errors
            $returnedData = $this->search->search();

            // Combine the new data with the old data array to be sent to the page
            $data = array_merge($data, $returnedData);
        }

        // Render the page with the data
        $this->view('home/images', $data);

    }

}