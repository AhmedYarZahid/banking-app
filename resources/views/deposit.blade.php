<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Deposit</div>
                <div class="card-body">
                    <form id="depositForm">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="depositAmount" class="form-control" step="0.01" required>
                        </div>
                        <br>
                        <button type="button" onclick="submitDepositForm()" class="btn btn-primary">Deposit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Deposit Amount.
     */
    function submitDepositForm() {
        var amount = $('#depositAmount').val();

        if(amount) {
            $.ajax({
                type: 'POST',
                url: '{{ route('deposit') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: amount
                },
                success: function(response) {
                    alert('Deposit successful!');
                    $("span#userBalance").text(response.balance);
                },
                error: function(error) {
                    alert('Error during deposit: ' + error.responseText);
                }
            });
        } else {
            alert("Amount should not be empty!")
        }
    }
</script>
