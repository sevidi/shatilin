<?php


namespace core\services\manage\Blog;

use core\entities\Meta;
use core\entities\Blog\Post\Post;
use core\entities\Blog\Tag;
use core\forms\manage\Blog\Post\PostForm;
use core\repositories\Blog\CategoryRepository;
use core\repositories\Blog\PostRepository;
use core\repositories\Blog\TagRepository;
use core\repositories\UserRepository;
use core\services\TransactionManager;

class PostManageService
{
    private $posts;
    private $users;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct(
        PostRepository $posts,
        UserRepository $users,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction
    )
    {
        $this->posts = $posts;
        $this->users = $users;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
    }
    public function create(PostForm $form): Post
    {
        $category = $this->categories->get($form->categoryId);
        $user = $this->users->get($form->userId);

        $post = Post::create(
            $category->id,
            $user->id,
            $form->viewed,
            $form->title,
            $form->description,
            $form->content,


            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if ($form->photo) {
            $post->setPhoto($form->photo);
        }
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $post->assignTag($tag->id);
        }
        $this->transaction->wrap(function () use ($post, $form) {
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $post->assignTag($tag->id);
            }
            $this->posts->save($post);
        });
        return $post;
    }
    public function edit($id, PostForm $form): void
    {
        $post = $this->posts->get($id);
        $category = $this->categories->get($form->categoryId);
        $user = $this->users->get($form->userId);

        $post->edit(
            $category->id,
            $user->id,
            $form->viewed,
            $form->title,
            $form->description,
            $form->content,

            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if ($form->photo) {
            $post->setPhoto($form->photo);
        }
        $this->transaction->wrap(function () use ($post, $form) {
            $post->revokeTags();
            $this->posts->save($post);
            foreach ($form->tags->existing as $tagId) {
                $tag = $this->tags->get($tagId);
                $post->assignTag($tag->id);
            }
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $post->assignTag($tag->id);
            }
            $this->posts->save($post);
        });
    }
    public function activate($id): void
    {
        $post = $this->posts->get($id);
        $post->activate();
        $this->posts->save($post);
    }
    public function draft($id): void
    {
        $post = $this->posts->get($id);
        $post->draft();
        $this->posts->save($post);
    }
    public function remove($id): void
    {
        $post = $this->posts->get($id);
        $this->posts->remove($post);
    }

}