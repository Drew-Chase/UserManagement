
/**
 * 
 * @param {string} title The title of the alert box
 * @param {string} message The alert message
 * @param {(e: HTMLElement) => void} [onOk=(e) => {}] The function to run when the ok button is clicked
 * @param {(e: HTMLElement) => void} [onCancel=(e) => {}] The function to run when the cancel button is clicked
 * @returns {Promise<void>}
 */
async function loadAlert(title, message, onOk = (e) => {}, onCancel = (e) => {}) {
    let alert = $(await $.get("/components/alert.php"));
    alert.find(".title").html(title);
    alert.find(".message").html(`<p>${message}</p>`);
    alert.find("#popup-ok").click(() => {
        alert.addClass("close");
        setTimeout(() => {
            alert.remove();
        }, 500);
        onOk($(alert.find(".message").html()));
    });
    alert.find("#popup-cancel").click(() => {
        alert.addClass("close");
        setTimeout(() => {
            alert.remove();
        }, 500);
        onCancel($(alert.find(".message").html()));
    });
    $("body").append(alert);

    $(document).trigger('page-loaded');
}
