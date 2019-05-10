<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/27
 * Time: 10:28
 */
namespace app\commands;
use yii\console\controller;
use Yii;
    class RbacController extends controller
    {
        public function actionInit()
        {
            $auth= Yii::$app->authManager;
            //添加新增文章权限
            $createPost=$auth->createPermission('createPost');
            $createPost->description='新增文章';
            $auth->add($createPost);
            //添加修改文章权限
            $updatePost=$auth->createPermission('updatePost');
            $updatePost->description='修改文章';
            $auth->add($updatePost);
            //添加删除文章权限
            $deletePost=$auth->createPermission('deletePost');
            $deletePost->description='删除文章';
            $auth->add($deletePost);
            //添加审核评论权限
            $approveComment=$auth->createPermission('approveComment');
            $approveComment->description='评论审核';
            $auth->add($approveComment);
            //添加文章管理员 角色并赋予“新增文章”“删除文章”“修改文章权限”
            $postAdmin=$auth->createRole('postAdmin');
            $postAdmin->description='文章管理员';
            $auth->add($postAdmin);
            $auth->addChild($postAdmin,$createPost);
            $auth->addChild($postAdmin,$updatePost);
            $auth->addChild($postAdmin,$deletePost);
            //添加评论审核员 角色并赋予“评论审核”权限
            $commentAuditor=$auth->createRole('commentAuditor');
            $commentAuditor->description='评论审核员';
            $auth->add($commentAuditor);
            $auth->addChild($commentAuditor,$approveComment);
            //添加系统管理员 角色并赋予其他角色拥有的权限
            $admin=$auth->createRole('admin');
            $admin->description='系统管理员';
            $auth->add($admin);
            $auth->addChild($admin,$postAdmin);
            $auth->addChild($admin,$commentAuditor);
            $auth->assign($admin,1);
            $auth->assign($postAdmin,2);
            $auth->assign($commentAuditor,3);



        }
    }