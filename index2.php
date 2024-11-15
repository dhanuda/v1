<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Group</title>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include any additional CSS/JS libraries if needed -->
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
    </style>
</head>
<body>

<h2>User Groups</h2>

<!-- Table with existing user groups -->
<table border="1">
    <thead>
        <tr>
            <th>User Group ID</th>
            <th>User Group Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Example rows -->
        <tr>
            <td>1</td>
            <td>Admin</td>
            <td><button onclick="openModal(1)">Edit</button></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Editor</td>
            <td><button onclick="openModal(2)">Edit</button></td>
        </tr>
        <!-- Populate from your database dynamically -->
    </tbody>
</table>

<!-- Modal for editing user group -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h4>Edit User Group</h4>
        <form id="editForm">
            <input type="hidden" id="usergroup_id" name="usergroup_id">
            <label for="usergroup_name">User Group Name</label>
            <input type="text" id="usergroup_name" name="usergroup_name" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<script>
    // Open modal and fetch user group data
    function openModal(usergroup_id) {
		alert('hello');
        $.ajax({
            url: 'fetch_usergroup.php',
            type: 'POST',
            data: { usergroup_id: usergroup_id },
            success: function(response) {
                var data = JSON.parse(response);
                $('#usergroup_id').val(data.usergroup_id);
                $('#usergroup_name').val(data.user_group_name);
                $('#editModal').show(); // Show the modal
            }
        });
    }

    // Handle form submission
    $('#editForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'copy_usergroup.php',
            type: 'POST',
            data: $(this).serialize(), // Send form data
            success: function(response) {
                if (response == 'success') {
                    alert('User group copied and inserted successfully!');
                    location.reload(); // Reload to see the changes
                } else {
                    alert('Failed to copy user group');
                }
            }
        });
    });

    // Close modal on click outside of modal content
    $(window).on('click', function(event) {
        if ($(event.target).is('#editModal')) {
            $('#editModal').hide();
        }
    });
</script>

</body>
</html>
