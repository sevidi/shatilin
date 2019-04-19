<?php


namespace backend\forms\Blog;

use core\entities\User\User;
use core\entities\Blog\Category;
use core\helpers\PostHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Blog\Post\Post;
use yii\helpers\ArrayHelper;

class PostSearch extends Model
{
    public $id;
    public $title;
    public $status;
    public $category_id;
    public $user_id;



    public function rules(): array
    {
        return [
            [['id', 'status', 'category_id', 'user_id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'user_id' => $this->user_id,

        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'title');
    }

    public function usersList(): array
    {
        return ArrayHelper::map(User::find()->orderBy('id')->asArray()->all(), 'id', 'username');
    }

    public function statusList(): array
    {
        return PostHelper::statusList();
    }

}