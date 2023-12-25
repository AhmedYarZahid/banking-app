/**
 * Transfer amount.
 */
function submitTransferForm() {
    var email = $('#recipientEmail').val();
    var amount = $('#transferAmount').val();

    if(email && amount) {
        // Validate email format
        if (!isValidEmail(email)) {
            alert('Invalid recipient email format');
            return;
        }

        $.ajax({
            type: 'POST',
            url: baseUrl + '/transfer',
            data: {
                _token: csrfToken,
                email: email,
                amount: amount,
            },
            success: function(response) {
                showMessage('Transfer successful!', 'success');
                $("span#userBalance").text(response.balance);
            },
            error: function(error) {
                showMessage('Error during transfer: ' + (error.responseJSON.error.email !== undefined ? error.responseJSON.error.email[0] : (error.responseJSON.error.amount !== undefined ? error.responseJSON.error.amount[0] : error.responseJSON.error)));
            }
        });
    } else {
        alert("Email and amount should not be empty!")
    }
}

/**
 * Helper function to validate email format.
 *
 * @param email
 * @returns {boolean}
 */
function isValidEmail(email) {
    // Use a regular expression for basic email format validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
