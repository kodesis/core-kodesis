<div class="table">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr>
                <th>Nip</th>
                <th>Name</th>
                <th>Attendance</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Settings</th>
            </tr>
        </thead>
        <tbody id="studentTableContainer">
            <?php foreach ($users as $user):
                echo "<tr>";
                $username = $user["username"];
                echo "<td hidden>" . $username . "</td>";
                echo "<td>" . $user["nip"] . "</td>";
                echo "<td>" . $user["nama"] . "</td>";
                echo "<td>Absent</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td><span><i class='ri-edit-line edit'></i><i class='ri-delete-bin-line delete'></i></span></td>";
                echo "</tr>";
            endforeach; ?>
        </tbody>
    </table>
</div>