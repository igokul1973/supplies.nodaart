<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * BackendController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC) for 
 * your controllers and their actions.
 */
class BackendController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['user'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                    [
                        'controllers' => ['product'],
                        'actions' => ['import-products', 'index', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['product'],
                        'actions' => ['import-products', 'index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['product_picture'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'deleteFile'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['product_category'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['product_category'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['supplier'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['supplier'],
                        'actions' => ['index', 'view', 'create'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['purchase-order'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['purchase-order'],
                        'actions' => ['index', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['purchase-order-details'],
                        'actions' => ['add-products-to-po', 'import-products-to-po', 'index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['profile'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['color'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['status'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['status'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],
                    [
                        'controllers' => ['country'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                    [
                        'controllers' => ['country'],
                        'actions' => ['index', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['editor']
                    ],


                ], // rules

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors


} // BackendController