<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaymentsController
 *
 * @author awojtys
 */
class PaymentsController extends AppController{
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
        $this->autoRender = false;
    }
    
    public function add()
    {
        $this->autoRender = false;
    }
    
    public function edit($id)
    {
        $this->autoRender = false;
        if(!empty($this->request->data['payment_status']))
        {
            $payment = $this->Payment->findById($id);
        
            if($this->Payment->save($this->request->data)){
                return json_encode(true);
            }
            else{
                exit;
            }

            if (!$this->request->data) {
                $this->request->data = $payment;
            }
        }
  
    }
    
    public function delete($id)
    {
        $this->autoRender = false;
    }
    
    public function view($id)
    {
        $this->autoRender = false;
    }
}

?>
