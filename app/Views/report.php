<h2>Submission Report</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Buyer</th>
        <th>Amount</th>
        <th>Receipt ID</th>
    </tr>
    <?php foreach ($submissions as $submission): ?>
    <tr>
        <td><?= $submission['id'] ?></td>
        <td><?= $submission['buyer'] ?></td>
        <td><?= $submission['amount'] ?></td>
        <td><?= $submission['receipt_id'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

