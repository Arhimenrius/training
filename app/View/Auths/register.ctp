<div class="container">
<?php echo $this->Form->create('Admin', array('url' => array('controller' => 'auths', 'action' => 'register'), 'class' => 'form-signin')); ?>
    <fieldset>
        <legend><?php echo __('<h2 class="form-signin-heading">Register Admin</h2>'); ?></legend>
        <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Username', 'label' => false));
        echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'label' => false));
        echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin'),
            'class' => 'form-control', 
            'placeholder' => 'Username', 
            'label' => false
        ));
    ?>
    </fieldset>
    <br /><br />
<?php echo $this->Form->end(array('label' => 'Register', 'class' => 'btn btn-lg btn-primary btn-block')); ?>
</div>