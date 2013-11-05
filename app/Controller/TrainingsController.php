<?php

class TrainingsController extends AppController {   
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
    
    public function edit()
    {
        
    }
    
    public function viewall()
    {
        
    }
    
    public function delete()
    {
        
    }
    
}

?>
