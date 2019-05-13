<?php
function validForm()
{
    global $f3;
    $isValid = true;
    if (!validName($f3->get('name'))) {
        $isValid = false;
        $f3->set("errors['name']", "Please enter your name");
    }
    if (!validOptions($f3->get('opt'))) {
        $isValid = false;
        $f3->set("errors['opt']", "No options were selected");
    }
    return $isValid;
}// check for valid name
function validName($name)
{
    return !empty($name) && ctype_alpha($name);
}
function validOptions($opt)
{
    global $f3;
    //options are not required
    if (empty($opt)) {
        return false;
    }
    //make sure options are valid
    foreach ($opt as $option) {
        if (!in_array($option, $f3->get('options'))) {
            return false;
        }
    }

    return true;
}