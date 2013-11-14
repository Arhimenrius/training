<?php
//include backbone functions
    echo $this->Html->script(array(
        '/js/collection/training', 
        '/js/model/training', 
        '/js/view/training', 
        '/js/router/training',
        'datepicker',
        'ownscripts'
    ));
    echo $this->Html->css('datepicker');
?>
