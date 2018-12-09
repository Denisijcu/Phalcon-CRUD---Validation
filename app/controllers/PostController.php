<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel; 
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray; 
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class PostController extends ControllerBase
{

    public function indexAction()
    {
      
    }

    public function newAction()
    {

    }
    
    /**
     * Edits a blog
     *
     * @param string $BlogID
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $blog = Posts::findFirstById($id);
            if (!$blog) {
                $this->flash->error("blog was not found");

                $this->dispatcher->forward([
                    'controller' => "post",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $blog->id;

            $this->tag->setDefault("id", $blog->id);
            $this->tag->setDefault("title", $blog->title);
            $this->tag->setDefault("body", $blog->body);
            
        }
    }

    /**
     * Saves a blog edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $post = Posts::findFirst($id);

        if (!$post) {
            $this->flash->error("Post does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'index'
            ]);

            return;
        }

        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
       
        

        if (!$post->save()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'edit',
                'params' => [$post->id]
            ]);

            return;
        }

        $this->flash->success("post was updated successfully");

        $this->dispatcher->forward([
            'controller' => "post",
            'action' => 'index'
        ]);
    }


    /**
     * Creates a new blog
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'index'
            ]);

            return;
        }

        $blog = new Posts();
        $blog->title = $this->request->getPost("title");
        $blog->body = $this->request->getPost("body");
     
        

        if (!$blog->save()) {
            foreach ($blog->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Post was created successfully");

        $this->dispatcher->forward([
            'controller' => "post",
            'action' => 'index'
        ]);  
    }

    /**
     * Deletes a blog
     *
     * @param string $BlogID
     */
    public function deleteAction($id)
    {
        $post = Posts::findFirst($id);

        if (!$post) {
            $this->flash->error("post was not found");

            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'index'
            ]);

            return;
        }
       
        if (!$post->delete()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "post",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("post was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "post",
            'action' => "index"
        ]);
    }



}

