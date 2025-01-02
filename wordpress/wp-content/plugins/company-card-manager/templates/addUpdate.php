
<div class="wrap">
    <h1><?php echo $id > 0 ? 'Update Company' : 'Add Company'; ?></h1>
    <form method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <th>Name</th>
                <td><input type="text" name="name" value="<?php echo ($company['name']); ?>" required></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><textarea name="address" required><?php echo ($company['address']); ?></textarea></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><input type="text" name="phone" value="<?php echo ($company['phone']); ?>" required></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="email" name="email" value="<?php echo ($company['email']); ?>" required></td>
            </tr>
            <tr>
                <th>Profile</th>
                <td><textarea name="profile" required><?php echo ($company['profile']); ?></textarea></td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                   
                   <?php if (!empty($company['image'])): ?>
                       <!-- Hiển thị thông tin và ảnh hiện tại nếu đã có -->
                       <input type="file" name="image">
                       <p>Current Image: <?php echo esc_html($company['image']); ?></p>
                       <img src="<?php echo wp_upload_dir()['baseurl'] . '/imagesCompany/' . esc_html($company['image']); ?>" alt="Company Image" style="max-width: 150px;">
                   <?php else: ?>
                       <!-- Trường nhập file bắt buộc nếu chưa có ảnh -->
                       <input type="file" name="image" required>
                   <?php endif; ?>
                   <?php if ($error_message): ?>
                       <p class="error" style="color: red;"><?php echo esc_html($error_message); ?></p>
                   <?php endif; ?>
               </td>
               
            </tr>
        </table>
        <p><button type="submit" name="save_company" class="button button-primary">Save</button></p>
    </form>
    <a href="<?php echo admin_url('admin.php?page=company-card-manager'); ?>" class="button">Back</a>
</div>