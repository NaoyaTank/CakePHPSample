<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username', array('required' => false));
        echo $this->Form->input('email', array('required' => false));
        echo $this->Form->input('password', array('required' => false, 'email' => false));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
