<?php


namespace core\services\manage\Blog;

use core\entities\Meta;
use core\entities\Blog\Category;
use core\forms\manage\Blog\CategoryForm;
use core\repositories\Blog\CategoryRepository;

class CategoryManageService
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param CategoryForm $form
     * @return Category
     */
    public function create(CategoryForm $form): Category
    {
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->categories->save($category);
        return $category;
    }

    /**
     * @param $id
     * @param CategoryForm $form
     */
    public function edit($id, CategoryForm $form): void
    {
        $category = $this->categories->get($id);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->categories->save($category);
    }

    public function remove($id): void
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }

}