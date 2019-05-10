<?php

namespace app\models\form;


use app\models\Article;
use app\models\Tag;
use app\models\TagArticleLink;
use yii\base\Model;
use Yii;


class ArticleCreateUpdateForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $category_id;
    public $tags;
    public $is_deleted;

    public function rules()
    {
        return [
            [['title', 'content','category_id', 'tags','is_deleted'], 'required'],
            [['title', 'content', 'tags'], 'string'],
            [['category_id','is_deleted'], 'integer'],
            ['title','string','max'=>30],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content'=>'内容',
            'tags'=>'标签',
            'category_id'=>'分类',
            'is_deleted'=>'状态',
        ];
    }

    /**
     * @var Article
     */
    private $article;

    public function init()
    {
        if ($this->id) {
            $article = Article::findOne($this->id);
            $this->title = $article->title;
            $this->content = $article->content;
            $this->category_id = $article->category_id;
            $this->is_deleted = $article->is_deleted;
            $this->tags = implode(',', $article->getTagNames());

            $this->article = $article;
        } else {
            $this->article = new Article();
        }
    }

    public function create()
    {
        $article = $this->article;
        $article->title = $this->title;
        $article->content = $this->content;
        $article->category_id = $this->category_id;
        $article->is_deleted= $this->is_deleted;
       $article->save();

//        if (!$isValid) {
//        $arr=$article->errors;
//        print_r($arr);
//        return false;

  //  }
        // php,JAVA,KA
        $tags = explode(',', $this->tags);
        $unique = array_unique($tags);
        $tagModels = Tag::find()->where(['name' => $unique])->indexBy('name')->all();
        print_r($tagModels);
        $tagIds = [];
        foreach ($unique as $tag) {
            if (!isset($tagModels[$tag])) {
                $tagModel = new Tag([
                    'name' => $tag
                ]);
                $tagModel->save(false);
            } else {
                $tagModel = $tagModels[$tag];
            }
            $tagIds[] = $tagModel->id;
        }
        /*$tags = explode(',', $this->tags);
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagModel = Tag::findOne(['name' => $tag]);
            if (!$tagModel) {
                $tagModel = new Tag([
                    'name' => $tag
                ]);
                $tagModel->save(false);
            }
            $tagIds[] = $tagModel->id;
        }*/

        if ($this->id) {
            TagArticleLink::deleteAll(['article_id' => $article->id]);
        }

        $rows = [];
        foreach ($tagIds as $tagId) {
            $rows[] = [
                'article_id' => $article->id,
                'tag_id' => $tagId,
            ];
        }
        if ($rows) {
            TagArticleLink::getDb()->createCommand()->batchInsert(TagArticleLink::tableName(), array_keys($rows[0]), $rows)->execute();
        }
        /*foreach ($tagIds as $tagId) {
            $link = new TagArticleLink([
                'article_id' => $article->id,
                'tag_id' => $tagId,
            ]);
            $link->save(false);
        }*/

        return $article;
    }
}