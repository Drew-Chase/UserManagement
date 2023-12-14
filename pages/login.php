<style>
    #login-form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }

    form {
        width: 50%;
        min-width: 300px;
        max-width: 900px;
    }

    form>*:nth-child(1) {
        animation-name: loadPage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        opacity: 0;
        animation-delay: .2s;
    }

    form>*:nth-child(2) {
        animation-name: loadPage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        opacity: 0;
        animation-delay: .3s;
    }

    form>*:nth-child(3) {
        animation-name: loadPage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        opacity: 0;
        animation-delay: .4s;
    }

    button {
        margin: auto;
        width: 190px;
        height: 48px;
        padding: 12px 16px;
    }

    h1 {
        color: var(--primary);
        font-size: 8rem;
        margin-top: 0;
        margin-bottom: 1rem;

        animation-name: loadPage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
    }

    #login-form.close h1 {
        opacity: 1;
        animation-name: closePage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        animation-delay: .4s;
    }

    #login-form.close form>*:nth-child(1) {
        opacity: 1;
        animation-name: closePage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        animation-delay: .3s;
    }

    #login-form.close form>*:nth-child(2) {
        opacity: 1;
        animation-name: closePage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        animation-delay: .2s;
    }

    #login-form.close form>*:nth-child(3) {
        opacity: 1;
        animation-name: closePage;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        animation-delay: 0s;
    }

    @keyframes loadPage {
        0% {
            transform: translateY(100px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes closePage {
        0% {
            transform: translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateY(100px);
            opacity: 0;
        }
    }
</style>


<div id="login-form" class="col center horizontal vertical">
    <h1>Mardens</h1>
    <form action="javascript:void(0);" class="col">
        <div class="floating-input">
            <input type="text" name="username" placeholder="Username" autocomplete="username">
            <label for="username">Username</label>
        </div>
        <div class="floating-input">
            <input type="password" name="password" placeholder="Password" autocomplete="current-password">
            <label for="password">Password</label>
        </div>
        <button type="submit">Login <img src="/assets/images/icons/lock.svg" alt=""></button>
    </form>
</div>

<script>
    document.title = "Login - User Management";
    const form = $("form");
    const button = $("button");

    $(auth).on("logged-in", () => {
        $("#login-form").addClass("close");
        $("main").load("/pages/dashboard.php");
        setTimeout(() => {
        }, 1200);
    });

    auth.loginWithToken();

    form.on("submit", async () => {

        button.attr("disabled", true);
        button.html("Logging in...");
        let formdata = form.serializeArray();
        let username = formdata[0]["value"];
        let password = formdata[1]["value"];
        let response = await auth.login(username, password)

        if (!response.success) {
            button.html("Login");
            button.attr("disabled", false);
            popup.alert("Login Failed", response.message);
        }
    });
</script>