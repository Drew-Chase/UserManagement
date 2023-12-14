<style>
    .page-content {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
        height: calc(100vh - 4rem);
        width: calc(100% - 164px);
        background-color: #181818;
        border-radius: 5px;
        min-width: 500px;
        min-height: 500px;
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

        function loadPage(page) {
            $(".nav-item").removeClass("selected");
            $(`.nav-item[page="${page}"]`).addClass("selected");

            page = page == "" ? "dashboard" : page;
            $(".page-content").load(`/pages/dashboard/${page}.php`);
        }
    })()
</script>