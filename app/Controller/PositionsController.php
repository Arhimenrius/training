<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PositionsController
 *
 * @author awojtys
 */
class PositionsController extends AppController{
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }
    
    public function add()
    {
        
    }
    
    public function edit($position_id)
    {
        
    }
    
    public function delete($position_id)
    {
        
    }
    
    public function viewall()
    {
        
    }
}

?>
