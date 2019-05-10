<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/12
 * Time: 9:17
 */
namespace  frontend\components;
use yii\base\Widget;
use yii\helpers\Html;

class RctReplyWidget extends  Widget
{
    public $recentComments;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $commentString='';
        foreach($this->recentComments as $comment)
        {
            $commentString.='<div class="post">'.
                            '<p class="title">'.
                            '<p style="color: #777777;font-style:italic;"></p>'.
                            nl2br($comment->content).'</p>'.
                            '<p style="font-size:8pt;color:blue">《<a href="'.$comment->post->url.'">'.Html::encode($comment->post->title).'</a>》</p>'.
                '<hr></div></div>';
        }
        return $commentString;
    }
}