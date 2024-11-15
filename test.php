<?php
// Fetch the group ID and WP (work parameter) from the request
//$groupId = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$groupId = 1;


// Initialize the connection (replace with your actual connection details)
$connection = new mysqli("localhost", "root", "", "test");

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch pages from the pages_master table
$sql = "SELECT `page_id`, `page_name`, `is_parent`, `parent_id` FROM `pages_master`";
$result = $connection->query($sql);
$pages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pages[] = $row;
    }
}

// Function to generate checkboxes with proper naming for permissions
function generate_checkbox($page_id, $permission_type) {
    return '
        <label class="checkbox">
            <input type="checkbox" name="permissions[' . $page_id . '][' . $permission_type . ']" value="1">
            <span class="checkmark"></span>
        </label>';
}

// HTML Form begins
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<form class="form" name="Form1" method="POST" action="./editusergroups.php" onSubmit="return check();">
    <div class="card-body">
        <input type="hidden" name="id" value="<?php echo $groupId; ?>">
      

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Group Name: <span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded" name="category_name" placeholder="Enter group name" size="59" value="" maxlength="96">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table class="table table-bordered table-checkable dataTable no-footer dtr-inline" id="kt_datatable" style="margin-top: 13px !important; width: 100%;" role="grid">
                        <thead>
                            <tr>
                                <th>Page Name</th>
                                <th><b>View</b></th>
                                <th><b>Add</b></th>
                                <th><b>Edit</b></th>
                                <th><b>Delete</b></th>
                                <th><b>Select All</b></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($pages as $page) {
                            if ($page['is_parent'] == 0) { // Parent Page
                                ?>
                                <tr class="group">
                                    <td><?php echo $page['page_name']; ?></td>
                                    <td><?php echo generate_checkbox($page['page_id'], 'view'); ?></td>
                                    <td><?php echo generate_checkbox($page['page_id'], 'add'); ?></td>
                                    <td><?php echo generate_checkbox($page['page_id'], 'edit'); ?></td>
                                    <td><?php echo generate_checkbox($page['page_id'], 'delete'); ?></td>
                                    <td>
                                        <label class="checkbox">
                                            <input type="checkbox" class="selectall" data-id="<?php echo $page['page_id']; ?>">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php
                                // Child Pages under Parent
                                foreach ($pages as $child) {
                                    if ($child['is_parent'] != 0 && $child['parent_id'] == $page['page_id']) {
                                        ?>
                                        <tr class="child">
                                            <td>— <?php echo $child['page_name']; ?></td>
                                            <td><?php echo generate_checkbox($child['page_id'], 'view'); ?></td>
                                            <td><?php echo generate_checkbox($child['page_id'], 'add'); ?></td>
                                            <td><?php echo generate_checkbox($child['page_id'], 'edit'); ?></td>
                                            <td><?php echo generate_checkbox($child['page_id'], 'delete'); ?></td>
                                            <td>
                                                <label class="checkbox">
                                                    <input type="checkbox" class="selectall" data-id="<?php echo $child['page_id']; ?>">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button name="submit" type="submit" class="btn btn-primary" value="Update">Update</button>
                <input name="B3" type="button" class="btn btn-secondary mr-2" onClick="javascript:window.location.href='./usergroups.php?wp=<?php echo $wp; ?>';" value="Back">
            </div>
        </div>
    </div>
</form>

<?php
// Handle form submission for updating user group permissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['id'];
    $permissions = $_POST['permissions'];

    // Process each permission for each page
    foreach ($permissions as $page_id => $permission) {
        $view = isset($permission['view']) ? 1 : 0;
        $add = isset($permission['add']) ? 1 : 0;
        $edit = isset($permission['edit']) ? 1 : 0;
        $delete = isset($permission['delete']) ? 1 : 0;

        // Update the permissions in the database (SQL to be tailored to your schema)
        $update_sql = "UPDATE `user_group_permissions` 
                       SET `view` = ?, `add` = ?, `edit` = ?, `delete` = ? 
                       WHERE `group_id` = ? AND `page_id` = ?";
        $stmt = $connection->prepare($update_sql);
        $stmt->bind_param('iiiiii', $view, $add, $edit, $delete, $group_id, $page_id);
        $stmt->execute();
    }

    // Redirect after submission
    header("Location: ./usergroups.php?wp=$wp");
}

$connection->close();
?>
</body>
</html>