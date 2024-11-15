<?php
if (isset($_POST['usergroup_id'])) {
    $usergroup_id = $_POST['usergroup_id'];

    // Database connection using PDO
    try {
        $conn = new PDO("mysql:host=localhost;dbname=test", 'root', '');
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $sql = "SELECT usergroup_id FROM usergroups_permission WHERE usergroup_id = :usergroup_id";
        $stmt = $conn->prepare($sql);
        
        // Bind the usergroup_id parameter
        $stmt->bindParam(':usergroup_id', $usergroup_id, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Return the result as a JSON object
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    // Close the connection (optional, since PDO will close automatically)
    $conn = null;
}
?>
