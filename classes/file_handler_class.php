<?php
// classes/file_handler_class.php
require_once(__DIR__ . "/../settings/core.php");

class FileHandler {

    private $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    private $max_size = 5 * 1024 * 1024; // 5MB
    
    public function upload_file($file, $subfolder = 'misc') {
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'message' => 'Upload error code: ' . $file['error']];
        }

        if ($file['size'] > $this->max_size) {
            return ['status' => false, 'message' => 'File too large. Max 5MB.'];
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

        if (!in_array($file_ext, $this->allowed_types) || !in_array($mime_type, $allowed_mimes)) {
            return ['status' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, PDF allowed.'];
        }

        $user_id = get_user_id() ?? 'guest';
        // Use realpath to ensure consistent directory separators
        $base_dir = __DIR__ . "/../uploads/u{$user_id}/{$subfolder}/";

        if (!is_dir($base_dir)) {
            mkdir($base_dir, 0755, true);
        }

        $safe_name = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', basename($file['name']));
        $final_name = time() . "_" . $safe_name;
        $target_path = $base_dir . $final_name;

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Return relative path for database/usage
            $db_path = "uploads/u{$user_id}/{$subfolder}/" . $final_name;
            return ['status' => true, 'message' => 'File uploaded successfully', 'path' => $db_path];
        } else {
            return ['status' => false, 'message' => 'Failed to move uploaded file.'];
        }
    }

    /**
     * List all files for the current user
     */
    public function get_user_files() {
        $user_id = get_user_id();
        $base_path = __DIR__ . "/../uploads/u{$user_id}/";
        
        // Normalize slashes for comparison
        $base_path = str_replace('\\', '/', realpath($base_path));
        
        $files = [];

        if (is_dir($base_path)) {
            // Use Recursive Directory Iterator
            $directory = new RecursiveDirectoryIterator($base_path, RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new RecursiveIteratorIterator($directory);

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    // Normalize file path
                    $full_path = str_replace('\\', '/', $file->getPathname());
                    
                    // Generate relative path by stripping the base directory
                    // Result: "subfolder/filename.jpg"
                    $relative_segment = str_replace($base_path . '/', '', $full_path);
                    
                    // Construct the web-accessible path
                    // Needs "../uploads/uID/" prefix to work from the Admin folder
                    $web_path = "../uploads/u{$user_id}/" . $relative_segment;

                    $files[] = [
                        'name' => $file->getFilename(),
                        'path' => $web_path,
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