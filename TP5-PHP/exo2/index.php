<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
</head>
<body>

<!-- Table HTML -->
<table id="usersTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- Modal for editing users -->
<div id="editModal" style="display:none; position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); background:white; padding:20px;">
    <h2>Edit User</h2>
    <form id="editForm">
        <input type="hidden" id="userId" name="userId">
        Name: <input type="text" id="userName" name="userName"><br><br>
        Email: <input type="text" id="userEmail" name="userEmail"><br><br>
        <input type="button" value="Save" onclick="saveEdit()">
        <input type="button" value="Cancel" onclick="closeEdit()">
    </form>
</div>

<script>
$(document).ready(function() {
    const table = $('#usersTable').DataTable({
        "ajax": {
            "url": "http://localhost/IDAW/TP4-PHP/exo5/users.php",
            "dataSrc": "users"  // Utilisation de la clé "users" comme source de données
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `<button onclick="editUser(${data.id})">Edit</button> <button onclick="deleteUser(${data.id})">Delete</button>`;
                }
            }
        ]
    });

    window.editUser = function(id, name, email) {
        document.getElementById("userId").value = id;
        document.getElementById("userName").value = name;
        document.getElementById("userEmail").value = email;
        document.getElementById("editModal").style.display = "block";
    };

    window.deleteUser = function(id) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: `http://localhost/IDAW/TP4-PHP/exo5/users.php/${id}`,
                type: 'DELETE',
                success: function() {
                    table.ajax.reload();
                },
                error: function() {
                    alert('Failed to delete user.');
                }
            });
        }
    };

    window.closeEdit = function() {
        document.getElementById("editModal").style.display = "none";
    };

    window.saveEdit = function() {
        // Implement your logic for saving edited user data using AJAX here.
        // Once data is successfully saved, close the modal and refresh the table.
    };
});
</script>

</body>
</html>