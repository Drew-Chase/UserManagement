<style>
    .popup {
        position: fixed;
        z-index: 1;
        inset: 0;
    }

    .popup-background {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, .5);
        backdrop-filter: blur(8px);
        cursor: pointer;
        z-index: -1;

        animation-name: loadBackground;
        animation-duration: 200ms;

        transition: opacity;
        transition-duration: 200ms;
    }

    .popup .popup-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        z-index: 1;

        animation-name: loadContent;
        animation-duration: 200ms;

        transition: opacity, transform;
        transition-duration: 200ms;
    }

    .popup .popup-content {
        background: #2C2C2C;
        width: 75%;
        max-height: 90%;
        overflow-y: scroll;
        border-radius: 0 0 18px 18px;
        padding-bottom: 2rem;
    }

    .popup .popup-body .title {
        background-color: var(--primary);
        color: #FFF;
        font-size: 2rem;
        font-weight: 900;
        line-height: 1.375rem;
        letter-spacing: 0.04rem;
        text-transform: uppercase;
        padding: 1rem;
        display: flex;
        align-items: center;
        margin-top: 0;
        width: 70%;
        margin-bottom: 0;
        width: 73%;
        border-radius: 18px 18px 0 0;
    }

    .popup .popup-content .message {
        color: #FFF;
        line-height: 1.375rem;
        letter-spacing: -0.02rem;
        margin: 1rem;
    }

    .popup .buttons .button {
        width: 35%;
        min-width: 200px;
        text-align: center;
        font-size: 1.125rem;
        font-style: normal;
        font-weight: 700;
        line-height: 1.375rem;
        letter-spacing: -0.0225rem;
        text-transform: uppercase;
        margin: 1rem;
    }

    .popup.close .popup-background {
        opacity: 0;
    }

    .popup.close .popup-body {
        transform: translateY(-100px);
        opacity: 0;
    }

    @keyframes loadContent {
        0% {
            transform: translateY(-100px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    @keyframes loadBackground {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>



<div id="popup" class="popup alert">
    <div class="popup-background"></div>
    <div class="popup-body col">
        <p class="title"></p>
        <div class="popup-content">
            <p class="message"></p>
        </div>
        <div class="buttons row center horizontal vertical">
            <button id="popup-ok" class="button primary">Okay</button>
            <button id="popup-cancel" class="button secondary">Cancel</button>
        </div>
    </div>
</div>