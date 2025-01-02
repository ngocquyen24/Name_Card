<div class="wrap">
        <h1>Company Details</h1>
        <?php if (!$has_company): ?>
            <a href="<?php echo admin_url('admin.php?page=company-card-manager&action=add'); ?>" class="button button-primary">Add Company</a>
        <?php endif; ?>
        <table class="widefat fixed" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Profile</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td><?php echo ($company->name); ?></td>
                    <td><?php echo ($company->address);
                        ?></td>
                    <td><?php echo ($company->phone); ?></td>
                    <td><?php echo ($company->email); ?></td>
                    <td><?php echo ($company->profile); ?></td>
                    <td>
                        <?php if (!empty($company->image)): ?>
                            <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" alt="Company Image" style="max-width: 100px;">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=company-card-manager&action=edit&id=' . $company->id); ?>" class="button">Update</a>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>