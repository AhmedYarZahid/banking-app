<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Statement</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>DATETIME</th>
                            <th>AMOUNT</th>
                            <th>TYPE</th>
                            <th>DETAILS</th>
                            <th>BALANCE</th>
                        </tr>
                        </thead>
                        <tbody id="statementsData"></tbody>
                    </table>
                    <div id="pagination-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/statement.js') }}"></script>
