<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Transfer</div>
                <div class="card-body">
                    <form id="transferForm">
                        @csrf
                        <div class="form-group">
                            <label for="email">Recipient Email</label>
                            <input type="email" name="email" id="recipientEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="transferAmount" class="form-control" step="0.01" required>
                        </div>
                        <br>
                        <button type="button" onclick="submitTransferForm()" class="btn btn-primary">Transfer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
                url: '{{ route('transfer') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    amount: amount,
                },
                success: function(response) {
                    alert('Transfer successful!');
                    $("span#userBalance").text(response.balance);
                },
                error: function(error) {
                    alert('Error during transfer: ' + error.responseText);
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
</script>
