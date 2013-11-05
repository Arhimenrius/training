<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
 *
 * @author awojtys
 */
class AuthsController extends AppController {
    var $uses = array('Admin');
    public function beforeFilter() 
    {
        $this->Auth->deny('login');
        parent::beforeFilter();
        $this->Auth->allow('register');
        
        if($this->Auth->user('id') != null && $this->action == 'login')
        {
            $this->redirect('/admins');
        }
        
    }
    
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }

    public function login()
    {   
        $admin = $this->Admin->find();
        if(empty($admin))
        {
            $this->set('register', true);
        }
        else
        {
            $this->set('register', false);
        }
        if ($this->request->is('post')) 
        {
            if ($this->Auth->login()) 
            {
                return $this->redirect($this->Auth->redirect());
            }
            
            $this->Session->setFlash(__('Your username or password was incorrect.'));
        }
    }
    
    public function register()
    {
        if ($this->request->is('post')) {
            $this->Admin->create();
            var_dump($this->request->data);
            if ($this->Admin->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
    }
    
    public function logout() 
    {
        return $this->redirect($this->Auth->logout());
    }
}

?>
