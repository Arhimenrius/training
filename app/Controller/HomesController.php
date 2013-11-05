<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author awojtys
 */
class HomesController extends AppController {
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function index()
    {
    }
    
    public function contact()
    {
        
    }
}

?>
