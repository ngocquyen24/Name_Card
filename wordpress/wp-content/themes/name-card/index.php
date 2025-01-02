<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body>
    <?php
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM wp_user_cards");
    ?>

    <div class="container mt-3">
        <h2>Name Card</h2>

        <table class="table">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Jobname</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->jobtitle; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td>
                            <a href="<?php echo site_url('/detail-name-card/?id=' . $row->id); ?>" class="btn btn-secondary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?php echo site_url('/view-user/?id=' . $row->id); ?>" class="btn btn-secondary">
                                <i class="fa-solid fa-right-from-bracket"></i> Name Card
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>