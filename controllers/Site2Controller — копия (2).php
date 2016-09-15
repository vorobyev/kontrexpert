<?php

namespace app\controllers;

use Yii;
use app\models\Organization;
use app\models\OrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Accounts;
use app\models\Contracts;
use app\models\HistoryContracts;
use app\models\PaymentsContracts;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Site2Controller implements the CRUD actions for Organization model.
 */
class Site2Controller extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Organization models.
     * @return mixed
     */
    public function actionIndex() {
		if (Yii::$app->user->isGuest === false) {
			$searchModel = new OrganizationSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
						'searchModel' => $searchModel,
						'dataProvider' => $dataProvider,
			]);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}
    }

    /**
     * Displays a single Organization model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
		if (Yii::$app->user->isGuest === false) {
			return $this->render('view', [
						'model' => $this->findModel($id),
			]);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
		if (Yii::$app->user->isGuest === false) {
		
			$model = new Organization();

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('create', [
							'model' => $model,
				]);
			}
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
		if (Yii::$app->user->isGuest === false) {
			$model = $this->findModel($id);

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('update', [
							'model' => $model,
				]);
			}
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}
    }

    /**
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
		if (Yii::$app->user->isGuest === false) {
			$this->findModel($id)->delete();
			Accounts::deleteAll(['idKontr' => $id]);
			$contracts = Contracts::find()->where(['idKontr' => $id])->all();
			foreach ($contracts as $contr) {
				HistoryContracts::deleteAll(['idContr' => $contr->id]);
				PaymentsContracts::deleteAll(['idContr' => $contr->id]);
			}
			Contracts::deleteAll(['idKontr' => $id]);

			return $this->redirect(['index']);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}
    }

    public function actionSave1c() {
		if (Yii::$app->user->isGuest === false) {
			$kontragent = Organization::find()->all();
			$path = "D:\\v7\\SSTDB";
			$app = new \COM("v77.Application") or die("Ошибка создания объекта v77.Application");
			if ($app->Initialize($app->RMTrade, "/D" . $path, "NO_SPLASH_SHOW") == 0) {
				return $this->render('error', [
							'message' => iconv("cp1251", "UTF-8", 'Не удалось подключиться к базе данных. Для синхронизации необходим монопольный доступ к базе данных. Для продолжения убедитесь, что никто больше не использует БД, нажмите в браузере "Назад", и попробуйте синхронизировать данные еще раз.'),
							'name' => iconv("cp1251", "UTF-8", 'Ошибка базы данных')
				]);
			} else {
				foreach ($kontragent as $kontr) {
					$obj = $app->CreateObject("Справочник.Контрагенты");

					if ($obj->НайтиПоРеквизиту("ИНН",iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp)) == 0) {
						$obj->Новый();
						$obj->УстановитьНовыйКод();
						$obj->УстановитьАтрибут("ПолнНаименование", iconv("UTF-8", "cp1251", $kontr->fullName));
						$obj->УстановитьАтрибут("ЮридическийАдрес", iconv("UTF-8", "cp1251", $kontr->address));
						$obj->УстановитьАтрибут("ИНН", iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp));
						$obj->УстановитьАтрибут("Наименование", iconv("UTF-8", "cp1251", $kontr->name));
						$obj->УстановитьАтрибут("КодОКПО", iconv("UTF-8", "cp1251", $kontr->okpo));
						$obj->УстановитьАтрибут("ВидКонтрагента", $app->EvalExpr("Перечисление.ВидыКонтрагентов.Организация"));
						$obj->Записать();
					}
					$accounts = Accounts::find()->where(['idKontr' => $kontr->id])->all();
					foreach ($accounts as $acc) {
						$obj_acc = $app->CreateObject("Справочник.РасчетныеСчета");
						if ($obj_acc->НайтиПоРеквизиту("Номер",iconv("UTF-8", "cp1251", $acc->kontrAccount),1) == 0) {
							$obj_acc->Новый();
							$obj_acc->УстановитьАтрибут("Наименование", "Счет");
							$obj_acc->УстановитьАтрибут("Номер", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							$obj_bank = $app->CreateObject("Справочник.Банки");
							if ($obj_bank->НайтиПоКоду(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								$obj_bank->Новый();
								$obj_bank->УстановитьАтрибут("Наименование", iconv("UTF-8", "cp1251", $acc->bankName));
								$obj_bank->УстановитьАтрибут("Код", iconv("UTF-8", "cp1251", $acc->bik));
								$obj_bank->УстановитьАтрибут("КоррСчет", iconv("UTF-8", "cp1251", $acc->korrAccount));
								$obj_bank->УстановитьАтрибут("Местонахождение", iconv("UTF-8", "cp1251", $acc->city));
								$obj_bank->УстановитьАтрибут("Адрес", iconv("UTF-8", "cp1251", $acc->address));
								$obj_bank->Записать();
							}
							$obj_acc->УстановитьАтрибут("БанкОрганизации", $obj_bank->ТекущийЭлемент());
							$obj_acc->УстановитьАтрибут("Владелец", $obj->ТекущийЭлемент());
							$obj_acc->УстановитьНовыйКод();
							$obj_acc->Записать();
						} 
						// else if ($obj_acc->ТекущийЭлемент()->ПолучитьАтрибут("Владелец")->ТекущийЭлемент()!=$obj->ТекущийЭлемент()) {
							// $obj_acc = $app->CreateObject("Справочник.РасчетныеСчета");
							// $obj_acc->Новый();
							// $obj_acc->УстановитьАтрибут("Наименование", "Счет");
							// $obj_acc->УстановитьАтрибут("Номер", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							// $obj_bank = $app->CreateObject("Справочник.Банки");
							// if ($obj_bank->НайтиПоКоду(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								// $obj_bank->Новый();
								// $obj_bank->УстановитьАтрибут("Наименование", iconv("UTF-8", "cp1251", $acc->bankName));
								// $obj_bank->УстановитьАтрибут("Код", iconv("UTF-8", "cp1251", $acc->bik));
								// $obj_bank->УстановитьАтрибут("КоррСчет", iconv("UTF-8", "cp1251", $acc->korrAccount));
								// $obj_bank->УстановитьАтрибут("Местонахождение", iconv("UTF-8", "cp1251", $acc->city));
								// $obj_bank->УстановитьАтрибут("Адрес", iconv("UTF-8", "cp1251", $acc->address));
								// $obj_bank->Записать();
							// }
							// $obj_acc->УстановитьАтрибут("БанкОрганизации", $obj_bank->ТекущийЭлемент());
							// $obj_acc->УстановитьАтрибут("Владелец", $obj->ТекущийЭлемент());
							// $obj_acc->УстановитьНовыйКод();
							// $obj_acc->Записать();
						// }
					}



					$contracts = Contracts::find()->where(['idKontr' => $kontr->id])->all();
					foreach ($contracts as $contr) {
						$obj_contr = $app->CreateObject("Справочник.Договоры");
						if ($obj_contr->НайтиПоНаименованию("№".iconv("UTF-8", "cp1251", $contr->numberContract)." от ".iconv("UTF-8", "cp1251", $contr->dateContract),0) == 0) {
							$obj_contr->Новый();
							$obj_contr->УстановитьАтрибут("Наименование", "№".iconv("UTF-8", "cp1251", $contr->numberContract)." от ".iconv("UTF-8", "cp1251", $contr->dateContract));
							$obj_contr->УстановитьАтрибут("Владелец", $obj->ТекущийЭлемент());
							$obj_contr->УстановитьНовыйКод();
							$obj_contr->Записать();
						} 
						// else if ($obj_contr->ПолучитьАтрибут("Владелец")->ТекущийЭлемент()!=$obj->ТекущийЭлемент()) {
							// $obj_contr = $app->CreateObject("Справочник.Договоры");
							// $obj_contr->Новый();
							// $obj_contr->УстановитьАтрибут("Наименование", "№".iconv("UTF-8", "cp1251", $contr->numberContract)." от ".iconv("UTF-8", "cp1251", $contr->dateContract));
							// $obj_contr->УстановитьАтрибут("Владелец", $obj->ТекущийЭлемент());
							// $obj_contr->УстановитьНовыйКод();
							// $obj_contr->Записать();
						// }
					}
				}
			}
			return $this->redirect(['index']);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}	
			
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
