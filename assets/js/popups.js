
/**
 * 
 * @param {string} title The title of the alert box
 * @param {string} message The alert message
 * @param {Function:void} onOk When the okay button is clicked
 * @param {Function:void} onCancel WHen the cancel button is clicked
 */
async function loadAlert(title, message, onOk = () => {}, onCancel = () => {}) {
    let alert = $(await $.get("/components/alert.php"));
    alert.find(".title").html(title);
    alert.find(".message").html(message);
    alert.find("#popup-ok").click(() => {
        alert.addClass("close");
        setTimeout(() => {
            alert.remove();
        }, 500);
        onOk();
    });
    alert.find("#popup-cancel").click(() => {
        alert.addClass("close");
        setTimeout(() => {
            alert.remove();
        }, 500);
        onCancel();
    });
    $("body").append(alert);
}
