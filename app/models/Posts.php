<?php

class Posts extends \Phalcon\Mvc\Model
{

    public $id;
    public $title;
    public $body;
   
   
    public function initialize()
    {
        $this->setSchema("user");
        $this->setSource("posts");
    }

   
    public function getSource()
    {
        return 'posts';
    }

 
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

   
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
