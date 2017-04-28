<?php

class SignupController extends ControllerBase
{

    public function indexAction()
    {

    }
    public function registerAction()
    {
        $user = new Users();
        $success=$user->save($this->request->getPost(),
            [
                "name",
                "email"
            ]
        );
        if ($success){
            $this->flash->success("SuccessFully Register");
        }
        else{
            $this->flash->error("Sorry, the following problems were generated:");
            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
        $this->dispatcher->forward([
            'controller' => "signup",
            'action' => 'index'
        ]);
    }

}

