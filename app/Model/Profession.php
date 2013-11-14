<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Position
 *
 * @author awojtys
 */
class Profession extends AppModel{
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A profession is required'
            )
        )
    );
}

?>
