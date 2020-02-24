<?php


class Image
{

    public $searchText;
    public $searchType;

    public function delete($imgId)
    {
        require '../app/bin/config.php';

        if(isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];

            $sql = "DELETE FROM images where id = ? and userId = ?";

            if($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $imgId, $userId);
                $stmt->execute();
            }
        }
    }

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

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.userId = ? GROUP BY I.id";

        $rows = array();


        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("i", $userId);
            $stmt->execute();

            $result = $stmt->get_result();

            while($row = $result->fetch_assoc())
            {

                $rows[] = $row;
            }

        }


        return $rows;
    }

    public function findImageById($imgId) {
        require '../app/bin/config.php';

        $imageData = "";

        if(isset($_SESSION["id"])) {

            $userId = $_SESSION["id"];

            $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.id = ? AND I.userId = ? GROUP BY I.id";

            if($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("ii", $imgId, $userId);
                $stmt->execute();

                $result = $stmt->get_result();

                $imageData = $result->fetch_assoc();

            }
        }

        return $imageData;
    }

}