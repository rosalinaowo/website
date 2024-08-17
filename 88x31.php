<?php

function scanDirRecursive($dir, &$folders = []) {
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                // If it's a directory, recurse into it
                scanDirRecursive($filePath, $folders);
            } else {
                // If it's a file, check if it's an image
                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                    $folderName = basename($dir);
                    $folders[$folderName][] = $filePath; // Group the images by folder
                }
            }
        }
    }
}

// Function to extract the image name without the extension and path
function getFileName($filePath) {
    return pathinfo($filePath, PATHINFO_FILENAME);
}

$buttonsDir = 'images/buttons';

$folders = [];

scanDirRecursive($buttonsDir, $folders);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>88x31</title>
		<link rel="stylesheet" href="/style.css">
        <style>
            .buttons img:hover {
                transform: scale(1.3);
            }
        </style>
	</head>
	<body>
		<div class="content" style="text-align: center;">
			<h1 class="purple">88x31 button collection</h1>
		    
            <?php foreach ($folders as $folderName => $images): ?>
                <h2><?php echo $folderName; ?></h2>
                <div class="buttons">
                    <?php foreach ($images as $imagePath): ?>
                        <?php
                            $imageName = getFileName($imagePath); // Get the image name without the extension
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo $imageName; ?>" title="<?php echo $imageName; ?>">
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
		</div>
	</body>
</html>