<?php
    require_once 'layout/header.php';
?>
<div class="container d-flex justify-content-center">
    <div style="width: 50%;" class="p-3">
        <form id="submissionForm">
            <div class="mb-3">
                <label for="buyer" class="form-label">Buyer's Name</label>
                <input type="text" class="form-control" id="buyer" name="buyer" placeholder="Enter buyer's name" maxlength="20" required pattern="^[a-zA-Z0-9\s]+$">
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only text, spaces and numbers, not more than 20 characters.</div>
                <div class="invalid-feedback" id="buyer-error"></div>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only numbers.</div>
                <div class="invalid-feedback" id="amount-error"></div>
            </div>
            <div class="mb-3">
                <label for="receipt_id" class="form-label">Receipt ID</label>
                <input type="text" class="form-control" id="receipt_id" name="receipt_id" placeholder="Enter receipt ID" required>
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only text.</div>
                <div class="invalid-feedback" id="receipt_id-error"></div>
            </div>
            <div class="mb-3">
                <label for="items" class="form-label">Items</label>
                <div class="input-group" id="itemsContainer">
                    <input type="text" class="form-control" id="items" name="items[]" placeholder="Enter item name" required pattern="^[a-zA-Z\s]+$">
                    <span class="input-group-text btn btn-sm btn-danger" id="removeItem"><i class="bi bi-x"></i></span>
                </div>
                <div class="form-text text-danger" id="items-error"></div>
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only text</div>
                <button type="button" class="btn btn-sm btn-primary mt-2" id="addItem"><i class="bi bi-plus"></i> Add Item</button>
            </div>
            <div class="mb-3">
                <label for="buyer_email" class="form-label">Buyer's Email</label>
                <input type="email" class="form-control" id="buyer_email" name="buyer_email" placeholder="Enter buyer's email" required>
                <div class="invalid-feedback" id="buyer_email-error"></div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note" placeholder="Enter note" maxlength="30"></textarea>
                <div class="form-text"><i class="bi bi-info-circle"></i> Anything, not more than 30 words, and can be input unicode characters too.</div>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city name" required pattern="^[a-zA-Z\s]+$">
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only text and spaces.</div>
                <div class="invalid-feedback" id="city-error"></div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-group">
                    <span class="input-group-text">+880</span>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required pattern="^[0-9]+$">
                </div>
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only numbers.</div>
                <div class="invalid-feedback" id="phone-error"></div>
            </div>
            <div class="mb-3">
                <label for="entry_by" class="form-label">Entry By</label>
                <input type="number" class="form-control" id="entry_by" name="entry_by" placeholder="Enter entry by" required pattern="^[0-9]+$">
                <div class="form-text"><i class="bi bi-info-circle"></i> Must be only numbers.</div>
                <div class="invalid-feedback" id="entry_by-error"></div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i> Submit
                </button>
            </div>
        </form>
        <div class="alert alert-danger mt-3 d-none" id="form-error" role="alert"></div>
        <div class="alert alert-success mt-3 d-none" id="form-submission-success" role="alert"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#addItem').click(function(e) {
        $('#itemsContainer').after(`
            <div class="input-group mt-2">
                <input type="text" class="form-control" name="items[]" placeholder="Enter item name" required pattern="^[a-zA-Z\s]+$">
                <span class="input-group-text btn btn-sm btn-danger removeItem"><i class="bi bi-x"></i></span>
            </div>
        `);
    });

    $(document).on('click', '.removeItem', function(e) {
        $(this).parent('.input-group').remove();
    });

    $('#submissionForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        
        // ensure phone has +880 added before being sent to backend
        formData.push({name: 'phone', value: '880' + formData.find(el => el.name === 'phone').value});

        $.ajax({
            url: "/submit",
            type: "POST",
            data: formData,
            success: function(response) {
                var response = JSON.parse(response);

                if (response.status == "success") {
                    $('#form-submission-success').removeClass('d-none').html(response.message);
                }

                if (response.status == "error") {
                    $('#form-error').removeClass('d-none').html(response.message);
                    $.each(response.errors, function(key, value) {
                        $('#' + key + '-error').html(value);
                        $('#' + key).addClass('is-invalid');
                    });
                }
            },
            error:function(response) {
                alert("Error occurred submitting form");
            }
        });
    });

    $('#submissionForm input').on('focusout', function() {
        var $this = $(this);
        var value = $this.val();
        var name = $this.attr('name').replace(/[\[\]]/g, '');

        if (value == '') {
            $('#' + name + '-error').html('This field is required');
            $this.addClass('is-invalid');
        } else {
            $('#' + name + '-error').html('');
            $this.removeClass('is-invalid');
        }
    });

    $('#submissionForm input[name="phone"]').on('focusout', function() {
        var value = $(this).val();

        if (!/^[0-9]+$/.test(value)) {
            $('#phone-error').html('Must be only numbers.');
            $(this).addClass('is-invalid');
        } else {
            $('#phone-error').html('');
            $(this).removeClass('is-invalid');
        }
    });

    $('#submissionForm input[name="city"]').on('focusout', function() {
        var value = $(this).val();

        if (!/^[a-zA-Z\s]+$/.test(value)) {
            $('#city-error').html('Must be only text and spaces.');
            $(this).addClass('is-invalid');
        } else {
            $('#city-error').html('');
            $(this).removeClass('is-invalid');
        }
    });

    $(document).on('focusout', '#submissionForm input[name="receipt_id"]', function() {
        var value = $(this).val();

        if (!/^[a-zA-Z\s]+$/.test(value)) {
            $('#receipt_id-error').html('Must be only text and spaces.');
            $(this).addClass('is-invalid');
        } else {
            $('#receipt_id-error').html('');
            $(this).removeClass('is-invalid');
        }
    });

    $(document).on('focusout', '#submissionForm input[name="items[]"]', function() {
        var value = $(this).val();

        if (!/^[a-zA-Z\s]+$/.test(value)) {
            $('#items-error').html('Must be only text and spaces.');
            $(this).addClass('is-invalid');
        } else {
            $('#items-error').html('');
            $(this).removeClass('is-invalid');
        }
    });
});
</script>

<?= require_once 'layout/footer.php' ?>

