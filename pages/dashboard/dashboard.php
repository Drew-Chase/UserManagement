<style>
    h2 {
        font-size: 4rem;
        margin: 0;
    }

    #user-list .list {
        width: calc(100% - 2rem);
        height: 100%;
        min-height: 300px;
    }

    #user-list .list button {
        width: 60px;
        margin-left: 1rem;
    }

    #user-list .list .user-item {
        margin: 0.5rem 0;
        padding: 0.5rem;
        border-radius: 0.5rem;
        height: fit-content;
        max-height: 66px;
        transition: background 100ms;
    }

    #user-list .list .user-item:hover {
        background: hsla(0, 0%, 100%, 0.1);
        cursor: pointer;
    }
</style>

<div class="col fill" id="user-list">
    <div class="list-header col center vertical island">
        <div class="row fill center vertical">
            <h2 class="fill">Users</h2>
            <button onclick="loadPage('new-user')" title="Add a new user"><i class="fa-solid fa-plus"></i> Add New User</button>
        </div>
        <div class="list-header row center vertical fill" style="margin-top: 1rem">
            <div class="search-input" style="min-width:fit-content; width: 100%;">
                <input type="search" name="" id="" placeholder="Search">
            </div>
            <button class="secondary" style="height: 100%; margin-right: 10px; width: 60px" onclick="loadFilters()"><i class="fa-solid fa-sliders"></i></button>
            <button onclick="search()" class="secondary" title="Filter the results" style="height: 100%;">Reset</button>
        </div>
    </div>
    <div class="list island">
    </div>
</div>
<script>
    function loadFilters() {
        loadAlert("Filters", `<?php
                                require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/db/auth.inc.php";
                                $perms = Authentication::getPermissionMap();
                                foreach ($perms as $value => $key) {
                                    $value = preg_replace('/(?<!\ )[A-Z]/', ' $0', $value);
                                    if ($key != 0) {
                                        if ($key == 1) {
                                            echo "<div id='other-permissions' class='row' style='flex-wrap: wrap;'>";
                                        }
                                        echo "<toggle permission='$key' style='width: 25%; margin-right: 4rem;'>$value</toggle>";
                                    }
                                }
                                echo "</div>";

                                ?>`, e => {
            let permissions = [];
            $("#other-permissions toggle[value='true']").each((i, e) => {
                permissions.push($(e).attr("permission"));
            });
            search(permissions);
        });
    }
    $("input[type='search']").on('input', () => search());
    async function search(permissions = []) {
        permissions = permissions.join(";");
        let username = $("input[type='search']").val();
        let users = await $.get(`/api/auth.php?username=${username}&permissions=${permissions}`);
        let list = $("#user-list .list");
        list.empty();
        console.log(users);
        users.users.forEach(user => {
            list.append(`
            <div class="user-item list-item row center vertical fill">
                <div class="col fill">
                    <h3>${user.username}</h3>
                </div>
                <div class="row">
                    <button onclick="loadPage('new-user?id=${user.id}')" title="Modify the user"><i class="fa-solid fa-pen"></i></button>
                    <button class="secondary" onclick="deleteUser('${user.id}')" title="Delete the user"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            `);
        });
    }

    (async () => {
        const users = await $.get("/api/auth.php");
        const list = $("#user-list .list");
        users.users.forEach(user => {
            list.append(`
                <div class="user-item list-item row center vertical fill">
                    <div class="col fill">
                        <h3>${user.username}</h3>
                    </div>
                    <div class="row">
                        <button onclick="loadPage('new-user?id=${user.id}')" title="Modify the user"><i class="fa-solid fa-pen"></i></button>
                        <button class="secondary" onclick="deleteUser('${user.id}')" title="Delete the user"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                `);
        });
    })();

    function editUser(id) {
        loadPage("edit-user", {
            id
        });
    }


    function deleteUser(id) {
        $.ajax(`/api/auth.php?id=${id}`, {
            method: "DELETE",
            success: e => {
                if (e.error) {
                    loadAlert("error", `An error occurred while deleting the user<br>${e.error}`);
                    return;
                }
                loadPage("");
            },
            error: error => {
                console.error(error)
                loadAlert("error", `An error occurred while deleting the user<br>${error.responseJSON.error}`);
            }
        });
    }
</script>