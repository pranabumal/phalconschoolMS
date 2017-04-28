<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class StudentsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for students
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Students', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "StudentID";

        $students = Students::find($parameters);
        if (count($students) == 0) {
            $this->flash->notice("The search did not find any students");

            $this->dispatcher->forward([
                "controller" => "students",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $students,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a student
     *
     * @param string $StudentID
     */
    public function editAction($StudentID)
    {
        if (!$this->request->isPost()) {

            $student = Students::findFirstByStudentID($StudentID);
            if (!$student) {
                $this->flash->error("student was not found");

                $this->dispatcher->forward([
                    'controller' => "students",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->StudentID = $student->StudentID;

            $this->tag->setDefault("StudentID", $student->StudentID);
            $this->tag->setDefault("LastName", $student->LastName);
            $this->tag->setDefault("FirstName", $student->FirstName);
            $this->tag->setDefault("Address", $student->Address);
            $this->tag->setDefault("City", $student->City);
            
        }
    }

    /**
     * Creates a new student
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'index'
            ]);

            return;
        }

        $student = new Students();
        $student->LastName = $this->request->getPost("LastName");
        $student->FirstName = $this->request->getPost("FirstName");
        $student->Address = $this->request->getPost("Address");
        $student->City = $this->request->getPost("City");
        

        if (!$student->save()) {
            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("student was created successfully");

        $this->dispatcher->forward([
            'controller' => "students",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a student edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'index'
            ]);

            return;
        }

        $StudentID = $this->request->getPost("StudentID");
        $student = Students::findFirstByStudentID($StudentID);

        if (!$student) {
            $this->flash->error("student does not exist " . $StudentID);

            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'index'
            ]);

            return;
        }

        $student->LastName = $this->request->getPost("LastName");
        $student->FirstName = $this->request->getPost("FirstName");
        $student->Address = $this->request->getPost("Address");
        $student->City = $this->request->getPost("City");
        

        if (!$student->save()) {

            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'edit',
                'params' => [$student->StudentID]
            ]);

            return;
        }

        $this->flash->success("student was updated successfully");

        $this->dispatcher->forward([
            'controller' => "students",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a student
     *
     * @param string $StudentID
     */
    public function deleteAction($StudentID)
    {
        $student = Students::findFirstByStudentID($StudentID);
        if (!$student) {
            $this->flash->error("student was not found");

            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'index'
            ]);

            return;
        }

        if (!$student->delete()) {

            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "students",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("student was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "students",
            'action' => "index"
        ]);
    }

}
