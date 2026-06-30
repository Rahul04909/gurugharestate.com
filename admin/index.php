<?php 
include './header.php'; 

// Fetch Statistics
// Total Enquiries
$enquiry_count_query = "SELECT COUNT(*) as total FROM enquiries";
$enquiry_count_result = mysqli_query($conn, $enquiry_count_query);
$enquiry_total = mysqli_fetch_assoc($enquiry_count_result)['total'] ?? 0;

// Total Projects
$project_count_query = "SELECT COUNT(*) as total FROM projects";
$project_count_result = mysqli_query($conn, $project_count_query);
$project_total = mysqli_fetch_assoc($project_count_result)['total'] ?? 0;

// New Enquiries Today
$today_enquiry_query = "SELECT COUNT(*) as total FROM enquiries WHERE DATE(created_at) = CURDATE()";
$today_enquiry_result = mysqli_query($conn, $today_enquiry_query);
$today_enquiry_total = mysqli_fetch_assoc($today_enquiry_result)['total'] ?? 0;

// Total Callbacks
$callback_count_query = "SELECT COUNT(*) as total FROM callback_requests";
$callback_count_result = mysqli_query($conn, $callback_count_query);
$callback_total = mysqli_fetch_assoc($callback_count_result)['total'] ?? 0;

// Pending Callbacks
$pending_callback_query = "SELECT COUNT(*) as total FROM callback_requests WHERE status = 'Pending'";
$pending_callback_result = mysqli_query($conn, $pending_callback_query);
$pending_callback_total = mysqli_fetch_assoc($pending_callback_result)['total'] ?? 0;
?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo $enquiry_total; ?></h3>
                <p>Total Enquiries</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="enquiries/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo $project_total; ?></h3>
                <p>Total Projects</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="projects/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3><?php echo $today_enquiry_total; ?></h3>
                <p>Today's Enquiries</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="enquiries/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo $pending_callback_total; ?></h3>
                <p>Pending Callbacks</p>
            </div>
            <div class="icon">
                <i class="fas fa-phone-slash"></i>
            </div>
            <a href="callbacks/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?php echo $callback_total; ?></h3>
                <p>Total Callbacks</p>
            </div>
            <div class="icon">
                <i class="fas fa-phone-volume"></i>
            </div>
            <a href="callbacks/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Recent Submissions Grid -->
<div class="row mt-4">
    <!-- Left Column: Recent Enquiries -->
    <div class="col-lg-6 col-12">
        <div class="card h-100">
            <div class="card-header border-transparent">
                <h3 class="card-title">Recent Enquiries</h3>
                <div class="card-tools">
                    <a href="enquiries/index.php" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_sql = "SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5";
                            $recent_result = mysqli_query($conn, $recent_sql);
                            if ($recent_result && mysqli_num_rows($recent_result) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td><span class="badge badge-info"><?php echo htmlspecialchars($row['source']); ?></span></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center p-4'>No recent enquiries found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Recent Callback Requests -->
    <div class="col-lg-6 col-12">
        <div class="card h-100">
            <div class="card-header border-transparent">
                <h3 class="card-title">Recent Callback Requests</h3>
                <div class="card-tools">
                    <a href="callbacks/index.php" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_cb_sql = "SELECT * FROM callback_requests ORDER BY created_at DESC LIMIT 5";
                            $recent_cb_result = mysqli_query($conn, $recent_cb_sql);
                            if ($recent_cb_result && mysqli_num_rows($recent_cb_result) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_cb_result)) {
                                    $status = $row['status'];
                                    $badge_class = 'badge-warning';
                                    if ($status === 'Called') $badge_class = 'badge-success';
                                    elseif ($status === 'Spam') $badge_class = 'badge-danger';
                                    elseif ($status === 'Closed') $badge_class = 'badge-secondary';
                                    ?>
                                    <tr>
                                        <td><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td><span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center p-4'>No recent callback requests found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>