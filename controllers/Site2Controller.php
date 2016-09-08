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
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
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
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
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
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
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
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
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
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
            ]);
		}
    }

    public function actionSave1c() {
		if (Yii::$app->user->isGuest === false) {
			$kontragent = Organization::find()->where(['or','saved'=>'0','saved'=>NULL])->all();
			//$path = "D:\\v7\\SSTDB";
			$path = "\\\\EKSPERT-101\\1c-base\\SSTDB";//������
			//$path = '"\\\\EKSPERT-101\\1c-base\\����������� � ��������\\SSTDB ��"';//��������

			$path = '"\\\\EKSPERT-101\\1c-base\\����������� � ��������\\SSTDB ��"';
			//$path = '"\\\\EKSPERT-101\\1c-base\\h h\\SSTDB"';
			$app = new \COM("v77.Application") or die("������ �������� ������� v77.Application");
			if ($app->Initialize($app->RMTrade, "/D" . $path, "NO_SPLASH_SHOW") == 0) {
				return $this->render('error', [
							'message' => iconv("cp1251", "UTF-8", '�� ������� ������������ � ���� ������. ��� ������������� ��������� ����������� ������ � ���� ������. ��� ����������� ���������, ��� ����� ������ �� ���������� ��, ������� � �������� "�����", � ���������� ���������������� ������ ��� ���.'),
							'name' => iconv("cp1251", "UTF-8", '������ ���� ������')
				]);
			} else {
				foreach ($kontragent as $kontr) {
					usleep(150000);
					$obj = $app->CreateObject("����������.�����������");
					if ($obj->����������������("���",iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp)) == 0) {
						if ($obj->����������������("���",iconv("UTF-8", "cp1251", $kontr->inn)) == 0) {
							//$obj = $app->CreateObject("����������.�����������");
							$obj->�����();
							$obj->������������������();
							$obj->�����������������("����������������", iconv("UTF-8", "cp1251", $kontr->fullName));
							$obj->�����������������("����������������", iconv("UTF-8", "cp1251", $kontr->address));
							$obj->�����������������("���", iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp));
							$obj->�����������������("������������", iconv("UTF-8", "cp1251", $kontr->name1c));
							$obj->�����������������("�������", iconv("UTF-8", "cp1251", $kontr->okpo));
							$obj->�����������������("��������������", $app->EvalExpr("������������.����������������.�����������"));
							$obj->��������();
							$org = Organization::findOne($kontr->id);
							$org->saved = '1';
							$org->save(false,NULL,'register');
							usleep(600000);
						}
					}
					$accounts = Accounts::find()->where(['idKontr' => $kontr->id])->andWhere(['or','saved'=>'0','saved'=>NULL])->all();
					foreach ($accounts as $acc) {
						$obj_acc = $app->CreateObject("����������.��������������");
						if ($obj_acc->����������������("�����",iconv("UTF-8", "cp1251", $acc->kontrAccount),1) == 0) {
							$obj_acc->�����();
							$obj_acc->�����������������("������������", "����");
							$obj_acc->�����������������("�����", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							$obj_bank = $app->CreateObject("����������.�����");
							if ($obj_bank->�����������(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								$obj_bank->�����();
								$obj_bank->�����������������("������������", iconv("UTF-8", "cp1251", $acc->bankName));
								$obj_bank->�����������������("���", iconv("UTF-8", "cp1251", $acc->bik));
								$obj_bank->�����������������("��������", iconv("UTF-8", "cp1251", $acc->korrAccount));
								$obj_bank->�����������������("���������������", iconv("UTF-8", "cp1251", $acc->city));
								$obj_bank->�����������������("�����", iconv("UTF-8", "cp1251", $acc->address));
								$obj_bank->��������();
								usleep(500000);
							}
							$obj_acc->�����������������("���������������", $obj_bank->��������������());
							$obj_acc->�����������������("��������", $obj->��������������());
							$obj_acc->������������������();
							$obj_acc->��������();
							$acc_obj = Accounts::findOne($acc->id);
							$acc_obj->saved = '1';
							$acc_obj->save(false,null,'1c');
							usleep(500000);
						} else {
							$acc_obj = Accounts::findOne($acc->id);
							$acc_obj->saved = '1';
							$acc_obj->save(false,null,'1c');						
						}
						// else if ($obj_acc->��������������()->���������������("��������")->��������������()!=$obj->��������������()) {
							// $obj_acc = $app->CreateObject("����������.��������������");
							// $obj_acc->�����();
							// $obj_acc->�����������������("������������", "����");
							// $obj_acc->�����������������("�����", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							// $obj_bank = $app->CreateObject("����������.�����");
							// if ($obj_bank->�����������(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								// $obj_bank->�����();
								// $obj_bank->�����������������("������������", iconv("UTF-8", "cp1251", $acc->bankName));
								// $obj_bank->�����������������("���", iconv("UTF-8", "cp1251", $acc->bik));
								// $obj_bank->�����������������("��������", iconv("UTF-8", "cp1251", $acc->korrAccount));
								// $obj_bank->�����������������("���������������", iconv("UTF-8", "cp1251", $acc->city));
								// $obj_bank->�����������������("�����", iconv("UTF-8", "cp1251", $acc->address));
								// $obj_bank->��������();
							// }
							// $obj_acc->�����������������("���������������", $obj_bank->��������������());
							// $obj_acc->�����������������("��������", $obj->��������������());
							// $obj_acc->������������������();
							// $obj_acc->��������();
						// }
					}



					$contracts = Contracts::find()->where(['idKontr' => $kontr->id])->andWhere(['or','saved'=>'0','saved'=>NULL])->all();
					foreach ($contracts as $contr) {
						$obj_contr = $app->CreateObject("����������.��������");
						if ($obj_contr->�������������������("�".iconv("UTF-8", "cp1251", $contr->numberContract)." �� ".iconv("UTF-8", "cp1251", $contr->dateContract),0) == 0) {
							$obj_contr->�����();
							$obj_contr->�����������������("������������", "�".iconv("UTF-8", "cp1251", $contr->numberContract)." �� ".iconv("UTF-8", "cp1251", $contr->dateContract));
							$obj_contr->�����������������("��������", $obj->��������������());
							$obj_contr->������������������();
							$obj_contr->��������();
							$contr_obj = Contracts::findOne($contr->id);
							$contr_obj->saved = '1';
							$contr_obj->save(false,null,'1c');
							sleep(1);
						}  else {
							$contr_obj = Contracts::findOne($contr->id);
							$contr_obj->saved = '1';
							$contr_obj->save(false,null,'1c');				
						}
						// else if ($obj_contr->���������������("��������")->��������������()!=$obj->��������������()) {
							// $obj_contr = $app->CreateObject("����������.��������");
							// $obj_contr->�����();
							// $obj_contr->�����������������("������������", "�".iconv("UTF-8", "cp1251", $contr->numberContract)." �� ".iconv("UTF-8", "cp1251", $contr->dateContract));
							// $obj_contr->�����������������("��������", $obj->��������������());
							// $obj_contr->������������������();
							// $obj_contr->��������();
						// }
					}
				}
			}
			return $this->redirect(['index']);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", '������������ ���� ��� ���������� �������. ������� � �������.'),
                        'name' => iconv("cp1251", "UTF-8", '������ �������')
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
