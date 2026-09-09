<?php
// =========================================================
//  HYKE directory index
//  HYKE directory index — dark file list for http://localhost/HYKE/
date_default_timezone_set('Asia/Manila');
//  (This is a dev-only helper page. It is NOT one of the panels.)
// =========================================================

$dir = __DIR__;
$title = 'Index of ' . $dir . '\\';

// Gather real files in this folder (skip this script itself)
$files = array();
foreach (scandir($dir) as $entry) {
    if ($entry === '.' || $entry === '..' || $entry === basename(__FILE__)) {
        continue;
    }
    $path = $dir . DIRECTORY_SEPARATOR . $entry;
    if (is_file($path)) {
        $files[] = array(
            'name'  => $entry,
            'size'  => filesize($path),
            'mtime' => filemtime($path),
        );
    }
}

// Alphabetical, case-insensitive (like the screenshot)
usort($files, function ($a, $b) {
    return strcasecmp($a['name'], $b['name']);
});

// Nicely formatted size: 38.0 kB / 1.2 MB
function hsize($bytes) {
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 1) . ' MB';
    }
    return number_format($bytes / 1024, 1) . ' kB';
}

// Date like the screenshot: 9/9/26, 4:28:06 PM
function hdate($ts) {
    return date('n/j/y, g:i:s A', $ts);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        body {
            background: #1b1b1b;
            color: #e8e8e8;
            font-family: "Times New Roman", Georgia, serif;
            margin: 24px 30px;
        }

        h1 {
            font-size: 34px;
            font-weight: bold;
            margin: 16px 0 28px;
        }

        .parent {
            font-size: 17px;
            margin: 0 0 20px;
        }

        table {
            border-collapse: collapse;
        }

        th {
            font-size: 17px;
            text-align: left;
            padding: 4px 30px 10px 0;
        }

        th.num { text-align: right; }

        td {
            font-size: 15px;
            padding: 5px 30px 5px 0;
        }

        td.name a {
            color: #7aa7ff;
            text-decoration: none;
        }

        td.name a:visited { color: #b48cf2; }
        td.name a:hover { text-decoration: underline; }

        td.size {
            color: #d6d6d6;
            text-align: right;
        }

        td.date { color: #d6d6d6; }
    </style>
</head>
<body>

    <h1><?php echo htmlspecialchars($title); ?></h1>

    <p class="parent">&#128193; <a href="../">[parent directory]</a></p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th class="num">Size</th>
                <th>Date Modified</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $f): ?>
            <tr>
                <td class="name">&#128196; <a href="<?php echo rawurlencode($f['name']); ?>"><?php echo htmlspecialchars($f['name']); ?></a></td>
                <td class="size"><?php echo hsize($f['size']); ?></td>
                <td class="date"><?php echo hdate($f['mtime']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
