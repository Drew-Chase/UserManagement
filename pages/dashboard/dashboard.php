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
            <select name="" id="" style="min-width:fit-content; width: 15%; margin-right: 1rem;">
                <option value="" disabled selected>Filter by Permissions</option>
                <option value="">All</option>
                <option value="">Admin</option>
                <option value="">User</option>
            </select>
            <button onclick="editUser()" class="secondary" title="Filter the results" style="height: 100%;"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
        </div>
    </div>
    <div class="list island">
    </div>
</div>

<script>
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
                        <button onclick="editUser('${user.id}')" title="Modify the user"><i class="fa-solid fa-pen"></i></button>
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
                if(e.error) {
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