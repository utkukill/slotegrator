<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Bank;
use app\models\Wins;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionGame()
    {

        if (!Yii::$app->user->isGuest) {

            $bank_moneys = (new \yii\db\Query())
                ->select(['val'])
                ->from('bank')
                ->where(['type' => 1])
                ->one();

            $bank_points = (new \yii\db\Query())
                ->select(['val'])
                ->from('bank')
                ->where(['type' => 2])
                ->one();

            $bank_things = (new \yii\db\Query())
                ->select(['id as val'])
                ->from('bank')
                ->where(['type' => 3])
                ->count('val');

            $balance_moneys = (new \yii\db\Query())
                ->select(['SUM(win_balance_int) as sum'])
                ->from('wins')
                ->where(['user_id' => Yii::$app->user->id, 'win_type' => 1, 'status' => 1])
                ->one();

            $balance_points = (new \yii\db\Query())
                ->select(['SUM(win_balance_int) as sum'])
                ->from('wins')
                ->where(['user_id' => Yii::$app->user->id, 'win_type' => 2, 'status' => 1])
                ->one();

            $balance_things = (new \yii\db\Query())
                ->select(['bank.val'])
                ->leftJoin('bank', 'bank.type=wins.win_type and bank.id=wins.win_balance_int' )
                ->where(['wins.user_id' => Yii::$app->user->id, 'wins.win_type' => 3, 'status' => 1])
                ->from('wins')
                ->all();

            
            $prize = false;
            $prize_type = 0;
            
            // run game
            if(isset($_GET['start'])) {


                // money or points or things
                $chance = rand(1, 3);


                $win = new Wins();


                // if win of money
                if($chance == 1 && $bank_moneys["val"] >= 1) {

                    $prize = rand(0, 100);
                    $prize_type = 1;
                    
                    $bank_moneys["val"] -= $prize;
                    $balance_moneys["sum"] += $prize;

                    $bank = Bank::find()->where(['type' => 1])->one();
                    $bank->val = (string)$bank_moneys["val"];
                    $bank->save();   


                    $win->user_id = Yii::$app->user->id;
                    $win->win_type = 1;
                    $win->win_balance_int = $prize;
                    $win->insert();



                }

                // if win of points
                if($chance == 2  && $bank_points >= 1) {

                    $prize = rand(0, 100);
                    $prize_type = 2;
                    $balance_points["sum"] += $prize;
                    
                    $win->user_id = Yii::$app->user->id;
                    $win->win_type = 2;
                    $win->win_balance_int = $prize;
                    $win->insert();

                }

                // if win of things
                if($chance == 29 ) {

                    $prize = rand(0, $bank_points);
                    $prize_type = 3;

                    $win->user_id = Yii::$app->user->id;
                    $win->win_type = 3;
                    $win->win_balance_int = $prize;
                    $win->insert();
                }

            }


            return $this->render('game', array(
                    'balance_moneys'=>$balance_moneys,
                    'balance_points'=>$balance_points,
                    'balance_things'=>$balance_things,
                    'bank_moneys'=>$bank_moneys,
                    'bank_points'=>$bank_points,
                    'bank_things'=>$bank_things,
                    'prize'=>$prize,
                ));


        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->render('game');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);

    }
}
