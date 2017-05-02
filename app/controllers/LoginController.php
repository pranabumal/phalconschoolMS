<?php
use Phalcon\Mvc\Model\Criteria;

class LoginController extends ControllerBase
{

    public function indexAction()
    {

    }
    public function loginCheckAction()
    {

        if ($this->request->isPost()) {

            $users = Users::find($_POST);

        }
        if (!$users) {
            $this->flash->notice("No Users");

            $this->dispatcher->forward([
                "controller" => "login",
                "action" => "index"
            ]);
            return;
        }
        else {
            $this->flash->notice("Successfully Login");

            $this->dispatcher->forward([
                "controller" => "students",
                "action" => "index"
            ]);
        }


    }

}

