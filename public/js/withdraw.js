/**
 * Withdraw amount.
 */
function submitWithdrawForm() {
    var amount = $('#withdrawAmount').val();

    if(amount) {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/withdraw',
            data: {
                _token: csrfToken,
                amount: amount
            },
            success: function(response) {
                showMessage('Withdrawal successful!', 'success');
                $("span#userBalance").text(response.balance);
            },
            error: function(error) {
                showMessage('Error during withdraw: ' + error.responseJSON.error.amount !== undefined ? error.responseJSON.error.amount[0] : error.responseJSON.error);
            }
        });
    } else {
        alert("Amount should not be empty!")
    }
}
