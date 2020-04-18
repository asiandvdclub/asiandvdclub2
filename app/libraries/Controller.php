<?php
/*
 * Base Controller
 * Loads the models and views
 */
class Controller{
    // Load model
    /***
     * @param $model Usage 'name' or 'folder/name'
     * @return mixed
     */
    protected function model($model){
        // Require model file
        require_once '../app/models/' . $model . '.php';
        // Instanticate model
        return new $model;
    }
    // Load view
    /***
     * @param $view Usage 'name' or 'folder/name'
     * @return mixed
     */
    protected function view($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            // Require model file
            require_once '../app/views/' . $view . '.php';
        }else{
            die("View doesn't exists");
        }
    }
    // Load special models
    /***
     * @param $model Usage 'name' or 'folder/name' $data Data
     * @return mixed
     */
    protected function dataModel($model, array $data = []){
        // Require model file
        require_once '../app/models/' . $model . '.php';
        // Instanticate model
        return new $model($data);
    }
}