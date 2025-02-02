<?php
    require_once 'layout/header.php';
?>
<div class="container d-flex justify-content-center">
    <div style="width: 50%;" class="p-3">
        <form id="submissionForm">
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required pattern="^[0-9]+$">
                <div class="form-text">Enter the amount in BDT.</div>
            </div>
            <div class="mb-3">
                <label for="buyer" class="form-label">Buyer's Name</label>
                <input type="text" class="form-control" id="buyer" name="buyer" maxlength="20" required pattern="^[a-zA-Z0-9\s]+$">
                <div class="form-text">Enter the buyer's name.</div>
            </div>
            <div class="mb-3">
                <label for="receipt_id" class="form-label">Receipt ID</label>
                <input type="text" class="form-control" id="receipt_id" name="receipt_id" required pattern="^[a-zA-Z]+$">
                <div class="form-text">Enter the receipt ID.</div>
            </div>
            <div class="mb-3">
                <label for="items" class="form-label">Items</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="items" name="items[]" required pattern="^[a-zA-Z]+$">
                    <span class="input-group-text btn btn-sm btn-danger" id="removeItem"><i class="bi bi-x"></i></span>
                </div>
                <div class="form-text">Enter the items purchased.</div>
                <button type="button" class="btn btn-sm btn-primary" id="addItem"><i class="bi bi-plus"></i> Add Item</button>
            </div>
            <div class="mb-3">
                <label for="buyer_email" class="form-label">Buyer's Email</label>
                <input type="email" class="form-control" id="buyer_email" name="buyer_email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                <div class="form-text">Enter the buyer's email.</div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note" maxlength="30"></textarea>
                <div class="form-text">Enter any additional notes.</div>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required pattern="^[a-zA-Z\s]+$">
                <div class="form-text">Enter the city.</div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required pattern="^[0-9]+$">
                <div class="form-text">Enter the phone number.</div>
                <script>
                    $("#phone").on("input", function() {
                        $(this).val("880" + $(this).val());
                    });
                </script>
            </div>
            <div class="mb-3">
                <label for="entry_by" class="form-label">Entry By</label>
                <input type="number" class="form-control" id="entry_by" name="entry_by" required pattern="^[0-9]+$">
                <div class="form-text">Enter the ID of the person entering the submission.</div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#addItem').click(function(e) {
        e.preventDefault();
        $('#items').after('<input type="text" class="form-control" name="items[]" required pattern="^[a-zA-Z]+$">');
    });

    $('#submissionForm').submit(function(e) {
        e.preventDefault();
        if ($('#submissionForm').valid()) {
            $.ajax({
                url: "/submit",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.message);
                }
            });
        }
    });
});
</script>
<?php
    require_once 'layout/footer.php';
?>


