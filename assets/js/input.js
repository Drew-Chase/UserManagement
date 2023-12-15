$(document).on("page-loaded",() => {
    setTimeout(()=>{{
        // Add a click event listener to all "toggle" elements.
        // When a "toggle" element is clicked, prevent the default click behavior and toggle its value.
        $("toggle").on("click", (e) => {
            // Prevent the default click behavior.
            e.preventDefault();
            // Get the target of the click event.
            let target = $(e.target);
            // Get the current value of the "value" attribute of the target.
            let value = target.attr("value") === "true";
            // Set the "value" attribute of the target to the opposite of its current value.
            target.attr("value", !value);
            // Trigger a "toggle" event on the target with the new value.
            target.trigger("toggle", [{ value: !value }]);
        });
    }}, 500)
});