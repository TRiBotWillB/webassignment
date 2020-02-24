<?php


class Search
{

    public $searchText;
    public $searchType;

    public function searchImages()
    {
        $data = array();

        switch ($this->searchType) {
            case "description":
                $data['images'] = searchByDescription($this->searchText);
                break;
            case "tags":
                $data['images'] = searchByTags($this->searchText);
                break;
            case "imgName":

                break;
        }
    }

    public function searchByDescription($description)
    {

    }

    public function searchByTag($tag)
    {

    }

    public function searchByImgName($imgName)
    {

    }

    public function findAllImages()
    {
        require '../app/bin/config.php';

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId GROUP BY I.id";

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc())
        {

            $rows[] = $row;
        }

        return $rows;
    }

    public function findUserImages($userId) {
        require '../app/bin/config.php';

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId GROUP BY I.id";

    }

}