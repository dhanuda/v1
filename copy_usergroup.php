<?php
if (isset($_POST['usergroup_id']) && isset($_POST['usergroup_name'])) {
    $usergroup_id = $_POST['usergroup_id']; // Existing user group ID
    $usergroup_name = $_POST['usergroup_name']; // New user group name

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'test');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 1: Insert new user group into the `usergroups` table (with the new group name)
    $sql1 = "INSERT INTO usergroups (groupname) VALUES (?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $usergroup_name);

    if ($stmt1->execute()) {
        // Step 2: Get the last inserted `id` in the `usergroups` table
        $new_usergroup_id = $stmt1->insert_id;

        // Step 3: Copy data from the existing user group (`usergroups_permission`) and insert it with the new `usergroup_id`
        $sql2 = "INSERT INTO usergroups_permission (usergroup_id, page_id, access_view, access_add, access_edit, access_delete)
                 SELECT ?, page_id, access_view, access_add, access_edit, access_delete
                 FROM usergroups_permission WHERE usergroup_id = ?";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $new_usergroup_id, $usergroup_id);

        if ($stmt2->execute()) {
            echo 'Success: Data copied with new user group ID!';
        } else {
            echo 'Error: Unable to copy usergroup_permission data';
        }

        $stmt2->close();
    } else {
        echo 'Error: Unable to insert new group into usergroups table';
    }

    // Close statements and connection
    $stmt1->close();
    $conn->close();
}
?>
