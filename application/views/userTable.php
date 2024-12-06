<div class="table">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Attendance</th>
                <th>Settings</th>
            </tr>
        </thead>
        <tbody id="studentTableContainer">
            <?php foreach ($users as $user):
                echo "<tr>";
                $username = $user["username"];
                echo "<td>" . $username . "</td>";
                echo "<td>" . $user["nama"] . "</td>";
                echo "<td>Absent</td>";
                echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
                echo "</tr>";
            endforeach; ?>
        </tbody>
    </table>
</div>