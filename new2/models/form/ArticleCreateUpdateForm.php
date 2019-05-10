<?php

namespace app\models\form;

use app\models\Adminuser;
use yii\base\Model;
use app\models\Article;
use app\models\Tag;
use app\models\ArticleTagLink;

class ArticleCreateUpdateForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $status;
    public $category_id;
    public $tags;
    public $aid;

    public function rules()
    {
        return [
            [['title', 'content', 'category_id', 'status'], 'required'],
            [['content', 'tags'], 'string'],
            [['category_id', 'status','aid'], 'integer'],
            [['title'], 'string', 'max' => 15],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
            'status' => '文章状态',
            'category_id' => '分类',
            'tags' => '标签',
            'aid' => '操作者',

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
            $this->status = $article->status;
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
        $article->status = $this->status;
        $article->aid = \Yii::$app->user->identity->getId();
        $article->save();

//        print_r($arr=$article->errors);exit;

        $tags = explode(',', $this->tags);
        //过滤tags数组重复的标签得到unique
        $tagsUnique = array_unique($tags);
        $TagModel = Tag::find()->where(['name' => $tagsUnique])->indexBy('name')->all();
        //存放tag ID 的数组
        $tagIds = [];
        foreach ($tagsUnique as $Tag) {
            if (!isset($TagModel[$Tag])) {
                $tag = new Tag(['name' => $Tag]);
                $tag->save(false);
            } else {
                $tag = $TagModel[$Tag];
            }
            $tagIds[] = $tag->id;
        }
        if ($this->id) {
            ArticleTagLink::deleteAll(['article_id' => $article->id]);
        }

        $row = [];
        foreach ($tagIds as $tagId) {
            $row[] = [
                'article_id' => $article->id,
                'tag_id' => $tagId,
            ];
        }

        if ($row) {
            ArticleTagLink::getDb()
                ->createCommand()
                ->batchInsert(ArticleTagLink::tableName(), array_keys($row[0]), $row)
                ->execute();
        }

        return $article;
    }
}