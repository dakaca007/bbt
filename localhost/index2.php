<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>用户注册与管理</title>
</head>
<body>
    <h2>用户注册/更新表单</h2>
    <form action="" method="POST">
        <input type="hidden" name="user_id" id="user_id" value="">
        <label for="username">用户名:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">邮箱:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">密码:</label><br>
        <input type="password" id="password" name="password"><br><br> <!-- 密码更新可选 -->
        <input type="submit" name="action" value="注册/更新">
    </form>

    <h2>当前用户列表</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>操作</th>
        </tr>
        <?php
        // 显示用户列表
        require_once 'Database.php';
        $db = new Database();
        $conn = $db->connect();
        $users = $db->select('users');

        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user['id']}</td>
                    <td>{$user['username']}</td>
                    <td>{$user['email']}</td>
                    <td>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='user_id' value='{$user['id']}'>
                            <input type='hidden' name='username' value='{$user['username']}'>
                            <input type='hidden' name='email' value='{$user['email']}'>
                            <input type='submit' name='action' value='编辑'>
                        </form>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='user_id' value='{$user['id']}'>
                            <input type='submit' name='action' value='删除' onclick='return confirm('确认删除吗?');'>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
