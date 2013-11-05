<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentsController
 *
 * @author awojtys
 */
class StudentsController extends AppController{
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
    
    public function viewdetail($student_id)
    {
        
    }
}

?>
