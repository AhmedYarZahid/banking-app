/**
 * show flash messages
 *
 * @param message
 * @param type
 */
function showMessage(message, type) {
    var container = $('#message-container');
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';

    // Create the message element
    var messageElement = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
        '</div>');

    // Append the message element to the container
    container.append(messageElement);

    // Fade out the message after 3 seconds
    setTimeout(function() {
        messageElement.alert('close');
    }, 3000);
}
