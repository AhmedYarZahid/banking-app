<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Withdraw</div>
                <div class="card-body">
                    <form id="withdrawForm">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="withdrawAmount" class="form-control" step="0.01" required>
                        </div>
                        <br>
                        <button type="button" onclick="submitWithdrawForm()" class="btn btn-primary">Withdraw</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Withdraw amount.
     */
    function submitWithdrawForm() {
        var amount = $('#withdrawAmount').val();

        if(amount) {
            $.ajax({
                type: 'POST',
                url: '{{ route('withdraw') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: amount
                },
                success: function(response) {
                    alert('Withdrawal successful!');
                    $("span#userBalance").text(response.balance);
                },
                error: function(error) {
                    alert('Error during withdrawal: ' + error.responseText);
                }
            });
        } else {
            alert("Amount should not be empty!")
        }
    }
</script>
