<?php

namespace app\controllers;

use app\common\models\BasicSearchModel;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\Controller;
use app\common\traits\UserLanguageTrait;

class BaseController extends Controller
{
    use UserLanguageTrait;

    public $title;
    public $modelClass;
    public $searchClass;

    public function beforeAction($action)
    {
        if (\Yii::$app->getUser()->getIsGuest()) {
            $this->redirect(['/site/login']);
            return false;
        }

        if (parent::beforeAction($action)) {
            $this->setUserLanguage();
            return true;
        }

        return false;
    }

    public function actionList()
    {
        /* @var $searchModel BasicSearchModel*/
        $searchClass = $this->searchClass;
        $searchModel = new $searchClass();

        $query = $searchModel->search();

        $data = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $renderParams = [
            'title' => $this->getTitle(),
            'data' => $data,
            'relatedData' => $this->getRelatedData(),
        ];

        return $this->render('list', $renderParams);
    }

    public function actionUpdate($id)
    {
        /* @var $model ActiveRecord*/
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($id);

        if (!$model) {
            $model = new $modelClass;
        }


        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                if ($id == 0) {
                    $this->redirect($this->getActionUrl($model->getPrimaryKey()));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'relatedData' => $this->getRelatedData($id),
            'title' => $this->getTitle(),
        ]);
    }


    public function actionDelete($id)
    {
        /* @var $model ActiveRecord*/
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($id);

        if ($model->delete()) {
            $module = $this->action->controller->module->id;
            $controller = $this->action->controller->id;

            $url = ($module == 'app' ? '' : '/' . $module) . '/' . $controller . '/search';

            return $this->redirect($url);
        } else {
            throw new Exception('Unable to delete model ' . $modelClass . 'with id' . $id);
        }
    }

    public function getTitle()
    {
        return \Yii::t($this->action->controller->module->id, $this->title);
    }

    public function getRelatedData()
    {
        return [];
    }

    public function getActionUrl($id = '')
    {
        $module = ($this->action->controller->module->id == 'app' ? '' : $this->action->controller->module->id . '/');
        $controller = $this->action->controller->id;
        $action = $this->action->id;
        return ('/' . $module . $controller . '/' . $action . '/' . $id );
    }
}