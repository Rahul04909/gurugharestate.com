<?php 
require_once '../header.php'; 
require_once '../../database/config.php';

// Dynamic self-healing database initialization
$conn->query("CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) DEFAULT NULL,
    image_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $stmt = $conn->prepare("SELECT image_name FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $item = $res->fetch_assoc();
        $image_name = $item['image_name'];
        
        // Delete image file safely
        $filepath = '../../assets/uploads/gallery/' . $image_name;
        if (!empty($image_name) && file_exists($filepath)) {
            unlink($filepath);
        }

        // Delete record from database
        $del_stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $del_stmt->bind_param("i", $delete_id);
        if ($del_stmt->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Gallery image has been deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => { 
                    window.location.href = 'index.php'; 
                });
            </script>";
        }
    }
}

// Fetch all gallery items
$gallery_items = $conn->query("SELECT id, title, image_name, created_at FROM gallery ORDER BY id DESC");
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-images mr-2"></i>Manage Gallery</h3>
                <a href="add.php" class="btn btn-sm btn-primary ml-auto"><i class="fas fa-plus"></i> Add New Image</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">ID</th>
                                <th style="width: 120px" class="text-center">Image</th>
                                <th>Title</th>
                                <th style="width: 180px">Created At</th>
                                <th style="width: 150px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($gallery_items->num_rows > 0): ?>
                                <?php while($row = $gallery_items->fetch_assoc()): ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center">
                                            <?php if(!empty($row['image_name'])): ?>
                                                <img src="../../assets/uploads/gallery/<?= htmlspecialchars($row['image_name']) ?>" 
                                                     alt="<?= htmlspecialchars($row['title'] ?? 'Gallery Image') ?>" 
                                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                            <?php else: ?>
                                                <span class="text-muted">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($row['title'] ?: 'Untitled') ?></strong>
                                        </td>
                                        <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                        <td class="text-center">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="javascript:void(0)" onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-image fa-3x mb-3 d-block text-gray-300"></i>
                                        No images uploaded in the gallery yet. Click "Add New Image" to start.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This image will be permanently deleted from the database and storage!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?delete_id=' + id;
        }
    })
}
</script>

<?php require_once '../footer.php'; ?>
