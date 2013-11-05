<div class="container">
    <?php echo $this->Form->create('Admin', array('url' => array('controller' => 'auths', 'action' => 'login'), 'class' => 'form-signin')); ?>
        <?php echo $this->Form->inputs(array(
            'legend' => __('<h2 class="form-signin-heading">Please sign in</h2>'),
            'username' => array('class' => 'form-control', 'placeholder' => 'Username', 'label' => false),
            'password'=> array('class' => 'form-control', 'placeholder' => 'Password', 'label' => false),
        ));
        ?>
    <?php echo $this->Form->end(array('label' => 'Login', 'class' => 'btn btn-lg btn-primary btn-block')); ?>
    <h3 class="form-signin-register"><?php 
    if($register == true)
    {
        echo $this->Html->link('Konto administratora nie istnieje. Stwórz je!', array('controller' => 'auths', 'action' => 'register')); 
    }
    ?></h3>
</div>
