<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $aid
 * @property string $title
 * @property string $content
 * @property integer $category_id
 * @property integer $status
 * @property integer $create_at
 * @property integer $update_at
 *
 * @property Category $category
 * @property Adminuser $adminuser
 * @property ArticleTagLink[] $articleTagLinks
 */
class Article extends ActiveRecord
{
    const CREATED = 10;//已发布
    const DELETED = 20;//已删除

    public static $statusData = [
        self::CREATED => '已发布',
        self::DELETED => '已删除',
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
            [['title', 'content', 'category_id', 'status'], 'required'],
            [['content'], 'string'],
            [['category_id', 'status','aid'], 'integer'],
            [['title'], 'string', 'max' => 15],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],

            [
                ['aid'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Adminuser::className(),
                'targetAttribute' => ['aid' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章ID',
            'title' => '标题',
            'content' => '文章内容',
            'category_id' => '分类ID',
            'status' => '文章状态',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'aid' => '作者',
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
    public function getArticleTagLinks()
    {
        return $this->hasMany(ArticleTagLink::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable(ArticleTagLink::tableName(), ['article_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getStatusNames()
    {
        return isset(static::$statusData[$this->status]) ? static::$statusData[$this->status] : '未标注状态';
    }

    /**
     * @return array
     */
    public function getTagNames()
    {
        return $this->getTags()->select(['name'])->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminuser()
    {
        return $this->hasOne(Adminuser::className(),['id' => 'aid']);
    }

    public function getAdminuserName()
    {
        return $this->getAdminuser()->select(['username'])->scalar();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_at = time();
                $this->update_at = time();
            } else {
                $this->update_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
