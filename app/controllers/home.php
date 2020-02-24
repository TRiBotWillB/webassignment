<?php

class home extends BaseController
{

    protected $image;

    public function __construct()
    {
        $this->image = $this->model('Image');
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
            $this->image->searchText = isset($_POST["searchText"]) ? $_POST["searchText"] : "";

            // Default Search type as Description if not set
            $this->image->searchType = isset($_POST["searchType"]) ? $_POST["searchType"] : "Description";

            // Store the seach data and/or errors
            $returnedData = $this->image->search();

            // Combine the new data with the old data array to be sent to the page
            $data = array_merge($data, $returnedData);
        } else {

            // No POST data means no need to filter images, let's send them all
            $data['images'] = $this->image->findAllImages();
        }

        // Render the page with the data
        $this->view('home/images', $data);

    }

}