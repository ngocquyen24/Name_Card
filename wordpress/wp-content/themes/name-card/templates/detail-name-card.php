<?php

/**
 * Template Name: Detail Name User
 * Description: A template to display user details.
 */

// Tải WordPress header
wp_head();


$GLOBALS['custom_user'] = $user;


if (!$user) {
    echo '<p>Không tìm thấy người dùng!ffff</p>';
    
    exit;
}

if ($user) :
?>

    <div class="profile-container mt-3">
        <div class="profile-header">
            <div class="avatar">
                <img src="<?php echo esc_url(wp_upload_dir()['baseurl'] . '/imagesUser/' . $user->image); ?>" alt="User Avatar">
            </div>
            <h1><?php echo esc_html($user->name); ?></h1>
            <p><?php echo esc_html($user->jobtitle); ?></p>
        </div>
        <div class="profile-details">
            <div class="detail-row">
                <span class="label">Email</span>
                <span class="value"><?php echo esc_html($user->email); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Phone</span>
                <span class="value"><?php echo esc_html($user->phone); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Job Name</span>
                <span class="value"><?php echo esc_html($user->jobname); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Birthday</span>
                <span class="value"><?php echo esc_html($user->birthdate); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Address</span>
                <span class="value"><?php echo esc_html($user->address); ?></span>
            </div>
        </div>
    </div>

<?php else : ?>
    <p>Không tìm thấy thông tin người dùng!</p>
<?php endif; ?>