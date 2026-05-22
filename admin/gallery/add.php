<?php 
require_once '../header.php'; 
require_once '../../database/config.php'; 

$alert_script = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_gallery'])) {
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    
    // Directory path validation & dynamic creation
    $target_dir = "../../assets/uploads/gallery/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // File Validation
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        $allowed_mimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/x-png', 'image/webp'];
        
        $file_info = pathinfo($file_name);
        $file_ext = strtolower($file_info['extension'] ?? '');
        
        // Safety checks: double-verify mime type and extension
        if (in_array($file_ext, $allowed_exts) && in_array($file_type, $allowed_mimes)) {
            // Generate clean and unique filename
            $unique_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_ext;
            $dest_path = $target_dir . $unique_name;
            
            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Insert into gallery table
                $stmt = $conn->prepare("INSERT INTO gallery (title, image_name) VALUES (?, ?)");
                $stmt->bind_param("ss", $title, $unique_name);
                
                if ($stmt->execute()) {
                    $alert_script = "
                        Swal.fire({
                            title: 'Success!',
                            text: 'Gallery image uploaded successfully.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    ";
                } else {
                    $alert_script = "Swal.fire('Database Error!', 'Failed to save gallery entry.', 'error');";
                }
                $stmt->close();
            } else {
                $alert_script = "Swal.fire('Upload Failed!', 'Failed to move uploaded file to target folder.', 'error');";
            }
        } else {
            $alert_script = "Swal.fire('Invalid File!', 'Only JPG, JPEG, PNG, and WEBP image formats are allowed.', 'error');";
        }
    } else {
        $alert_script = "Swal.fire('File Required!', 'Please select a valid image to upload.', 'warning');";
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
        <div class="card card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Add New Image to Gallery</h3>
            </div>
            
            <form action="add.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="title" class="form-label font-weight-bold">Image Title (Optional)</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter custom image title (e.g. Living Room, Exterior Front View)">
                        <small class="text-muted">Leaving this blank will display the image without a label on the frontend.</small>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="imageInput" class="form-label font-weight-bold">Select Gallery Image *</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="form-control" id="imageInput" name="image" accept="image/*" required>
                        </div>
                        <small class="text-muted d-block mb-3">Supported formats: JPG, JPEG, PNG, WEBP. Max recommended size: 5MB.</small>
                        
                        <!-- Visual Image Preview Container -->
                        <div class="card bg-light border text-center p-3" id="previewContainer" style="display: none;">
                            <p class="text-muted mb-2 font-weight-bold">Selected Image Preview</p>
                            <img id="imagePreview" src="#" alt="Upload Preview" class="img-fluid rounded mx-auto shadow-sm" style="max-height: 250px; object-fit: contain;">
                        </div>
                    </div>
                </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Cancel</a>
                    <button type="submit" name="submit_gallery" class="btn btn-success"><i class="fas fa-upload mr-1"></i> Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Dynamic frontend preview handler
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
