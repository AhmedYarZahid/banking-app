/**
 * Get statement.
 *
 * @param url
 */
function getStatement(url = null) {
    $.ajax({
        url: url ? url : baseUrl + '/transactions',
        type: 'GET',
        success: function(response) {
            $('#statementsData').empty();

            let rowNumber = response.from;
            $.each(response.data, function(index, statement) {
                $('#statementsData').append(
                    '<tr>' +
                    '<td>' + rowNumber + '</td>' +
                    '<td>' + formatDate(statement.created_at) + '</td>' +
                    '<td>' + statement.amount + '</td>' +
                    '<td>' + (statement.type === "deposit" ? "Credit" : "Debit") + '</td>' +
                    '<td>' + (statement.type === "withdrawal" ? "Withdraw" : (statement.type === "deposit" ? "Deposit" : ((userId === statement.user_id ? ("Transfer to " + statement.receiver.email) : ("Transfer from " + statement.sender.email))))) + '</td>' +
                    '<td>' + (userId === statement.user_id ? statement.sender_balance : statement.receiver_balance) + '</td>' +
                    '</tr>'
                );
                rowNumber ++;
            });
            updatePaginationLinks(response.links)
        },
        error: function(error) {
            showMessage('Error refreshing statements tab: ' + error.responseText);
        }
    });
}

/**
 * Change date format to match mm-dd-yyyy hh:mm am/pm
 *
 * @param date
 * @returns {string}
 */
function formatDate(date) {
    const originalDate = new Date(date);
    const year = originalDate.getFullYear();
    const month = String(originalDate.getMonth() + 1).padStart(2, '0');
    const day = String(originalDate.getDate()).padStart(2, '0');
    const hours = String(originalDate.getHours() % 12 || 12).padStart(2, '0');
    const minutes = String(originalDate.getMinutes()).padStart(2, '0');
    const ampm = originalDate.getHours() >= 12 ? 'PM' : 'AM';
    return `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;
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
