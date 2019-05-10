<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 14:37
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 *
 * @property TagArticleLink[] $tagArticleLinks
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '标签ID',
            'name' => '标签名称',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticleLinks()
    {
        return $this->hasMany(TagArticleLink::className(), ['tag_id' => 'id']);
    }

    public function getTagid()
    {
        return $this->hasMany(TagArticleLink::className(), ['tag_id' => 'id']);
    }

}