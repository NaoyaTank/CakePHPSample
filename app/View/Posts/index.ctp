<h3>
    <?php echo "Hello ", h($auth->user('username')), "!", " What are you doing now?" ?>
</h3>

<?php
    echo $this->Form->create('Post', array('action' => 'add'));
    echo $this->Form->input('body', array('rows' => '3', 'label' => false));
    echo $this->Form->end('Post!');
?>

<div class="container">
    <?php foreach ($posts as $post): ?>
        <div class='each-post'>
            <div class='user-img'>
                <?php echo $this->Html->image($this->Image->img_path($post['User']['img_name']), 
                                                                     array('width'=>'36', 'height' => '36'))?>
            </div>
            <div class='post-msg'>                                                               
                <?php echo h($post['Post']['body']), ' (', h($post['User']['username']), ')' ?>
            </div>
            <div class='post-time'>
                <?php echo h($post['Post']['created']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
