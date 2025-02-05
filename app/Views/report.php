<?php require_once 'layout/header.php' ?>

<h2 class="text-center"><u>Submissions</u></h2>
<div class="d-flex justify-content-center">
    <div class="table-wrapper mt-2" style="width: 90%; min-height: 90vh">
        <form action="/report" method="get" class="d-flex">
            <div class="input-group me-2">
                <span class="input-group-text">ID</span>
                <input type="text" class="form-control" name="id" placeholder="Enter ID">
            </div>
            <div class="input-group me-2">
                <span class="input-group-text">Start Date</span>
                <input type="date" class="form-control" name="start_date" placeholder="Start Date">
            </div>
            <div class="input-group me-2">
                <span class="input-group-text">End Date</span>
                <input type="date" class="form-control" name="end_date" placeholder="End Date">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <table class="table mt-2">
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
                    <th>IP </th>
                    <th>Entry By</th>
                    <th>Submission Date</th>
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
                        <td><?= $submission['buyer_ip'] ?></td>
                        <td><?= $submission['entry_by'] ?></td>
                        <td><?= date('d-m-Y', strtotime($submission['entry_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'layout/footer.php' ?>