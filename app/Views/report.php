<?php require_once 'layout/header.php' ?>

<h2 class="text-center">Submission Report</h2>
<div class="d-flex justify-content-center">
    <div class="table-wrapper" style="width: 90%; min-height: 90vh">
        <form action="/report" method="get" class="d-flex">
            <input type="text" class="form-control me-2" name="id" placeholder="Enter ID">
            <input type="date" class="form-control me-2" name="start_date" placeholder="Start Date">
            <input type="date" class="form-control me-2" name="end_date" placeholder="End Date">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Buyer</th>
                    <th>Receipt ID</th>
                    <th>Items</th>
                    <th>Buyer's Email</th>
                    <th>Note</th>
                    <th>City</th>
                    <th>Phone</th>
                    <th>Entry By</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($submissions)): ?>
                <tr>
                    <td colspan="10" class="text-center">No submissions found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?= $submission['id'] ?></td>
                        <td><?= $submission['amount'] ?></td>
                        <td><?= $submission['buyer'] ?></td>
                        <td><?= $submission['receipt_id'] ?></td>
                        <td><?= is_array($submission['items']) ? implode(",<br>", $submission['items']) : $submission['items']; ?></td>
                        <td><?= $submission['buyer_email'] ?></td>
                        <td><?= $submission['note'] ?></td>
                        <td><?= $submission['city'] ?></td>
                        <td><?= $submission['phone'] ?></td>
                        <td><?= $submission['entry_by'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'layout/footer.php' ?>

