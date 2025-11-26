<?php
// classes/file_handler_class.php
require_once(__DIR__ . "/../settings/core.php");

class FileHandler {

    // Allowed file types
    private $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    // Max size (e.g., 5MB)
    private $max_size = 5 * 1024 * 1024;
    
    /**
     * Upload a file securely
     * @param array $file The $_FILES['input_name'] array
     * @param string $subfolder Optional subfolder (e.g., 'events', 'listings')
     * @return array ['status' => bool, 'message' => string, 'path' => string]
     */
    public function upload_file($file, $subfolder = 'misc') {
        
        // 1. Basic Error Check
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'message' => 'Upload error code: ' . $file['error']];
        }

        // 2. Check File Size
        if ($file['size'] > $this->max_size) {
            return ['status' => false, 'message' => 'File too large. Max 5MB.'];
        }

        // 3. Security: Check Extension & MIME Type
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

        if (!in_array($file_ext, $this->allowed_types) || !in_array($mime_type, $allowed_mimes)) {
            return ['status' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, PDF allowed.'];
        }

        // 4. Construct Target Path (Week 6 Requirement: Organized folders)
        // Structure: ../uploads/{user_id}/{subfolder}/
        $user_id = get_user_id() ?? 'guest';
        $target_dir = __DIR__ . "/../uploads/u{$user_id}/{$subfolder}/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // 5. Sanitize Filename (Prevent directory traversal)
        $safe_name = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', basename($file['name']));
        // Add timestamp to prevent overwrites
        $final_name = time() . "_" . $safe_name;
        $target_path = $target_dir . $final_name;

        // 6. Move File
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Return the relative path for database storage
            $db_path = "uploads/u{$user_id}/{$subfolder}/" . $final_name;
            return ['status' => true, 'message' => 'File uploaded successfully', 'path' => $db_path];
        } else {
            return ['status' => false, 'message' => 'Failed to move uploaded file.'];
        }
    }

    /**
     * List all files for the current user (For the View)
     */
    public function get_user_files() {
        $user_id = get_user_id();
        $dir = __DIR__ . "/../uploads/u{$user_id}/";
        $files = [];

        if (is_dir($dir)) {
            // Recursive iterator to find files in subfolders
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    // Convert full server path to relative web path
                    $path = str_replace('\\', '/', $file->getPathname());
                    $web_path = strstr($path, 'uploads/');
                    $files[] = [
                        'name' => $file->getFilename(),
                        'path' => "../" . $web_path,
                        'size' => $file->getSize(),
                        'date' => date("Y-m-d H:i:s", $file->getMTime())
                    ];
                }
            }
        }
        return $files;
    }
}
?>