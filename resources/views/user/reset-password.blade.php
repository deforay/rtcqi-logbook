<link rel="stylesheet" href=" {{ asset('assets/css/toastify.min.css') }}">
<div class="modal-header">
    <h5 class="modal-title">Reset Password for {{ $result[0]->first_name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    
    <form id="resetPasswordForm">
        <div id="show_alert" class="mt-1" style=""></div>
        @csrf
        <input type="hidden" name="userId" value="{{ base64_encode($result[0]->user_id) }}">
        <div class="form-group col-lg-6">
            <label for="newPassword">New Password</label> <span class="mandatory">*</span>
            <input type="password" name="newPassword" id="newPassword" class="form-control isRequired"  placeholder="Enter New Password" title="Please Enter New Password">
        </div>
        <div class="form-group col-lg-6">
            <label for="confirmPassword">Confirm Password</label> <span class="mandatory">*</span>
            <input type="password" name="newPassword" id="confirmPassword" class="form-control isRequired confirmPassword" placeholder="Enter Confirm Password" title="Please check your new password and confirm password are same">
        </div>
        <div class="form-group col-lg-6">
            <button type="button" id="generatePassword" onclick="passwordType();" class="btn btn-info"><b>Generate Random Password</b></button><br>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="submitResetPassword()">Reset Password</button>
</div>
<script src="{{ asset('assets/js/toastify-js.js') }}"></script>
<script>
    function passwordType() {
        document.getElementById('newPassword').type = "text";
        document.getElementById('confirmPassword').type = "text";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/generatePassword') }}",
            method: 'post',
            data: {},
            success: function(result) {
                $("#newPassword").val(result);
                $("#confirmPassword").val(result);
                var cpy = copyToClipboard(document.getElementById("confirmPassword"));
                if (cpy == true) {
                    Toastify({
                        text: "Random password generated and copied to clipboard",
                        duration: 3000,
                    }).showToast();
                }
            }
        });
    }

    function copyToClipboard(elem) {
        // Check if the element is an input/textarea
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var target, origSelectionStart, origSelectionEnd;

        if (isInput) {
            // Use the element's value for selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // Create a temporary textarea for non-input elements
            var targetId = "_hiddenCopyText_";
            target = document.getElementById(targetId);
            if (!target) {
                target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.value = elem.textContent; // Use textContent for non-input elements
        }

        // Select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // Copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }

        // Restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // Restore the original selection for input elements
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // Clear the temporary textarea
            target.value = "";
        }

        return succeed;
    }

    function submitResetPassword() {
        flag = deforayValidator.init({
            formId: 'resetPasswordForm'
        });
        if (flag !== true) {
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
            // Assuming `flag` contains the error message
            return; // Stop further execution
        }
        const form = $('#resetPasswordForm');
        const formData = form.serialize();

        $.ajax({
            url: '/user/submit-reset-password', // Update this URL if required
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    alert('Password Changed Successfully.');
                    $('#modal_ajax').modal('hide'); // Close the modal
                    location.reload(); // Optionally reload the page or DataTable
                }
            }
        });
    }
</script>