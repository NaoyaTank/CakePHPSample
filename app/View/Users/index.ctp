<h1>Users</h1>
<table>
    <tr>
        <th>Id</th>
        <th>username</th>
        <th>created</th>
        <th>actions</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $user['User']['username'];?>
        </td>
        <td>
            <?php echo $user['User']['created']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>