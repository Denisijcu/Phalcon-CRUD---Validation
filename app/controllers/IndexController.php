<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->posts = Posts::find();
      
      $this->view->test = 'Hello';
    }

    public function searchAction()
    {
        $posts = Post::find();
        $currentPage = $page;
        $paginator = new PaginatorModel( [ "data" => $users, "limit" => 10, "page" => $currentPage, ] );
       // Get the paginated results 
        $page = $paginator->getPaginate();
        $page->total_pages = count($posts);
        $this->view->page = $page;

    }

}

