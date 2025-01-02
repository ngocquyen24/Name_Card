<?php

/**
 * Template Name: Template A
 * Description: A template for displaying user details.
 */

$user = json_decode(get_query_var('user', '')); // Lấy user từ set_query_var
$company = json_decode(get_query_var('company', '')); // Lấy company từ set_query_var

?>

<div class="name-card-container">
    <form style="display: contents;">
        <div class="name-card-a front-card-a ">
            <div class="front">
                <?php if (!empty($company)): ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="logo-a">
                                <?php if (!empty($company->image)): ?>
                                    <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" style="max-width: 55px;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 space-company">
                            <div class="name-company">
                                <?php echo esc_html($company->name); ?>
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                <?php else: ?>
                    <p>No company found with ID = 1.</p>
                <?php endif; ?>
                <div class="name">
                    <i class="fa-solid fa-user icon"></i>
                    <?php echo esc_html($user->name); ?>
                </div>
                <div class="email">
                    <i class="fa-solid fa-paper-plane"></i>
                    <?php echo esc_html($user->email); ?>
                </div>
                <div class="phone">
                    <i class="fa-solid fa-phone"></i>
                    <?php echo esc_html($user->phone); ?>
                </div>
            </div>
        </div>

        <!-- Thẻ tên 2 -->
        <div class="name-card-a back-card-a name-card">
            <div class="back">
                <div class="logo">
                    <?php if (!empty($company->image)): ?>
                        <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" style="max-width: 50px;">
                    <?php endif; ?>
                </div>
                <p>Phone: <?php echo esc_html($user->phone); ?></p>
                <p>Location: <?php echo esc_html($user->address); ?></p>
            </div>
        </div>
    </form>
    <button id="downloadPage" style="position: fixed; z-index: 9999; margin-top:300px; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        Tải trang dưới dạng PNG
    </button>

</div>