<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MaterialsController
 *
 * @author awojtys
 */
class MaterialsController extends AppController{
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
    
    public function edit($material_id)
    {
        
    }
    
    public function delete($material_id)
    {
        
    }
    
    public function showall()
    {
        
    }
}

?>
