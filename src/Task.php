<?php


    class Task
    {
        private $description;
        private $id;

        //Constructor
        function __construct($description, $id = null)
        {
            $this->description = $description;
            $this->id = $id;
        }

        //Setter
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        //Getter
        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        //Calls a save method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO tasks (description)                                   VALUES('{$this->getDescription()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Getter - Static method
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();

            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
          }
            return $tasks;
        }

        //Static Method - Deletes Tasks
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }

    }
 ?>
