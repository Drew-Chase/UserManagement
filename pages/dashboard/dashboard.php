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
        transition: background 100ms;
    }

    #user-list .list .user-item:hover {
        background: hsla(0, 0%, 100%, 0.1);
        cursor: pointer;
    }
</style>

<div class="col fill" style="padding: 1rem">
    <h1 class="page-title">Dashboard</h1>

    <div class="col fill" id="user-list">
        <div class="list-header row center vertical">
            <h2 class="fill">Users</h2>
            <button class="secondary" id="add-user" onclick="loadPage('new-user')">Add User</button>
        </div>
        <div class="list">
        </div>
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
                        <button onclick="editUser(${user.id})" title="Modify the user"><i class="fa-solid fa-pen"></i></button>
                        <button class="secondary" onclick="deleteUser(${user.id})" title="Delete the user"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `);
        });
    })();
</script>