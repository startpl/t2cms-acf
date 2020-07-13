<?php

namespace startpl\t2cms\acf\backend\controllers;

use yii\web\Controller;
use startpl\t2cms\acf\common\repositories\{
    AcfGroupRepository,
    AcfFieldRepository
};

/**
 * DefaultController implements the CRUD actions for AcfGroup model.
 */
class AjaxController extends Controller
{
    private $acfGroupRepository;
    private $acfFieldRepository;
    
    public function __construct
    (
        $id, 
        $module,
        AcfGroupRepository $acfGroupRepository,
        AcfFieldRepository $acfFieldRepository,
        $config = array()
    ) {
        parent::__construct($id, $module, $config);
        
        $this->acfGroupRepository = $acfGroupRepository;
        $this->acfFieldRepository = $acfFieldRepository;
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'ajax' => [
                'class' => \yii\filters\AjaxFilter::className(),
            ]
        ];
    }

    public function actionIndex()
    {
        $get = \Yii::$app->request->get();
        
        $domain_id = \t2cms\sitemanager\components\Domains::getEditorDomainId();
        $language_id = \t2cms\sitemanager\components\Languages::getEditorLangaugeId();
        
        $data = AcfFieldRepository::getAllByGroup(
            (int)$get['groupId'],
            (int)$get['srcId'],
            (int)$get['srcType'],
            $domain_id,
            $language_id
        );
        
        foreach($data as $field) {
            if($field->value === null) {
                $field->populateRelation('value', new \startpl\t2cms\acf\common\models\AcfFieldValue());
            }
        }
        
        return $this->renderAjax('_form', [
            'data' => $data,
            'groupId' => (int)$get['groupId'],
        ]);
    }
}
