<style>
    nav {
        width: 5.30688rem;
        margin: 2rem;
        flex-shrink: 0;
        border-radius: 1.125rem;
        background: #181818;
        margin-left: 1rem;
        min-height: calc(100vh - 4rem);
        transition: scale 200ms;
    }

    nav .nav-item {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        width: 3.25rem;
        height: 3.25rem;
        margin: 1rem;
        padding: 0px;
        margin-top: 1rem;
        border-radius: 0.625rem;
    }

    nav .nav-item .label {
        opacity: 0;
        position: absolute;
        left: calc(100% + 1.1rem);
        pointer-events: none;
        top: 0;
        width: 9.53763rem;
        height: 3.25rem;
        display: flex;
        align-items: center;
        filter: drop-shadow(2px 4px 6px black);
        z-index: 9;
    }

    nav .nav-item:hover .label {
        opacity: 1;
    }

    nav .nav-item .label .title {
        position: absolute;
        left: 2.5rem;
        font-size: 1.125rem;
        line-height: 1.375rem;
        letter-spacing: -0.0225rem;
        text-transform: capitalize;
    }

    nav .nav-item img.icon {
        width: 2.375rem;
        height: 2.375rem;
        margin: auto;
    }

    nav .nav-item.selected,
    nav .nav-item:hover {
        background: hsl(0, 88%, 56%);
    }

    nav .nav-item .label svg.label-background {
        position: absolute;
    }

    nav #nav-items {
        height: calc(100vh - 10rem);
        min-height: 14rem;
    }
</style>



<nav class="col center vertical">
    <div id="nav-items" class="col">
        <div class="nav-item selected" page="home">
            <img class="icon" src="/assets/images/icons/home.svg" alt="">
            <span class="label">
                <svg class="label-background" xmlns="http://www.w3.org/2000/svg" width="153" height="52" viewBox="0 0 153 52" fill="none">
                    <rect x="8.77454" width="144.225" height="52" rx="4" fill="#262626" />
                    <path d="M2.36222 26.9077C1.58832 26.55 1.58832 25.45 2.36222 25.0923L11.7667 20.7452C12.4294 20.4389 13.1863 20.9229 13.1863 21.6529L13.1863 30.3471C13.1863 31.0771 12.4294 31.5611 11.7668 31.2548L2.36222 26.9077Z" fill="#262626" />
                </svg>
                <span class="title">Dashboard</span>
            </span>
        </div>
        <div class="nav-item" page="new-user">
            <img class="icon" src="/assets/images/icons/user-add.svg" alt="">
            <span class="label">
                <svg class="label-background" xmlns="http://www.w3.org/2000/svg" width="153" height="52" viewBox="0 0 153 52" fill="none">
                    <rect x="8.77454" width="144.225" height="52" rx="4" fill="#262626" />
                    <path d="M2.36222 26.9077C1.58832 26.55 1.58832 25.45 2.36222 25.0923L11.7667 20.7452C12.4294 20.4389 13.1863 20.9229 13.1863 21.6529L13.1863 30.3471C13.1863 31.0771 12.4294 31.5611 11.7668 31.2548L2.36222 26.9077Z" fill="#262626" />
                </svg>
                <span class="title">Add User</span>
            </span>
        </div>
    </div>
    <div class="col">
        <div class="nav-item" page="logout" onclick="auth.logout();">
            <img class="icon" src="/assets/images/icons/logout.svg" alt="">
            <span class="label">
                <svg class="label-background" xmlns="http://www.w3.org/2000/svg" width="153" height="52" viewBox="0 0 153 52" fill="none">
                    <rect x="8.77454" width="144.225" height="52" rx="4" fill="#262626" />
                    <path d="M2.36222 26.9077C1.58832 26.55 1.58832 25.45 2.36222 25.0923L11.7667 20.7452C12.4294 20.4389 13.1863 20.9229 13.1863 21.6529L13.1863 30.3471C13.1863 31.0771 12.4294 31.5611 11.7668 31.2548L2.36222 26.9077Z" fill="#262626" />
                </svg>
                <span class="title">Logout</span>
            </span>
        </div>
    </div>
</nav>


<script>
    $(".nav-item").on('click', e => {
        let element = $(e.currentTarget);
        let page = element.attr('page');
        $(".nav-item.selected").removeClass('selected');
        element.addClass("selected");
        $(document).trigger('page-change', page);
    })
</script>