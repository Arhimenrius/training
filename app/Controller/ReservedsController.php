<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReservedsController
 *
 * @author awojtys
 */
class ReservedsController extends AppController
{
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }
    
    public function viewall()
    {
        
    }
    
    public function index()
    {
        
    }
    
    public function add()
    {
        
    }
    
    public function edit($id)
    {
        
    }
    
    public function delete($id)
    {
        
    }
    
    public function view($id)
    {
        
    }
    
}

?>
