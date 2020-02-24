<?php


class Image
{

    public $searchText;
    public $searchType;

    public function delete($imgId)
    {
        require '../app/bin/config.php';

        if (isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];

            $sql = "DELETE FROM images where id = ? and userId = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $imgId, $userId);
                $stmt->execute();
            }
        }
    }

    public function search()
    {
        $data = array();

        switch ($this->searchType) {
            case "description":
                $data['images'] = $this->searchByDescription($this->searchText);
                break;
            case "tags":
                $data['images'] = $this->searchByTag($this->searchText);
                break;
            case "imgName":
                $data['images'] = $this->searchByImgName($this->searchText);
                break;
        }

        return $data;
    }

    public function searchByDescription($description)
    {
        require '../app/bin/config.php';

        $rows = array();

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.description LIKE ? GROUP BY I.id";
        $searchDesc = '%' . $description . '%';


        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $searchDesc);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $rows[] = $row;
            }

        }

        return $rows;
    }

    public function searchByTag($tag)
    {
        require '../app/bin/config.php';

        $rows = array();

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE T.tag = ? GROUP BY I.id";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $tag);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $rows[] = $row;
            }

        }

        return $rows;
    }

    public function searchByImgName($imgName)
    {
        require '../app/bin/config.php';

        $rows = array();

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.imgName = ? GROUP BY I.id";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $imgName);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $rows[] = $row;
            }

        }

        return $rows;
    }

    function upload()
    {
        require '../app/bin/config.php';

        $errors = array();

        if (isset($_FILES["imageFile"]["name"])) {

            $image = $_FILES["imageFile"]["name"];
            $id = $_SESSION["id"];

            $description = isset($_POST['imageDescription']) ? $_POST["imageDescription"] : "EMPTY";

            //Tags need to have white space removed, separate by comma
            $tags = isset($_POST['imageTags']) ? $_POST["imageTags"] : "EMPTY";

            $tagArr = array_map('trim', explode(",", $tags));

            $sql = "INSERT INTO images (imgName, description, userId) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $image, $description, $id);
                $stmt->execute();

                $stmt->store_result();

                $id = $conn->insert_id;

                $target = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/' . $id . '/';

                if (!is_dir($target)) {
                    mkdir($target, 0777, true);
                }

                $target .= '/' . basename($image);
                $ret = "";
                move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target);

                $this->createTags($tagArr, $id);
            }

            // Seperate and save tags are adding image to DB, since we need to set the image ID

        }

        return $errors;
    }

    function createTags($tagsArr, $imageId)
    {
        require '../app/bin/config.php';

        foreach ($tagsArr as $tag) {
            $sql = "INSERT INTO tags (tag, imageId) VALUES (?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("si", $tag, $imageId);
                $stmt->execute();

                $stmt->store_result();
            }
        }
    }

    public function findAllImages()
    {
        require '../app/bin/config.php';

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId GROUP BY I.id";

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {

            $rows[] = $row;
        }

        return $rows;
    }

    public function findUserImages($userId)
    {
        require '../app/bin/config.php';

        $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.userId = ? GROUP BY I.id";

        $rows = array();


        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("i", $userId);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $rows[] = $row;
            }

        }


        return $rows;
    }

    public function findImageById($imgId)
    {
        require '../app/bin/config.php';

        $imageData = "";

        if (isset($_SESSION["id"])) {

            $userId = $_SESSION["id"];

            $sql = "SELECT I.*, group_concat(T.tag) FROM images I INNER JOIN tags T ON I.id = T.imageId WHERE I.id = ? AND I.userId = ? GROUP BY I.id";

            if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("ii", $imgId, $userId);
                $stmt->execute();

                $result = $stmt->get_result();

                $imageData = $result->fetch_assoc();

            }
        }

        return $imageData;
    }

    // Updates an Image, grabs data from $_POST
    public function updateImage()
    {
        require '../app/bin/config.php';

        $data = array();

        if (isset($_POST["imageDescription"]) && isset($_POST["imageTags"]) && isset($_POST["imgId"])) {
            $description = $_POST["imageDescription"];
            $id = $_POST["imgId"];

            //Tags need to have white space removed, separate by comma
            $tags = $_POST["imageTags"];

            $tagArr = array_map('trim', explode(",", $tags));

            // Delete all the tags for this Image
            $this->deleteTags($id);

            // Create new tags using the updated data
            $this->createTags($tagArr, $id);

            $sql = "UPDATE images SET description = ? WHERE id = ? ";

            if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("si", $description, $id);
                $stmt->execute();

                $stmt->store_result();

                $data['updated'] = true;
            }
        } else {
            $data['errors'] = "Data not set, please try again";
        }

        return $data;
    }

    // Only to be used within this file, in certain functions, only the owning user can delete their tags
    protected function deleteTags($imgId)
    {
        require '../app/bin/config.php';


        $sql = "DELETE FROM tags WHERE imageId = ?";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("i", $imgId);
            $stmt->execute();

            $stmt->store_result();

        }
    }
}