<table>
    <tr>
        <th>profile image</th>
        <th>username</th>
        <th>email</th>
        <th>password</th>
        <th>actions</th>
    </tr>

    <tr>
        <td>
            <?php echo $this->Html->image($this->Image->img_path($user['User']['img_name']), 
                                          array('width'=>'36', 'height' => '36'))?>
        </td>
        <td><?php echo h($user['User']['username']); ?></td>
        <td><?php echo h($user['User']['email']);?></td>
        <td>Your password isn't displaied for security</td>
        <td>
            <?php
                echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])), '&nbsp', '&nbsp';
                echo $this->Html->link('Log out', array('controller' => 'users', 'action' => 'logout')), '&nbsp', '&nbsp';
            ?>
        </td>
    </tr>
</table>

<div class='delete-button'>
    <?php echo $this->Form->postLink('Delete account',array(
                                                            'action'=>'delete',
                                                            $auth->user('id')),
                                                            array(),'Are you sure to delete your account?');
    ?>
</div>
