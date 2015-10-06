<h1>Edit your Profile</h1>
<?php
echo $this->Form->create('User', array('type'=>'file', 'enctype' => 'multipart/form-data'));
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->input('image', array('type' => 'file', 'multiple'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Post');
?>
