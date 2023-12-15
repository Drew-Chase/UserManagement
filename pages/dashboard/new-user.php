<style>
    h1 {
        font-size: 4rem;
        margin: 0;
    }
</style>

<?php
$edit = isset($_REQUEST["id"]);
$id = "";
if ($edit) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/db/auth.inc.php";
    $auth = new Authentication();
    $id = $_REQUEST["id"];
    $id = explode("=", $id)[1];
    $user = $auth->get($id)["user"];
    if (!$user) {
        echo "<h1>User not found</h1>";
        return;
    }
}
?>

<div class="col fill" id="user-list">
    <div class="list-header col center vertical island">
        <h1 class="fill"><?php echo $edit ? "Edit User" : "Add New User";  ?></h1>
    </div>
    <div id="add-new-user-form" class="list island fill">
        <form action="javascript:void(0);" class="col">
            <div class="floating-input">
                <input type="text" name="username" placeholder="" autocomplete="username" required value="<?php echo $edit ? $user["username"] : ""; ?>">
                <label for="username">Username</label>
            </div>
            <div class="floating-input">
                <input type="password" name="password" placeholder="" autocomplete="new-password" <?php $edit ? "" : "required" ?> title="Password must contain at least 8 characters, including one number, one lowercase, and one uppercase letter">
                <label for="password"><?php echo $edit ? "New " : ""; ?>Password</label>
            </div>
            <!-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
            <div class="floating-input">
                <input type="password" name="confirm-password" placeholder="" autocomplete="off" <?php $edit ? "" : "required" ?>  title="Password must contain at least 8 characters, including one number, one lowercase, and one uppercase letter">
                <label for="confirm-password">Confirm<?php echo $edit ? " New" : ""; ?> Password</label>
            </div>

            <h2>Permissions</h2>
            <div class="row" style="flex-wrap:wrap">
                <?php
                require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/db/auth.inc.php";
                $perms = Authentication::getPermissionMap();
                foreach ($perms as $value => $key) {
                    $value = preg_replace('/(?<!\ )[A-Z]/', ' $0', $value);
                    $active = $edit ? (in_array($key, $user["permissions"]) ? "true" : "false") : "false";
                    if ($key == 0) {
                        echo "<toggle permission='$key' style='width: 20%' value='$active'>$value</toggle>";
                    } else {
                        if ($key == 1) {
                            echo "<div id='other-permissions' class='row' style='flex-wrap: wrap;'>";
                        }
                        echo "<toggle permission='$key' style='width: 25%; margin-right: 4rem;' value='$active'>$value</toggle>";
                    }
                }
                echo "</div>";
                ?>
            </div>

            <button type="submit" class="center horizontal vertical" style="margin: 1rem auto;">
                <?php
                if ($edit) {
                    echo "Save Changes";
                } else {
                    echo "<i class=\"fa-solid fa-plus\"></i>Add New User";
                }
                ?>
            </button>
        </form>
    </div>
</div>

<script>
    if ($("#add-new-user-form toggle[permission='0']").attr("value") == "true") {
        $("#add-new-user-form toggle:not([permission='0'])").hide();
        $("#add-new-user-form toggle:not([permission='0'])").attr('value', false)
    }

    $("#add-new-user-form toggle[permission='0']").on('toggle', (e, value) => {
        value = value.value;
        if (value == true) {
            $("#add-new-user-form toggle:not([permission='0'])").hide();
            $("#add-new-user-form toggle:not([permission='0'])").attr('value', false)
        } else {
            $("#add-new-user-form toggle").show()
        }
    })

    $("#add-new-user-form form").on('submit', async () => {
        let username = $("#add-new-user-form input[name='username']").val();
        let password = $("#add-new-user-form input[name='password']").val();
        let confirmPassword = $("#add-new-user-form input[name='confirm-password']").val();
        let permissions = [];
        $("#add-new-user-form toggle[value=true]").each((i, e) => {
            permissions.push(Number.parseInt($(e).attr('permission')));
        })

        if (permissions.length == 0) {
            loadAlert("error", "You must select at least one permission");
            return;
        }

        if (password != confirmPassword) {
            loadAlert("error", "Passwords do not match")
            return;
        }

        let data = {
            username,
            password,
            permissions
        }

        if (<?php echo $edit ? "true" : "false"; ?>) {
            data.id = "<?php echo $id; ?>";
        }

        console.log(JSON.stringify(data))
        await $.ajax("/api/auth.php", {
            method: "PATCH",
            data: JSON.stringify(data),
            success: async e => {
                if (e.error) {
                    loadAlert("error", `An error occurred while adding the user<br>${e.error}`);
                    console.error(JSON.stringify(e))
                    return;
                }
                if (!(await auth.loginWithToken()).success) {
                    loadAlert("INFO", "You are no longer logged in. Please re-login", (_) => {
                        window.location.href="/"
                    }, (_) => {
                        window.location.href="/"
                    })
                } else {

                    <?php
                    if ($edit) {
                        echo "loadAlert(\"success\", \"User updated successfully\");";
                    } else {
                        echo "loadAlert(\"success\", \"User added successfully\");";
                    }
                    ?>
                    loadPage("");
                }
            },
            error: e => {
                loadAlert("error", `An error occurred while adding the user<br>${e.responseText}`);
                console.error(JSON.stringify(e))
                return;
            }
        })
    })
</script>