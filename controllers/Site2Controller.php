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
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
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
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
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
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
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
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
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
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
            ]);
		}
    }

    public function actionSave1c() {
		if (Yii::$app->user->isGuest === false) {
			$kontragent = Organization::find()->where('saved'=>'0')->all();
			//$path = "D:\\v7\\SSTDB";
			$path = "\\\\EKSPERT-101\\1c-base\\SSTDB";//ïðèìåð
			//$path = '"\\\\EKSPERT-101\\1c-base\\áóõãàëòåðèÿ è çàðïëàòà\\SSTDB ÍÝ"';//îðèãèíàë

			$path = '"\\\\EKSPERT-101\\1c-base\\áóõãàëòåðèÿ è çàðïëàòà\\SSTDB ÍÝ"';
			//$path = '"\\\\EKSPERT-101\\1c-base\\h h\\SSTDB"';
			$app = new \COM("v77.Application") or die("Îøèáêà ñîçäàíèÿ îáúåêòà v77.Application");
			if ($app->Initialize($app->RMTrade, "/D" . $path, "NO_SPLASH_SHOW") == 0) {
				return $this->render('error', [
							'message' => iconv("cp1251", "UTF-8", 'Íå óäàëîñü ïîäêëþ÷èòüñÿ ê áàçå äàííûõ. Äëÿ ñèíõðîíèçàöèè íåîáõîäèì ìîíîïîëüíûé äîñòóï ê áàçå äàííûõ. Äëÿ ïðîäîëæåíèÿ óáåäèòåñü, ÷òî íèêòî áîëüøå íå èñïîëüçóåò ÁÄ, íàæìèòå â áðàóçåðå "Íàçàä", è ïîïðîáóéòå ñèíõðîíèçèðîâàòü äàííûå åùå ðàç.'),
							'name' => iconv("cp1251", "UTF-8", 'Îøèáêà áàçû äàííûõ')
				]);
			} else {
				foreach ($kontragent as $kontr) {
					usleep(150000);
					$obj = $app->CreateObject("Ñïðàâî÷íèê.Êîíòðàãåíòû");
					if ($obj->ÍàéòèÏîÐåêâèçèòó("ÈÍÍ",iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp)) == 0) {
						if ($obj->ÍàéòèÏîÐåêâèçèòó("ÈÍÍ",iconv("UTF-8", "cp1251", $kontr->inn)) == 0) {
							//$obj = $app->CreateObject("Ñïðàâî÷íèê.Êîíòðàãåíòû");
							$obj->Íîâûé();
							$obj->ÓñòàíîâèòüÍîâûéÊîä();
							$obj->ÓñòàíîâèòüÀòðèáóò("ÏîëíÍàèìåíîâàíèå", iconv("UTF-8", "cp1251", $kontr->fullName));
							$obj->ÓñòàíîâèòüÀòðèáóò("Þðèäè÷åñêèéÀäðåñ", iconv("UTF-8", "cp1251", $kontr->address));
							$obj->ÓñòàíîâèòüÀòðèáóò("ÈÍÍ", iconv("UTF-8", "cp1251", $kontr->inn."/".$kontr->kpp));
							$obj->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", iconv("UTF-8", "cp1251", $kontr->name1c));
							$obj->ÓñòàíîâèòüÀòðèáóò("ÊîäÎÊÏÎ", iconv("UTF-8", "cp1251", $kontr->okpo));
							$obj->ÓñòàíîâèòüÀòðèáóò("ÂèäÊîíòðàãåíòà", $app->EvalExpr("Ïåðå÷èñëåíèå.ÂèäûÊîíòðàãåíòîâ.Îðãàíèçàöèÿ"));
							$obj->Çàïèñàòü();
							$org = Organization::findOne($kontr->id);
							$org->saved = '1';
							$org->save(false,NULL,'register');
							usleep(600000);
						}
					}
					$accounts = Accounts::find()->where(['idKontr' => $kontr->id])->andWhere(['saved' => '0'])->all();
					foreach ($accounts as $acc) {
						$obj_acc = $app->CreateObject("Ñïðàâî÷íèê.Ðàñ÷åòíûåÑ÷åòà");
						if ($obj_acc->ÍàéòèÏîÐåêâèçèòó("Íîìåð",iconv("UTF-8", "cp1251", $acc->kontrAccount),1) == 0) {
							$obj_acc->Íîâûé();
							$obj_acc->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", "Ñ÷åò");
							$obj_acc->ÓñòàíîâèòüÀòðèáóò("Íîìåð", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							$obj_bank = $app->CreateObject("Ñïðàâî÷íèê.Áàíêè");
							if ($obj_bank->ÍàéòèÏîÊîäó(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								$obj_bank->Íîâûé();
								$obj_bank->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", iconv("UTF-8", "cp1251", $acc->bankName));
								$obj_bank->ÓñòàíîâèòüÀòðèáóò("Êîä", iconv("UTF-8", "cp1251", $acc->bik));
								$obj_bank->ÓñòàíîâèòüÀòðèáóò("ÊîððÑ÷åò", iconv("UTF-8", "cp1251", $acc->korrAccount));
								$obj_bank->ÓñòàíîâèòüÀòðèáóò("Ìåñòîíàõîæäåíèå", iconv("UTF-8", "cp1251", $acc->city));
								$obj_bank->ÓñòàíîâèòüÀòðèáóò("Àäðåñ", iconv("UTF-8", "cp1251", $acc->address));
								$obj_bank->Çàïèñàòü();
								usleep(500000);
							}
							$obj_acc->ÓñòàíîâèòüÀòðèáóò("ÁàíêÎðãàíèçàöèè", $obj_bank->ÒåêóùèéÝëåìåíò());
							$obj_acc->ÓñòàíîâèòüÀòðèáóò("Âëàäåëåö", $obj->ÒåêóùèéÝëåìåíò());
							$obj_acc->ÓñòàíîâèòüÍîâûéÊîä();
							$obj_acc->Çàïèñàòü();
							$acc_obj = Accounts::findOne($acc->id);
							$acc_obj->saved = '1';
							$acc_obj->save(false,null,'1c');
							usleep(500000);
						} else {
							$acc_obj = Accounts::findOne($acc->id);
							$acc_obj->saved = '1';
							$acc_obj->save(false,null,'1c');						
						}
						// else if ($obj_acc->ÒåêóùèéÝëåìåíò()->Ïîëó÷èòüÀòðèáóò("Âëàäåëåö")->ÒåêóùèéÝëåìåíò()!=$obj->ÒåêóùèéÝëåìåíò()) {
							// $obj_acc = $app->CreateObject("Ñïðàâî÷íèê.Ðàñ÷åòíûåÑ÷åòà");
							// $obj_acc->Íîâûé();
							// $obj_acc->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", "Ñ÷åò");
							// $obj_acc->ÓñòàíîâèòüÀòðèáóò("Íîìåð", iconv("UTF-8", "cp1251", $acc->kontrAccount));

							// $obj_bank = $app->CreateObject("Ñïðàâî÷íèê.Áàíêè");
							// if ($obj_bank->ÍàéòèÏîÊîäó(iconv("UTF-8", "cp1251", $acc->bik)) == 0) {
								// $obj_bank->Íîâûé();
								// $obj_bank->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", iconv("UTF-8", "cp1251", $acc->bankName));
								// $obj_bank->ÓñòàíîâèòüÀòðèáóò("Êîä", iconv("UTF-8", "cp1251", $acc->bik));
								// $obj_bank->ÓñòàíîâèòüÀòðèáóò("ÊîððÑ÷åò", iconv("UTF-8", "cp1251", $acc->korrAccount));
								// $obj_bank->ÓñòàíîâèòüÀòðèáóò("Ìåñòîíàõîæäåíèå", iconv("UTF-8", "cp1251", $acc->city));
								// $obj_bank->ÓñòàíîâèòüÀòðèáóò("Àäðåñ", iconv("UTF-8", "cp1251", $acc->address));
								// $obj_bank->Çàïèñàòü();
							// }
							// $obj_acc->ÓñòàíîâèòüÀòðèáóò("ÁàíêÎðãàíèçàöèè", $obj_bank->ÒåêóùèéÝëåìåíò());
							// $obj_acc->ÓñòàíîâèòüÀòðèáóò("Âëàäåëåö", $obj->ÒåêóùèéÝëåìåíò());
							// $obj_acc->ÓñòàíîâèòüÍîâûéÊîä();
							// $obj_acc->Çàïèñàòü();
						// }
					}



					$contracts = Contracts::find()->where(['idKontr' => $kontr->id])->andWhere(['saved' => '0'])->all();
					foreach ($contracts as $contr) {
						$obj_contr = $app->CreateObject("Ñïðàâî÷íèê.Äîãîâîðû");
						if ($obj_contr->ÍàéòèÏîÍàèìåíîâàíèþ("¹".iconv("UTF-8", "cp1251", $contr->numberContract)." îò ".iconv("UTF-8", "cp1251", $contr->dateContract),0) == 0) {
							$obj_contr->Íîâûé();
							$obj_contr->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", "¹".iconv("UTF-8", "cp1251", $contr->numberContract)." îò ".iconv("UTF-8", "cp1251", $contr->dateContract));
							$obj_contr->ÓñòàíîâèòüÀòðèáóò("Âëàäåëåö", $obj->ÒåêóùèéÝëåìåíò());
							$obj_contr->ÓñòàíîâèòüÍîâûéÊîä();
							$obj_contr->Çàïèñàòü();
							$contr_obj = Contracts::findOne($contr->id);
							$contr_obj->saved = '1';
							$contr_obj->save(false,null,'1c');
							sleep(1);
						}  else {
							$contr_obj = Contracts::findOne($contr->id);
							$contr_obj->saved = '1';
							$contr_obj->save(false,null,'1c');				
						}
						// else if ($obj_contr->Ïîëó÷èòüÀòðèáóò("Âëàäåëåö")->ÒåêóùèéÝëåìåíò()!=$obj->ÒåêóùèéÝëåìåíò()) {
							// $obj_contr = $app->CreateObject("Ñïðàâî÷íèê.Äîãîâîðû");
							// $obj_contr->Íîâûé();
							// $obj_contr->ÓñòàíîâèòüÀòðèáóò("Íàèìåíîâàíèå", "¹".iconv("UTF-8", "cp1251", $contr->numberContract)." îò ".iconv("UTF-8", "cp1251", $contr->dateContract));
							// $obj_contr->ÓñòàíîâèòüÀòðèáóò("Âëàäåëåö", $obj->ÒåêóùèéÝëåìåíò());
							// $obj_contr->ÓñòàíîâèòüÍîâûéÊîä();
							// $obj_contr->Çàïèñàòü();
						// }
					}
				}
			}
			return $this->redirect(['index']);
		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Íåäîñòàòî÷íî ïðàâ äëÿ âûïîëíåíèÿ çàïðîñà. Âîéäèòå â ñèñòåìó.'),
                        'name' => iconv("cp1251", "UTF-8", 'Îøèáêà äîñòóïà')
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
