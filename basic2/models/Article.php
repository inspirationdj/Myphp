<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/3
 * Time: 14:21
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $is_deleted
 * @property Category $category
 * @property TagArticleLink[] $tagArticleLinks
 */
class Article extends ActiveRecord
{
    const STATUS_CREATED = 10; // 草稿
    const STATUS_POSTED = 20; // 已发布
    const STATUS_DELETED = 30; // 已刪除

    public static $statusData = [
        self::STATUS_CREATED => '草稿',
        self::STATUS_POSTED => '已发布',
        self::STATUS_DELETED => '已刪除',
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category_id'], 'required'],
            [['content'], 'string'],
            [['category_id', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'category_id' => '分类',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'is_deleted' => '文章状态',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticleLinks()
    {
        return $this->hasMany(TagArticleLink::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*    public function getTags()
        {
            return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
                ->viaTable('tag_article_link', ['article_id' => 'id']);
        }*/
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('tag_article_link', ['article_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getTagNames()
    {
        return $this->getTags()->select(['name'])->column();
    }

    public function getStatusName()
    {
        return array_key_exists($this->is_deleted, static::$statusData) ? static::$statusData[$this->is_deleted] : '未知';
    }

//通过状态表关联得出文章状态 NoUse
    public function getArticle_status()
    {
        return $this->hasOne(articleStatus::className(), ['id' => 'is_deleted']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
                $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }


}