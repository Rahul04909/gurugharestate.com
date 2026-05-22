<?php 
require_once '../header.php'; 
require_once '../../database/config.php'; 

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$alert_script = '';

// Fetch active gallery item details
$stmt = $conn->prepare("SELECT id, title, image_name FROM gallery WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$gallery_item = $res->fetch_assoc();

if (!$gallery_item) {
    echo "<script>
        $(document).ready(function() {
            Swal.fire('Not Found!', 'Gallery image not found.', 'error').then(() => {
                window.location.href = 'index.php';
            });
        });
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_gallery'])) {
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $target_dir = "../../assets/uploads/gallery/";
    
    // Check if new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        $allowed_mimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/x-png', 'image/webp'];
        
        $file_info = pathinfo($file_name);
        $file_ext = strtolower($file_info['extension'] ?? '');
        
        if (in_array($file_ext, $allowed_exts) && in_array($file_type, $allowed_mimes)) {
            // Generate unique filename
            $unique_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_ext;
            $dest_path = $target_dir . $unique_name;
            
            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Delete previous file from storage
                $old_file = $gallery_item['image_name'];
                if (!empty($old_file) && file_exists($target_dir . $old_file)) {
                    unlink($target_dir . $old_file);
                }
                
                // Update table with new image
                $update_stmt = $conn->prepare("UPDATE gallery SET title = ?, image_name = ? WHERE id = ?");
                $update_stmt->bind_param("ssi", $title, $unique_name, $id);
                
                if ($update_stmt->execute()) {
                    $alert_script = "
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Gallery image and details updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    ";
                } else {
                    $alert_script = "Swal.fire('Database Error!', 'Failed to update database record.', 'error');";
                }
                $update_stmt->close();
            } else {
                $alert_script = "Swal.fire('Upload Failed!', 'Failed to save new image to target folder.', 'error');";
            }
        } else {
            $alert_script = "Swal.fire('Invalid File!', 'Only JPG, JPEG, PNG, and WEBP formats are allowed.', 'error');";
        }
    } else {
        // Only update title if no new image is provided
        $update_stmt = $conn->prepare("UPDATE gallery SET title = ? WHERE id = ?");
        $update_stmt->bind_param("si", $title, $id);
        
        if ($update_stmt->execute()) {
            $alert_script = "
                Swal.fire({
                    title: 'Updated!',
                    text: 'Gallery item title updated successfully.',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            ";
        } else {
            $alert_script = "Swal.fire('Database Error!', 'Failed to update item title in database.', 'error');";
        }
        $update_stmt->close();
    }
}
?>

<?php if (!empty($alert_script)): ?>
    <script>
        $(document).ready(function() {
            <?= $alert_script ?>
        });
    </script>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 col-md-10 col-12 mx-auto">
        <div class="card card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Gallery Item: <?= htmlspecialchars($gallery_item['title'] ?: 'Untitled') ?></h3>
            </div>
            
            <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="title" class="form-label font-weight-bold">Image Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($gallery_item['title'] ?? '') ?>" placeholder="Enter custom image title (e.g. Living Room, Exterior Front View)">
                        <small class="text-muted">Leaving this blank will display the image without a label on the frontend.</small>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label font-weight-bold d-block">Current Gallery Image</label>
                        <div class="mb-3">
                            <img src="../../assets/uploads/gallery/<?= htmlspecialchars($gallery_item['image_name']) ?>" 
                                 alt="Current Thumbnail" 
                                 class="img-thumbnail shadow-sm" 
                                 style="max-height: 180px; object-fit: cover;">
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="imageInput" class="form-label font-weight-bold">Swap Image (Optional)</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="form-control" id="imageInput" name="image" accept="image/*">
                        </div>
                        <small class="text-muted d-block mb-3">Leave blank to keep the current active image. Supported formats: JPG, JPEG, PNG, WEBP.</small>
                        
                        <!-- Visual Image Replacement Preview -->
                        <div class="card bg-light border text-center p-3" id="previewContainer" style="display: none;">
                            <p class="text-muted mb-2 font-weight-bold">Replacement Image Preview</p>
                            <img id="imagePreview" src="#" alt="Replacement Preview" class="img-fluid rounded mx-auto shadow-sm" style="max-height: 200px; object-fit: contain;">
                        </div>
                    </div>
                </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Cancel</a>
                    <button type="submit" name="submit_gallery" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Dynamic file change preview handler
    $('#imageInput').on('change', function() {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#previewContainer').slideDown(200);
            }
            
            reader.readAsDataURL(file);
        } else {
            $('#previewContainer').slideUp(200);
        }
    });
});
</script>

<?php require_once '../footer.php'; ?>
