<?php
//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);
//Require the autoload file
require_once('vendor/autoload.php');
require_once('model/validate.php');
//Always start the session after the autoload
session_start();
//Create an instance of the Base class
$f3 = Base::instance();
//Turn on Fat-Free error reporting
$f3->set('DEBUG',3);
$f3->set('options', array('This midterm is easy', 'I like midterms', 'Today is Monday'));
//Define a default route
$f3->route('GET /', function($f3)
{
    //Display a view
    echo "<h1>Midterm Survey</h1>";
    echo "<a href='survey'>Take my Midterm Survey</a>";
});
$f3->route('GET|POST /survey', function($f3) {
    //validate form
    if(!empty($_POST)) {
        //Get data from form
        $name = $_POST['name'];
        $opt = $_POST['opt'];
        //Add data to hive
        $f3->set('name', $name);
        $f3->set('opt', $opt);
        //check data is valid
        if (validForm()) {
            //Write data to Session
            $_SESSION['name'] = $name;
            if (empty($opt)) {
                $_SESSION['opt'] = "No options were selected";
            }
            else {
                $_SESSION['opt'] = implode(', ', $opt);
            }

            $f3->reroute('/summary');
        }
    }
    $view = new Template();
    echo $view->render('views/midterm-survey.html');
});
//Define a summary route
$f3->route('GET /summary', function() {
    //Display summary
    $view = new Template();
    echo $view->render('views/summary.html');
});
//Run fat free
$f3->run();