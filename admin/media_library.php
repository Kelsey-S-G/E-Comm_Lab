<?php
require_once("../settings/core.php");
require_once("../classes/file_handler_class.php");

check_login();

$handler = new FileHandler();
$my_files = $handler->get_user_files();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Media Library - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
    <style>
        /* Simple Grid for Media */
        .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 2rem; }
        .media-item { border: 1px solid var(--color-border); border-radius: 8px; overflow: hidden; background: var(--color-surface-elevated); transition: transform 0.2s; }
        .media-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-level-2); }
        .media-preview { width: 100%; height: 120px; object-fit: cover; background: #eee; }
        .media-info { padding: 0.5rem; font-size: 0.8rem; color: var(--color-on-surface); }
        .media-name { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: bold; display: block; }
        .upload-zone { border: 2px dashed var(--color-primary); padding: 2rem; text-align: center; border-radius: 12px; background: rgba(45, 108, 223, 0.05); cursor: pointer; transition: background 0.3s; }
        .upload-zone:hover { background: rgba(45, 108, 223, 0.1); }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; ?>
        
        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="venture.php" class="sidebar-link">My Ventures</a>
                    <a href="listing.php" class="sidebar-link">Manage Listings</a>
                    <a href="media_library.php" class="sidebar-link active">Media Library</a>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Media Library</h2>
                    <p class="section-content">Manage images for your ventures, listings, and events.</p>

                    <!-- Upload Area -->
                    <div class="upload-zone" id="dropZone">
                        <p>Drag & Drop files here or click to upload</p>
                        <form id="uploadForm" style="display:none;">
                            <input type="file" id="fileInput" name="uploadedFile" accept="image/*,application/pdf">
                            <input type="hidden" name="category" value="general">
                        </form>
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById('fileInput').click()">Select File</button>
                        <div id="uploadStatus" style="margin-top: 10px; font-size: 0.9rem;"></div>
                    </div>

                    <!-- File Grid -->
                    <div class="media-grid">
                        <?php if (!empty($my_files)): ?>
                            <?php foreach ($my_files as $file): ?>
                                <div class="media-item">
                                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file['name'])): ?>
                                        <img src="<?php echo $file['path']; ?>" class="media-preview" alt="File">
                                    <?php else: ?>
                                        <div class="media-preview" style="display:flex;align-items:center;justify-content:center;font-size:2rem;">📄</div>
                                    <?php endif; ?>
                                    
                                    <div class="media-info">
                                        <span class="media-name" title="<?php echo $file['name']; ?>"><?php echo $file['name']; ?></span>
                                        <span style="color:var(--color-on-surface-secondary);">
                                            <?php echo round($file['size']/1024, 1); ?> KB
                                        </span>
                                        <a href="<?php echo $file['path']; ?>" target="_blank" style="float:right; color:var(--color-primary); text-decoration:none;">View</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="grid-column: 1/-1; text-align: center; margin-top: 2rem;">No files uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        // Simple JS to handle the upload
        const fileInput = document.getElementById('fileInput');
        const statusDiv = document.getElementById('uploadStatus');

        fileInput.addEventListener('change', function() {
            if (this.files.length === 0) return;

            const formData = new FormData(document.getElementById('uploadForm'));
            statusDiv.textContent = "Uploading...";
            statusDiv.style.color = "var(--color-on-surface)";

            fetch('../actions/upload_action.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    statusDiv.textContent = "Upload Successful!";
                    statusDiv.style.color = "green";
                    setTimeout(() => location.reload(), 1000); // Refresh to show new file
                } else {
                    statusDiv.textContent = "Error: " + data.message;
                    statusDiv.style.color = "red";
                }
            })
            .catch(err => {
                console.error(err);
                statusDiv.textContent = "Upload failed due to network error.";
                statusDiv.style.color = "red";
            });
        });
    </script>
</body>
</html>