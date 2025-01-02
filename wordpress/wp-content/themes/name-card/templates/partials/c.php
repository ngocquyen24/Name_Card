<?php

/**
 * Template Name: Template C
 * Description: A template for displaying user details.
 */

$user = json_decode(get_query_var('user', '')); // Lấy user từ set_query_var
$company = json_decode(get_query_var('company', '')); // Lấy company từ set_query_var

?>

<div class="name-card-container">
    <form style="display: contents;">
        <div class="name-card-c name-card">
            <div class="front">
                <?php if (!empty($company)): ?>
                    <div class="company">
                        <div class="logo">
                            <?php if (!empty($company->image)): ?>
                                <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" style="max-width: 50px;">
                            <?php endif; ?>
                        </div>
                        <div class="name-company"><?php echo esc_html($company->name); ?></div>
                    </div>
                <?php else: ?>
                    <p>No company found with ID = 1.</p>
                <?php endif; ?>
                <div class="name">
                    <h3><?php echo esc_html($user->name); ?></h3>
                </div>
                <div class="email">
                    <p><?php echo esc_html($user->email); ?></p>
                </div>
                <div class="phone">
                    <p><?php echo esc_html($user->phone); ?></p>
                </div>
            </div>
        </div>

        <!-- Thẻ tên 2 -->
        <div class="name-card-c name-card">
            <div class="back">
                <h3>Contact Info</h3>
                <p>Phone: <?php echo esc_html($user->phone); ?></p>
                <p>Location: Los Angeles</p>
            </div>
        </div>
    </form>
</div>