<?php
require_once("../settings/core.php");
require_once("../controllers/venture_controller.php");

check_login();
$user_id = get_user_id();
// User needs a venture to add a listing
$my_ventures = get_my_ventures_ctr($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Listings - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
    <div class="profile-container">
        <?php include '../view/header.php'; ?>
        
        <div class="profile-wrapper">
            <aside class="profile-sidebar">
                <div class="sidebar-menu">
                    <a href="venture.php" class="sidebar-link">My Ventures</a>
                    <a href="listing.php" class="sidebar-link active">Manage Listings</a>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-section">
                    <h2 class="section-title">Add New Listing</h2>
                    
                    <?php if (!$my_ventures): ?>
                        <div class="alert alert-danger">
                            You need to <a href="venture.php">register a venture</a> before you can post listings.
                        </div>
                    <?php else: ?>
                        <form id="listingForm" class="auth-form" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add" />
                            
                            <div class="form-group">
                                <label>Select Venture</label>
                                <select name="venture_id" class="form-input">
                                    <?php foreach ($my_ventures as $v): ?>
                                        <option value="<?php echo $v['venture_id']; ?>"><?php echo $v['venture_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Listing Title</label>
                                    <input type="text" name="title" class="form-input" placeholder="e.g. Advanced Python Tutoring" required />
                                </div>
                                <div class="form-group">
                                    <label>Price (GHS)</label>
                                    <input type="number" name="price" class="form-input" step="0.01" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-input">
                                    <option value="product">Physical Product</option>
                                    <option value="service">Service</option>
                                    <option value="mentorship">Mentorship Session</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="desc" class="form-input" rows="4" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="image" class="form-input" accept="image/*" required />
                            </div>

                            <div class="form-group">
                                <label>Keywords (Comma separated)</label>
                                <input type="text" name="keywords" class="form-input" placeholder="tech, tutoring, python" />
                            </div>

                            <button type="submit" class="btn btn-primary">Publish Listing</button>
                        </form>
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>
    <script src="../js/listing.js"></script>
</body>
</html>