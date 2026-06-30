<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../../database/config.php';

// Handle AJAX status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    header('Content-Type: application/json');
    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($conn, trim($_POST['status']));
    
    $valid_statuses = ['Pending', 'Called', 'Spam', 'Closed'];
    if (!in_array($status, $valid_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
        exit;
    }
    
    $update_query = "UPDATE callback_requests SET status = '$status' WHERE id = $id";
    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status: ' . mysqli_error($conn)]);
    }
    exit;
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delete_query = "DELETE FROM callback_requests WHERE id = $id";
    mysqli_query($conn, $delete_query);
    header("Location: index.php?msg=deleted");
    exit;
}

// Get filter status from query parameters
$filter_status = isset($_GET['status']) ? trim($_GET['status']) : 'All';
$valid_filters = ['Pending', 'Called', 'Spam', 'Closed'];

// Count total pending callbacks
$pending_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM callback_requests WHERE status = 'Pending'");
$pending_count = mysqli_fetch_assoc($pending_count_res)['total'] ?? 0;
?>

<?php include '../header.php'; ?>

<!-- Custom Styles specific to Callbacks -->
<style>
    .table-responsive { overflow-x: auto; }
    .status-select-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        font-weight: 600;
        width: auto;
        display: inline-block;
    }
    .status-Pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .status-Called { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-Spam { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .status-Closed { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
    
    .nav-tabs-custom {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #495057;
        font-weight: 500;
        padding: 10px 20px;
    }
    .nav-tabs-custom .nav-link.active {
        border-bottom: 3px solid #28a745;
        color: #28a745;
        background: transparent;
        font-weight: bold;
    }
    .phone-link {
        color: #302f35;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .phone-link:hover {
        color: #d4af37;
    }
</style>

<!-- Alert messages -->
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Callback request deleted successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Tabs Navigation for Filters -->
<ul class="nav nav-tabs nav-tabs-custom">
    <li class="nav-item">
        <a class="nav-link <?= $filter_status === 'All' ? 'active' : '' ?>" href="index.php?status=All">
            All Callbacks
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $filter_status === 'Pending' ? 'active' : '' ?>" href="index.php?status=Pending">
            Pending <span class="badge badge-warning ml-1"><?= $pending_count ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $filter_status === 'Called' ? 'active' : '' ?>" href="index.php?status=Called">
            Called
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $filter_status === 'Closed' ? 'active' : '' ?>" href="index.php?status=Closed">
            Closed
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $filter_status === 'Spam' ? 'active' : '' ?>" href="index.php?status=Spam">
            Spam
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Callback Requests (<?= htmlspecialchars($filter_status) ?>)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-bordered mb-0">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th width="180">Date & Time</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th width="150">Status</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Build query based on filter
                if (in_array($filter_status, $valid_filters)) {
                    $sql = "SELECT * FROM callback_requests WHERE status = '$filter_status' ORDER BY id DESC";
                } else {
                    $sql = "SELECT * FROM callback_requests ORDER BY id DESC";
                }
                
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $date = date('d M Y, h:i A', strtotime($row['created_at']));
                        $name = htmlspecialchars($row['name']);
                        $phone = htmlspecialchars($row['phone']);
                        $status = htmlspecialchars($row['status']);
                        
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$date}</td>";
                        echo "<td><strong>{$name}</strong></td>";
                        echo "<td>
                                <a href='tel:{$phone}' class='phone-link' title='Click to dial'>
                                    <i class='fas fa-phone-alt text-muted mr-1'></i> {$phone}
                                </a>
                              </td>";
                        
                        // Inline Status Selector
                        echo "<td>
                                <select class='form-select form-select-sm status-select-sm status-{$status} status-selector' data-id='{$id}'>
                                    <option value='Pending' " . ($status === 'Pending' ? 'selected' : '') . ">Pending</option>
                                    <option value='Called' " . ($status === 'Called' ? 'selected' : '') . ">Called</option>
                                    <option value='Closed' " . ($status === 'Closed' ? 'selected' : '') . ">Closed</option>
                                    <option value='Spam' " . ($status === 'Spam' ? 'selected' : '') . ">Spam</option>
                                </select>
                              </td>";
                        
                        // Delete Action Button
                        echo "<td>
                                <a href='#' onclick='confirmDelete({$id})' class='btn btn-danger btn-sm' title='Delete Request'>
                                    <i class='fas fa-trash'></i> Delete
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center p-4'>No callback requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../footer.php'; ?>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?delete=' + id;
            }
        });
    }

    $(document).ready(function() {
        // Handle inline status change
        $('.status-selector').change(function() {
            const selectEl = $(this);
            const id = selectEl.data('id');
            const newStatus = selectEl.val();
            
            // Temporary loading visual indicator
            selectEl.prop('disabled', true);
            
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: {
                    action: 'update_status',
                    id: id,
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    selectEl.prop('disabled', false);
                    if (response.success) {
                        // Change background color class to match the selected status
                        selectEl.removeClass('status-Pending status-Called status-Closed status-Spam');
                        selectEl.addClass('status-' + newStatus);
                        
                        // Toast success notification
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                        // Reload to revert state on failure
                        location.reload();
                    }
                },
                error: function() {
                    selectEl.prop('disabled', false);
                    Swal.fire('Error', 'An error occurred while updating status. Please try again.', 'error');
                    location.reload();
                }
            });
        });
    });
</script>
