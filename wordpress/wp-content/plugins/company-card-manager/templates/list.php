<style>
    /* Default Styling for Desktop (>= 1024px) */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

table thead th {
    background-color: #f4f4f4;
}

img {
    max-width: 100px;
    height: auto;
}

/* Styling for Laptop Screens (1024px to 1366px) */
@media screen and (max-width: 1366px) {
    table th, table td {
        font-size: 14px;
    }

    table tbody td img {
        max-width: 80px;
    }

    table tbody td a.button {
        font-size: 14px;
        padding: 6px 12px;
    }
}

/* Styling for Tablet Screens (768px to 1024px) */
@media screen and (max-width: 1024px) {
    table th, table td {
        font-size: 13px;
        padding: 8px;
    }

    table tbody td img {
        max-width: 70px;
    }

    table tbody td a.button {
        font-size: 12px;
        padding: 5px 10px;
    }
}

/* Styling for Mobile Screens (<= 768px) */
@media screen and (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    table th, table td {
        font-size: 12px;
        padding: 6px;
    }

    table tbody td img {
        max-width: 60px;
    }

    table tbody td a.button {
        font-size: 11px;
        padding: 4px 8px;
    }
}

</style>

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
                <td><?php echo ($company->address); ?></td>
                <td><?php echo ($company->phone); ?></td>
                <td><?php echo ($company->email); ?></td>
                <td><?php echo ($company->profile); ?></td>
                <td>
                    <?php if (!empty($company->image)): ?>
                        <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" alt="Company Image" >
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