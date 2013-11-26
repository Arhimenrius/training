<?php
//include backbone functions
    echo $this->Html->script(array(
        'valid',
        '/js/collection/training', 
        '/js/model/training', 
        '/js/collection/payment', 
        '/js/model/payment', 
        '/js/collection/record', 
        '/js/model/record', 
        '/js/view/record', 
        '/js/router/record'
    ));
?>
