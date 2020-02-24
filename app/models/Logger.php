<?php


class Logger
{

    // Log function could be edited to send ERROR type logs to admin email
    public function log($logType, $logData)
    {
        require '../app/bin/config.php';

        $sql = "INSERT INTO logs (logType, logData) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $logType, $logData);
            $stmt->execute();

            echo "DONE";

            $stmt->store_result();
        }
    }

    public function getLogs() {
        require '../app/bin/config.php';

        $sql = "SELECT * FROM logs";

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {

            $rows[] = $row;
        }

        return $rows;
    }
}