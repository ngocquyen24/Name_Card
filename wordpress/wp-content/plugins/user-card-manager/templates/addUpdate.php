<div class="wrap">
    <h1><?php echo $id > 0 ? 'Update User Card' : 'Add User Card'; ?></h1>
    <form method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <th>Name</th>
                <td><input type="text" name="name" value="<?php echo esc_attr($card['name']); ?>" required></td>
            </tr>
            <tr>
                <th>Birthdate</th>
                <td><input type="date" name="birthdate" value="<?php echo esc_attr($card['birthdate'] ?? ''); ?>" required></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><textarea name="address" required><?php echo esc_textarea($card['address'] ?? ''); ?></textarea></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="email" name="email" value="<?php echo esc_attr($card['email']); ?>" required></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><input type="text" name="phone" value="<?php echo esc_attr($card['phone']); ?>" required></td>
            </tr>
            <tr>
                <th>Job title</th>
                <td><input type="text" name="jobtitle" value="<?php echo esc_attr($card['jobtitle']); ?>" required></td>
            </tr>
            <tr>
                <th>Job name</th>
                <td><input type="text" name="jobname" value="<?php echo esc_attr($card['jobname']); ?>" required></td>
            </tr>
            <tr>
                <th>Template</th>
                <td>
                    <select name="template" required>
                        <option value="a" <?php echo selected($card['template'], 'a', false); ?>>Template A</option>
                        <option value="b" <?php echo selected($card['template'], 'b', false); ?>>Template B</option>
                        <option value="c" <?php echo selected($card['template'], 'c', false); ?>>Template C</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Image</th>
                <td>

                    <?php if (!empty($card['image'])): ?>
                        <!-- Hiển thị thông tin và ảnh hiện tại nếu đã có -->
                        <input type="file" name="image">
                        <p>Current Image: <?php echo esc_html($card['image']); ?></p>
                        <img src="<?php echo wp_upload_dir()['baseurl'] . '/imagesUser/' . esc_html($card['image']); ?>" alt="User Image" style="max-width: 150px;">

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
        <p><button type="submit" name="save_card" class="button button-primary">Save</button></p>
    </form>
    <a href="<?php echo admin_url('admin.php?page=user-card-manager'); ?>" class="button">Back</a>
</div>