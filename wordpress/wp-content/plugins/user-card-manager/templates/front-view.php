<style>
    .name-card-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .name-card-table th,
    .name-card-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .name-card-table th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
    }

    .name-card-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .name-card-table tr:hover {
        background-color: #f1f1f1;
    }
</style>

<table class="name-card-table">
    <tr>
        <th>Họ và Tên</th>
        <th>Email</th>
        <th>Điện thoại</th>
       
    </tr>
    <?php if (!empty($cards)): ?>
        <?php foreach ($cards as $card): ?>
            <tr>
                <td><?php echo esc_html($card->name); ?></td>
                <td><?php echo esc_html($card->email); ?></td>
                <td><?php echo esc_html($card->phone); ?></td>
               
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Chưa có Name Card nào.</td>
        </tr>
    <?php endif; ?>
</table>
