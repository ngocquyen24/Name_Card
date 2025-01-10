<style>
  /* Default Styling for Desktop (>= 1024px) */
table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
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

    table tbody td a.button,
    table tbody td button {
        font-size: 14px;
        padding: 6px 12px;
    }
}

/* Styling for Tablet Screens (768px to 1024px) */
@media screen and (max-width: 1024px) {
    table th, table td {
        font-size: 13px;
        padding: 6px;
    }

    table tbody td img {
        max-width: 70px;
    }

  

    table tbody td a.button,
    table tbody td button {
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
        padding: 5px;
      
     
    }


 
    table tbody td img {
        max-width: 60px;
    }

    table tbody td a.button,
    table tbody td button {
        font-size: 11px;
        padding: 4px 8px;
    }
}


</style>
<div class="wrap">
    <h1>List User Card</h1>
    <a href="<?php echo admin_url('admin.php?page=user-card-manager&action=add'); ?>" class="button button-primary">Add user card</a>
    <table class="widefat fixed" style="margin-top: 15px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Job title</th>
                <th>Job name</th>
                <th>Template</th>
                <th>Image</th>
                <th>Active</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $card): ?>
                <tr>
                    <td><?php echo ($card->name); ?></td>
                    <td><?php echo ($card->birthdate); ?></td>
                    <td><?php echo ($card->address); ?></td>
                    <td><?php echo ($card->email); ?></td>
                    <td><?php echo ($card->phone); ?></td>
                    <td><?php echo ($card->jobtitle); ?></td>
                    <td><?php echo ($card->jobname); ?></td>
                    <td><?php echo ($card->template); ?></td>
                    <td>
                        <?php if (!empty($card->image)): ?>
                            <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesUser/'; ?><?php echo ($card->image); ?>" alt="User Image">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=user-card-manager&action=edit&id=' . $card->id); ?>" class="button">Update</a>
                        <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user card?');">
                            <input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
                            <button type="submit" name="delete_card" class="button button-danger">Delete</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>