<style>
    .page-content {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        height: calc(100vh - 4rem);
        width: calc(100% - 164px);
        min-width: 500px;
        min-height: 500px;
        overflow: scroll;
        opacity: 0;
        animation-name: pageLoad;
        animation-fill-mode: forwards;
        animation-duration: .7s;
        animation-delay: .3s;
    }

    .page-title {
        margin: 0;
        margin-bottom: 1rem;
        font-size: 120px;
        opacity: 0.2;
        text-transform: uppercase;
        font-weight: 900;
    }

    @keyframes pageLoad {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
    @keyframes contentLoad {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>

<div class="row" style="flex-wrap:nowrap;">
    <?php require_once "../components/nav.php"; ?>

    <div class="page-content">

    </div>
</div>

<script>
    (() => {
        document.title = "Dashboard - User Management";
        loadPage(window.location.pathname.replace("/", ""));
        $(document).on("page-change", (_, page) => loadPage(page))
    })();

    function loadPage(page) {
        window.history.pushState({}, page, `/${page}`);
        $(".nav-item").removeClass("selected");
        $(`.nav-item[page="${page}"]`).addClass("selected");

        page = page == "" ? "dashboard" : page;
        $(".page-content").load(`/pages/dashboard/${page}.php`);
        $(document).trigger('page-loaded', page);
    }
</script>