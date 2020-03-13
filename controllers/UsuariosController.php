<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\bootstrap4\Alert;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['registrar'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ];
    }

    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //     Yii::$app->session->setFlash('success', 'Se ha creado el usuario correctamente.');
        //     return $this->redirect(['site/login']);
        // }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash(
                'info',
                'Confirme su dirección de correo electrónico: ' . $model->email
            );

            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['smtpUsername'])
                ->setTo($model->email)
                ->setSubject('Validar cuenta ')
                ->setHtmlBody(Html::a(
                    'Haz click aquí para confirmar esta dirección de
                                   correo electrónico',
                    Url::to(['usuarios/validar-correo', 'token_acti' => $model->token_acti], true)
                ),)
                ->send();


            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }
    public function actionValidarCorreo($token_acti)
    {
        if (($usuario = Usuarios::findOne(['token_acti' => $token_acti])) !== null) {
            $usuario->token_acti = null;
            $usuario->save();

            $mensaje['success'] = 'Su cuenta de  correo electrónico ha sido confirmada
                                   con éxito';
        } else {
            $mensaje['danger'] = 'Su cuenta de correo ha sido confirmada anteriormente.';
        }

        Yii::$app->session->setFlash(key($mensaje), $mensaje[key($mensaje)]);

        return $this->redirect(['site/login']);
    }
}
