<head>
    <title>Borbo | Админ панель</title>
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <div class="sidebar">
        <ul>
            <li class="active" data-section="users">Users</li>
            <li data-section="events">Events</li>
            <li data-section="balances">Balances</li>
        </ul>
    </div>

    <div class="content">
        <div id="users" class="section active">
            <h1>Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Service</td>
                        <td>Service</td>
                        <td>Male</td>
                        <td>1980-01-01</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>User1</td>
                        <td>User1</td>
                        <td>Male</td>
                        <td>1990-01-01</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>