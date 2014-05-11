<?php
// app/Controller/UsersController.php

//App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class UsersController extends AppController {
public $uses = array('User');


    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout','complete');
    }

    public function index() {
        $this->redirect(array('controller' => 'ehons','action' => 'index'));

    }

public function login() {

}

public function logout() {
    $this->Auth->logout();
    $this->redirect(array('controller' => 'ehons','action' => 'index'));
}

   public function complete() {
    if(is_null($this->Auth->user()) && !is_null($this->data)){
        if($this->data['auth']['provider']=='Facebook'){
            $user=$this->User->find('first',array(
                 'conditions' => Array(
                    'provider' => $this->data['auth']['provider'],
                    'provider_uid' => $this->data['auth']['uid']
                    ),
                ));
            if(!isset($user['User']) && isset($this->data['auth'])){
                // new user
                $udata = array('User' => array(
                    'provider' => $this->data['auth']['provider'],
                    'provider_uid' => $this->data['auth']['uid'],
                    'name' => isset($this->data['auth']['info']['nickname'])?$this->data['auth']['info']['nickname']:$this->data['auth']['info']['last_name'],
                    'photo_path' => $this->data['auth']['info']['image'],
                    'contact_url' => $this->data['auth']['info']['urls']['facebook']
                    ));
                $user=$this->User->save($udata);
            }
            if(isset($user) && isset($user['User']))
                if($this->Auth->login($user['User'])){
                    $this->redirect(array('controller' => 'ehons','action' => 'index'));
                }else{
                    $this->redirect(array('controller' => 'ehons','action' => 'index'));
                }
        }
    }
    $this->redirect(array('controller' => 'ehons','action' => 'index'));
   }

}