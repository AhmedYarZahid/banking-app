/**
 * Deposit Amount.
 */
function submitDepositForm() {
    var amount = $('#depositAmount').val();

    if(amount) {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/deposit',
            data: {
                _token: csrfToken,
                amount: amount
            },
            success: function(response) {
                showMessage('Deposit successful!', 'success');
                $("span#userBalance").text(response.balance);
            },
            error: function(error) {
                showMessage('Error during deposit: ' + error.responseJSON.error.amount !== undefined ? error.responseJSON.error.amount[0] : error.responseJSON.error);
            }
        });
    } else {
        alert("Amount should not be empty!")
    }
}
