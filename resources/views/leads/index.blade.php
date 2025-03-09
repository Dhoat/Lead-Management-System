<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Management System</title>

    <!-- ✅ Load CSS Files -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- ✅ Load JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .action-icons i {
            cursor: pointer;
            margin: 0 10px;
            font-size: 1.3em;
        }
        .edit { color: #007bff; }
        .update { color: #28a745; }
        .view { color: #17a2b8; }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">Lead Management System</h2>

        <!-- ✅ Filters -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="filterName" class="form-control" placeholder="Search by Name">
            </div>
            <div class="col-md-4">
                <input type="text" id="filterEmail" class="form-control" placeholder="Search by Email">
            </div>
        </div>

        <!-- ✅ Leads Table -->
        <table id="leadsTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- ✅ View Updates Modal -->
    <div class="modal fade" id="viewUpdatesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lead Updates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul id="updatesList" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Edit Lead Modal -->
    <div class="modal fade" id="editLeadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editLeadForm">
                        <input type="hidden" id="editLeadId">
                        <div class="mb-3">
                            <label for="editLeadName" class="form-label">Name</label>
                            <input type="text" id="editLeadName" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editLeadDescription" class="form-label">Description</label>
                            <textarea id="editLeadDescription" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isAdmin = "admin"; // ✅ Set admin access manually

        $(document).ready(function () {
            var table = $('#leadsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('leads.data') }}',
                    type: 'GET',
                    data: function (d) {
                        d.search_name = $('#filterName').val();
                        d.search_email = $('#filterEmail').val();
                    }
                },
                pageLength: 20,
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'status', name: 'status' },
                    { data: 'source', name: 'source' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false,
                        render: function (data, type, row) {
                            let editButton = isAdmin === "admin" ? `<i class="fa-solid fa-pen-to-square edit" onclick="openEditModal(${row.id}, '${row.name}', '${row.description}')"></i>` : '';
                            let updateButton = isAdmin === "admin" ? `<i class="fa-solid fa-phone update" onclick="postUpdate(${row.id})"></i>` : '';
                            let viewButton = `<i class="fa-solid fa-eye view" onclick="viewUpdates(${row.id})"></i>`;
                            return `<span class="action-icons">${editButton} ${updateButton} ${viewButton}</span>`;
                        }
                    }
                ]
            });

            $('#filterName, #filterEmail').on('keyup change', function () {
                table.ajax.reload();
            });
        });

        function openEditModal(id, name, description) {
            $('#editLeadId').val(id);
            $('#editLeadName').val(name);
            $('#editLeadDescription').val(description);
            $('#editLeadModal').modal('show');
        }

        function postUpdate(id) {
            alert('Post Update for Lead ID: ' + id);
        }

        function viewUpdates(id) {
            console.log("Fetching updates for Lead ID:", id);
            $('#updatesList').html('<li class="list-group-item">Loading...</li>');
            $('#viewUpdatesModal').modal('show');

            $.ajax({
                url: '/leads/view-updates/' + id,
                type: 'GET',
                success: function (data) {
                    let updatesHtml = '';
                    if (data.length > 0) {
                        data.forEach(update => {
                            updatesHtml += `<li class="list-group-item"><strong>${update.user}</strong>: ${update.lead_message} <br><small>${update.created_at}</small></li>`;
                        });
                    } else {
                        updatesHtml = '<li class="list-group-item">No updates available</li>';
                    }
                    $('#updatesList').html(updatesHtml);
                },
                error: function () {
                    $('#updatesList').html('<li class="list-group-item text-danger">Failed to load updates</li>');
                }
            });
        }
    </script>

</body>
</html>
