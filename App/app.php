<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    //SQL Server
    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Twig Path
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

    //Route and Controller
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });


    $app->get("/tasks", function() use ($app) {

      $all_tasks = Task::getAll();

      return $app['twig']->render('tasks.html.twig', array('tasks' => $all_tasks));

    });

    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    //Post Get Methods

    $app->post("/categories", function() use($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('create_category.html.twig', array('newcategory' => $category));
    });


    $app->post("/tasks", function() use ($app) {
      $task = new Task($_POST['description']);
      $task->save();
      return $app['twig']->render('create_task.html.twig', array('newtask' => $task));

    });

    //POST delete Methods
    $app->post("/delete_tasks", function() use ($app) {

        Task::deleteAll();

        return $app['twig']->render('delete_tasks.html.twig');
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('delete_categories.html.twig');
    });

    return $app;
?>
