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
                            <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesUser/'; ?><?php echo ($card->image); ?>" alt="User Image" style="max-width: 100px;">
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