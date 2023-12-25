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
<script>
    /**
     * Get statement.
     *
     * @param url
     */
    function getStatement(url = null) {
        var loggedInUserId = {{ $user->id }};
        $.ajax({
            url: url ? url : '{{ route('transactions') }}',
            type: 'GET',
            success: function(response) {
                $('#statementsData').empty();

                let rowNumber = response.from;
                $.each(response.data, function(index, statement) {
                    $('#statementsData').append(
                        '<tr>' +
                        '<td>' + rowNumber + '</td>' +
                        '<td>' + statement.created_at + '</td>' +
                        '<td>' + statement.amount + '</td>' +
                        '<td>' + (statement.type === "deposit" ? "Credit" : "Debit") + '</td>' +
                        '<td>' + (statement.type === "withdrawal" ? "Withdraw" : (statement.type === "deposit" ? "Deposit" : ((loggedInUserId === statement.user_id ? ("Transfer to " + statement.receiver.email) : ("Transfer from " + statement.sender.email))))) + '</td>' +
                        '<td>' + (loggedInUserId === statement.user_id ? statement.sender_balance : statement.receiver_balance) + '</td>' +
                        '</tr>'
                    );
                    rowNumber ++;
                });
                updatePaginationLinks(response.links)
            },
            error: function(error) {
                console.error('Error refreshing statements tab: ' + error.responseText);
            }
        });
    }

    /**
     * Pagination.
     *
     * @param links
     */
    function updatePaginationLinks(links) {
        var paginationContainer = $('#pagination-container');

        var paginationHtml = '';

        links.forEach(function(link) {
            var isActive = link.active ? 'active' : '';

            paginationHtml += '<li class="page-item ' + isActive + '">';
            if (link.url) {
                paginationHtml += '<a class="page-link" href="#" data-url="' + link.url + '">' + link.label + '</a>';
            } else {
                paginationHtml += '<span class="page-link">' + link.label + '</span>';
            }
            paginationHtml += '</li>';
        });

        paginationContainer.html('<ul class="pagination">' + paginationHtml + '</ul>');

        paginationContainer.find('.page-link').on('click', function(event) {
            event.preventDefault();

            var url = $(this).data('url');

            getStatement(url);
        });
    }

    /**
     * Get statement on tab click.
     */
    $('#statement-tab').on('click', function() {
        getStatement();
    });

    $(document).ready(function() {
        getStatement();
    });
</script>
