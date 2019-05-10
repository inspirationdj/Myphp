<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/8
 * Time: 14:26
 */
namespace app\models;
use app\models\Tag;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag_article_link".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $tag_id
 *
 * @property Article $article
 * @property Tag $tag
 */
class TagArticleLink extends ActiveRecord{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_article_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id'=>'文章关联ID',
            'tag_id'=>'标签关联ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}