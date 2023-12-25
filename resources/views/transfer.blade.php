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
<script src="{{ asset('js/transfer.js') }}"></script>

