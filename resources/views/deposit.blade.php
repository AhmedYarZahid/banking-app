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
<script src="{{ asset('js/deposit.js') }}"></script>
