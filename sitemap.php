
<?php
header("Content-Type: application/xml; charset=utf-8");

$base_url = "https://gurugharestate.com/";

// Static pages
$static_pages = [
    "" => ["priority" => "1.0", "changefreq" => "daily"],
    "about-us.php" => ["priority" => "0.8", "changefreq" => "monthly"],
    "contact-us.php" => ["priority" => "0.8", "changefreq" => "monthly"]
];

$projects = [];

// Try fetching dynamic project pages from DB
if (file_exists(__DIR__ . '/database/config.php')) {
    try {
        require_once __DIR__ . '/database/config.php';
        if (isset($conn) && $conn) {
            $sql = "SELECT id, created_at FROM projects ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $projects[] = $row;
                }
            }
        }
    } catch (Exception $e) {
        // Fallback gracefully without throwing database connection error
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($static_pages as $page => $info): ?>
    <url>
        <loc><?= $base_url . $page ?></loc>
        <changefreq><?= $info['changefreq'] ?></changefreq>
        <priority><?= $info['priority'] ?></priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($projects as $project): ?>
    <url>
        <loc><?= $base_url . "project-details.php?id=" . $project['id'] ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($project['created_at'])) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
</urlset>
