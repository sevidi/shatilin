<?php


namespace core\forms\manage\Blog\Post;

use core\entities\User\User;
use core\entities\Blog\Category;
use core\entities\Blog\Post\Post;
use core\forms\CompositeForm;
use core\forms\MetaForm;
use core\validators\SlugValidator;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property MetaForm $meta
 * @property TagsForm $tags
 */

class PostForm extends CompositeForm
{
    public $categoryId;
    public $title;
    public $description;
    public $content;
    public $photo;
    public $viewed;
    public $userId;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->categoryId = $post->category_id;
            $this->userId = $post->user_id;
            $this->title = $post->title;
            $this->description = $post->description;
            $this->content = $post->content;
            $this->viewed = $post->viewed;
            $this->userId = $post->user_id;
            $this->meta = new MetaForm($post->meta);
            $this->tags = new TagsForm($post);
        } else {
            $this->meta = new MetaForm();
            $this->tags = new TagsForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['categoryId', 'title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['categoryId','userId', 'viewed'], 'integer'],
            [['description', 'content'], 'string'],
            [['photo'], 'image'],
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    public function usersList(): array
    {
        return ArrayHelper::map(User::find()->orderBy('id')->asArray()->all(), 'id', 'username');
    }

    protected function internalForms(): array
    {
        return ['meta', 'tags'];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }

}