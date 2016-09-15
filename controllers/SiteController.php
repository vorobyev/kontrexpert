<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Organization;
use app\models\Accounts;
use app\models\Contracts;
use app\models\HistoryContracts;
use app\models\PaymentsContracts;
use yii\helpers\Url;
use app\models\TimeHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\OrganizationSearch;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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

	
	public function actionMails()
    {
		if (Yii::$app->user->isGuest === false) {
			$model = new UploadForm();
			$searchModel = new OrganizationSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('mails',['model' => $model, 'dataProvider'=>$dataProvider,'searchModel' => $searchModel]);

		} else {
			return $this->render('error', [
                        'message' => iconv("cp1251", "UTF-8", 'Недостаточно прав для выполнения запроса. Войдите в систему.'),
                        'name' => iconv("cp1251", "UTF-8", 'Ошибка доступа')
            ]);
		}


		
        
    }
	
	public function actionSendletter(){
		$arr = Yii::$app->request->post()['arr'];
		$subj = Yii::$app->request->post()['subj'];
		$text = Yii::$app->request->post()['mailtext'];
		$files = Yii::$app->request->post()['files'];
		$email_id = Yii::$app->request->post()['email'];
		$email = Organization::find()->where(['id'=>$email_id])->one();
		$filesarr = explode(", ",$files);
		if ($email->email!="") {
			$mail = Yii::$app->mailer->compose()
			->setFrom(["ekspert-bel@yandex.ru"=>"ООО \"Эксперт\""])
			->setTo($email->email)
			->setSubject($subj)
			->setHtmlBody($text);
			if ($files!=""){
				foreach ($filesarr as $file){
					$path = Yii::getAlias('@app').$file;
					if (file_exists(urldecode($path))){
						$mail->attach(urldecode($path));
					}
				}
			}

			$mail->send();
		}
		if ($arr!=$email_id){
			return $email->email;
		} else {
			return "close";
		}
	}
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::info('Пользователь '.$model->name.' вошел',__METHOD__);
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::info('Пользователь '.Yii::$app->user->identity->name.' вышел',__METHOD__);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionDevelop()
    {
        if (Yii::$app->user->isGuest === false) {
            return $this->render('develop');    
         } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}
    }
    
    /**
     * Displays contact page.
     *
     * @return string
     */

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionClients()
    {
        if (Yii::$app->user->isGuest === false) {
        if (isset(Yii::$app->request->post()['prilozh'])){
            $word = new \COM("Word.Application") or die ("Невозможно создать COM объект");
            $word->Visible = 0;
            $word->WindowState=2;
            $word->DisplayAlerts = 0;
            $path = Yii::getAlias('@app').'/web/dogovor.docx';
            //$word->Documents->Add();
            $word->Documents->Open($path);
            $word->ActiveDocument->ContentControls[1]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['numberContract']);
            $word->ActiveDocument->ContentControls[2]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dateContract']);
            $word->ActiveDocument->ContentControls[3]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['fullname']);
            $word->ActiveDocument->ContentControls[4]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dolzhrod']." ".Yii::$app->request->post()['rukovrod']);
            $word->ActiveDocument->ContentControls[5]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['osnovaniye']);
            $word->ActiveDocument->ContentControls[6]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['volumecifer']." (".Yii::$app->request->post()['volume']).")";
            $word->ActiveDocument->ContentControls[7]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['name']);
            $word->ActiveDocument->ContentControls[8]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['sum']);
            $word->ActiveDocument->ContentControls[9]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['sum']);
            $word->ActiveDocument->ContentControls[10]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['name']);
            $word->ActiveDocument->ContentControls[11]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['rekvisits']);
			if (Yii::$app->request->post()['dolzh']!="Индивидуальный предприниматель"){
				$word->ActiveDocument->ContentControls[12]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dolzh'].chr(13).chr(10).Yii::$app->request->post()['name']);
            } else {
				$word->ActiveDocument->ContentControls[12]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dolzh'].chr(13).chr(10).str_replace("ИП ","",str_replace("ип ","",str_replace("Ип ","",Yii::$app->request->post()['name']))));
			}
			$word->ActiveDocument->ContentControls[13]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['rukovinit']);
            $word->ActiveDocument->ContentControls[14]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['prilozh']);
			if (Yii::$app->request->post()['dolzh']!="Индивидуальный предприниматель"){
				$word->ActiveDocument->ContentControls[15]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dolzh'].chr(13).chr(10).Yii::$app->request->post()['name']);
            } else {
				$word->ActiveDocument->ContentControls[15]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['dolzh'].chr(13).chr(10).str_replace("ИП ","",str_replace("ип ","",str_replace("Ип ","",Yii::$app->request->post()['name']))));
			}
            $word->ActiveDocument->ContentControls[16]->Range->Text=iconv("UTF-8", "cp1251", Yii::$app->request->post()['rukovinit']);
            
            $filename = "Dogovor_".date("Y-m-d___H-i-s")."___".iconv("UTF-8", "cp1251", Yii::$app->request->post()['numberContract']);
            $word->ActiveDocument->SaveAs(Yii::getAlias('@app').'/web/docs/'.$filename.'.doc');
            $word->ActiveDocument->Close(false);
            $word->Quit();
            //$word->Release();
            $word = null;
            return \Yii::$app->response->sendFile(Yii::getAlias('@app').'/web/docs/'.$filename.".doc",$filename.".doc");
        }
        
        if (!isset(Yii::$app->request->get()['new'])&&(!isset(Yii::$app->request->get()['kontrid']))) {  
            return $this->redirect(Url::to(['site2/index']));            
        } else {
            $modelAcc = new Accounts();
            $modelContracts = new Contracts();
            $modelHistory = new HistoryContracts();
            if (isset(Yii::$app->request->get()['kontrid'])){
                $model = Organization::findOne((int)Yii::$app->request->get()['kontrid']);
            } else {
                $model = new Organization();
            }
            
            if (isset(Yii::$app->request->get()['accounts'])){
                $accProvider = new ActiveDataProvider([
                    'query' => Accounts::find()->where(['idKontr'=>(int)Yii::$app->request->get()['kontrid']]), 
                    'pagination' => [
                    'pageSize' => 5,
                 ],
            ]);  
                

                
                if (isset(Yii::$app->request->get()['accid'])){
                    if (Yii::$app->request->get()['accid'] != "new"){
                        $modelAcc = Accounts::findOne(Yii::$app->request->get()['accid']);
                        if ($modelAcc == null) {
                            return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>'1']));
                        }
                        if ($modelAcc->load(Yii::$app->request->post()) && $modelAcc->save()) {
                             return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>'1']));            
                        }                      
                        
                    } else {
                        if ($modelAcc->load(Yii::$app->request->post()) && $modelAcc->save()) {
                             return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>'1']));            
                    }
                    }
                } 
            } else {
                $accProvider = null;
            }
            
            if (isset(Yii::$app->request->get()['contracts'])){
                $contractsProvider = new ActiveDataProvider([
                    'query' => Contracts::find()->where(['idKontr'=>(int)Yii::$app->request->get()['kontrid']]), 
                    'pagination' => [
                    'pageSize' => 5,
                 ],
            ]);
                
                if (isset(Yii::$app->request->get()['contrid'])){
                    if (Yii::$app->request->get()['contrid'] != "new"){
                        $modelContracts = Contracts::findOne(Yii::$app->request->get()['contrid']);
                        $modelHistory = HistoryContracts::find()->where(['idContr'=>Yii::$app->request->get()['contrid']])->orderBy('id DESC')->one();
                        if ($modelContracts == null) {
                            return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1']));
                        }
                        if ($modelContracts->load(Yii::$app->request->post()) && $modelContracts->save()) {
                            $modelHistoryNew = new HistoryContracts();
                            $modelHistoryNew->load(Yii::$app->request->post());
                            if ($modelHistory <> NULL){
                                if (($modelHistoryNew->volumeJob != $modelHistory->volumeJob)||($modelHistoryNew->summ != $modelHistory->summ)){
                                    $modelHistoryNew->save();
                                    $modelHistory = $modelHistoryNew;
                                } 
                            } else {
                                    $modelHistoryNew->save();
                                    $modelHistory = $modelHistoryNew;                              
                            }
                            
                             return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1']));            
                        }                      
                        
                    } else {
                        $modelContracts->load(Yii::$app->request->post());
                        if ($modelContracts->load(Yii::$app->request->post()) && $modelContracts->save()) {
                            $modelHistory = new HistoryContracts();
                            $modelHistory->load(Yii::$app->request->post());
                            $modelHistory->save(false,NULL,$modelContracts->id);
                             return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1']));            
                    }
                    }
                }                
                
                
            } else {
                $contractsProvider = null;
            }          
            if ($model == null) {
                 return $this->render('error', [
                            'message' => 'Контрагент с id='.Yii::$app->request->get()['kontrid'].' отсутствует в базе данных.',
                            'name'=>'Ошибка базы данных'
                        ]); 
            }
            
            if (isset(Yii::$app->request->get()['kontrid'])) {
                $kolacc = (string)Accounts::find()->where(['idKontr'=>(int)Yii::$app->request->get()['kontrid']])->Count();
                $kolcontr = (string)Contracts::find()->where(['idKontr'=>(int)Yii::$app->request->get()['kontrid']])->Count();
            } else {
                $kolacc = 0;
                $kolcontr = 0;
            }
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
				if (!$model->hasErrors()){
					return $this->redirect(Url::to(['site/clients','kontrid'=>$model->id]));
				} else {
					if ($modelHistory==NULL) {
						$modelHistory = new HistoryContracts();
						}
						return $this->render('clients', [
									'model' => $model,
									'accProvider' => $accProvider,
									'modelacc' => $modelAcc,
									'kolacc'=>$kolacc,
									'contractsProvider' => $contractsProvider,
									'modelcontracts' => $modelContracts,
									'kolcontr'=>$kolcontr, 
									'modelhistory'=>$modelHistory
								]); 
				}
            } else {
                if ($modelHistory==NULL) {
                    $modelHistory = new HistoryContracts();
                }
                return $this->render('clients', [
                            'model' => $model,
                            'accProvider' => $accProvider,
                            'modelacc' => $modelAcc,
                            'kolacc'=>$kolacc,
                            'contractsProvider' => $contractsProvider,
                            'modelcontracts' => $modelContracts,
                            'kolcontr'=>$kolcontr, 
                            'modelhistory'=>$modelHistory
                        ]); 
            }
        }
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}	
    }
    
    
    public function actionDeleteacc(){
        if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->get()['id'];
            $modelAcc = Accounts::findOne($id);
            $modelAcc->delete();
            return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>'1']));
         } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}    
    }
    
   public function actionDeletepay(){
       if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->get()['id'];
            $modelPay = PaymentsContracts::findOne($id);
            $modelPay->delete();
            return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1']));
          } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}        
    }

   public function actionDeletecontr(){
       if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->get()['id'];
            $modelContr = Contracts::findOne($id);
            HistoryContracts::deleteAll(['idContr'=>$id]);
            PaymentsContracts::deleteAll(['idContr'=>$id]);
            $modelContr->delete();
            return $this->redirect(Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1']));
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}              
            
    }    
        
    public function actionViewacc(){
        if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->get()['id'];
            $modelAcc = Accounts::findOne($id);
            return $this->render('viewacc', [
                'model' => $modelAcc,
            ]); 
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}   
    }
    
    public function actionViewcontr(){
        if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->get()['id'];
            $modelContr = Contracts::findOne($id);
            return $this->render('viewcontr', [
                'model' => $modelContr,
            ]); 
         } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}          
    }
    
    
    public function actionAddPayment(){
        if (Yii::$app->user->isGuest === false) {
            $id = Yii::$app->request->post()['id'];
            $sumPayment = Yii::$app->request->post()['sumpayment'];
            $datePayment = Yii::$app->request->post()['datepayment'];
            $payments = new PaymentsContracts();
            $payments->idContr = $id;
            $payments->datePayment = $datePayment;
            $payments->summ = $sumPayment;
            if ($payments->validate()) {
                $payments->save();
                return true;
            } else {
                return false;
            }
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}     
    }
    
    
    public function actionReestr(){
        if (Yii::$app->user->isGuest === false) {
        $inn = Yii::$app->request->post()['inn'];
        $kpp = Yii::$app->request->post()['kpp'];
        $ogrn = Yii::$app->request->post()['ogrn'];
        $okpo = Yii::$app->request->post()['okpo'];
        $address = Yii::$app->request->post()['address'];
	$addressfact = Yii::$app->request->post()['addressfact'];
        $addressreg = Yii::$app->request->post()['addressreg'];
        $rukovod = Yii::$app->request->post()['rukovod'];
        $account = Yii::$app->request->post()['account'];
        $volume = Yii::$app->request->post()['volume'];
        $sum = Yii::$app->request->post()['sum'];
        $credit = Yii::$app->request->post()['credit'];
        $comments = Yii::$app->request->post()['comments'];
		$subj = Yii::$app->request->post()['subj'];
		$email = Yii::$app->request->post()['email'];
		$date1 = Yii::$app->request->post()['date1'];
		$date2 = Yii::$app->request->post()['date2'];
        
        $exapp = new \COM("Excel.Application") or Die ("Did not connect");
        $exapp->Workbooks->Add();
        $symb = ord("A");
        $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Номер договора');
        $symb+=1;
        $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Дата договора');
        $symb+=1;
        $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Контрагент');
        $symb+=1;  
        $column = 1;
		if ($subj == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Предмет договора');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }
        if ($inn == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'ИНН');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }
        if ($kpp == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'КПП');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }       
        if ($ogrn == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'ОГРН');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }          
        if ($okpo == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'ОКПО');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }         
        if ($address == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Юр. адрес');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }    
        if ($addressreg == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Адрес регистрации');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }  
        if ($addressfact == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Факт. адрес');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }  		
        if ($rukovod == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Руководитель');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;           
        }  
        if ($account == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Номер счета');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Бик');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;  
        }         
        if ($volume == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Объем выполняемой работы, р.м.');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
        }        
        if ($sum == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Сумма договора, руб');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
        }        
        if ($credit == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Долг, руб');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
        }    
        if ($email == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'E-mail');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
        }    
        if ($comments == 'true'){
            $exapp->Range(chr($symb).'1')->Value = iconv("UTF-8", "cp1251", 'Комментарий');
            $exapp->Columns($column)->ColumnWidth = 15;
            $column+=1;
            $symb+=1;        
        }    
        
        $str = 2;
        
        $col = $contracts = Contracts::find()->count()+1;
        $contracts = Contracts::find()->where(['>=', 'dateContract', $date1])->andWhere(['<=', 'dateContract', $date2])->orderBy('dateContract ASC')->all();
        $exapp->Range("A1:".chr($symb).(string)$col)->NumberFormat = "@";
	
        foreach ($contracts as $contr) {
            $symb = ord("A");            
            $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $contr->numberContract);
            $symb+=1;
            $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $contr->dateContract);
            $symb+=1;
            $kontr = Organization::findOne($contr->idKontr);
            $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->name);
            $symb+=1;
            if ($subj == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $contr->subj);
                $symb+=1;                  
            }			
            if ($inn == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->inn);
                $symb+=1;                  
            }
            if ($kpp == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->kpp);
                $symb+=1;                  
            }      
            if ($ogrn == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->ogrn);
                $symb+=1;                  
            } 
            if ($okpo == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->okpo);
                $symb+=1;                  
            } 
            if ($address == 'true'){
				$str2 = $kontr->address;
				if (($kontr->phone!="")&&($str2!="")){
					$str2.="; тел: ".$kontr->phone;
				}
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $str2);
                $symb+=1;                  
            } 
            if ($addressreg == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->addressreg);
                $symb+=1;                  
            } 
	    if ($addressfact == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->addressfact);
                $symb+=1;                  
            } 
            if ($rukovod == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->rukovod);
                $symb+=1;                  
            } 
            if ($account == 'true'){
                $acc = Accounts::find()->where(['idKontr'=>$kontr->id])->count();
                if ($acc != 1) {
                    if ($acc<1) {
                        $acc1 = "";
                        $acc2 = "";
                    }
                    if ($acc>1) {
                        $acc1 = "Более 1 счета";
                        $acc2 = "Более 1 счета";
                    }
                } else {
                    $acc1 = Accounts::find()->where(['idKontr'=>$kontr->id])->one()->kontrAccount;
                    $acc2 = Accounts::find()->where(['idKontr'=>$kontr->id])->one()->bik;
                }
                
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $acc1);
                $symb+=1;    
                                
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $acc2);
                $symb+=1;
            } 
            if ($volume == 'true'){
                $modelHistory = HistoryContracts::find()->where(['idContr'=>$contr->id])->orderBy('id DESC')->one();
                if ($modelHistory != NULL) {
                    $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $modelHistory->volumeJob);
                } 
                $symb+=1;                  
            } 
            if ($sum == 'true'){
                $modelHistory = HistoryContracts::find()->where(['idContr'=>$contr->id])->orderBy('id DESC')->one();
                if ($modelHistory != NULL) {
                    $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $modelHistory->summ);
                }
                $symb+=1;                  
            }            
            if ($credit == 'true'){
                $modelHistory = HistoryContracts::find()->where(['idContr'=>$contr->id])->orderBy('id DESC')->one();
                if ($modelHistory != NULL) {
                    $summ = (int)$modelHistory->summ;
                } else {
                    $summ = 0;
                }
                $pays = PaymentsContracts::find()->where(['idContr'=>$contr->id])->all();
                $cred = 0;
                foreach ($pays as $pay) {
                   $cred+=(int)$pay->summ; 
                }
                $cred = $summ-$cred;
                
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $cred);
                $symb+=1;                  
            } 
            if ($email == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $kontr->email);
                $symb+=1;                  
            } 			
            if ($comments == 'true'){
                $exapp->Range(chr($symb).(string)$str)->Value = iconv("UTF-8", "cp1251", $contr->comments);
                $symb+=1; 
            }
            $str+=1;
            
        }
	
        date_default_timezone_set( 'Europe/Moscow' );
        $filename = "reestr_".date("Y-m-d___H-i-s")."(".$date1."__".$date2.")"; 
        $exapp->Workbooks[1]->SaveAs(Yii::getAlias('@app').'/web/reestr/'.(string)$filename.".xlsx");
        $exapp->Quit();
        unset($exapp);
        //return \Yii::$app->response->sendFile(Yii::getAlias('@app').'/web/reestr/'.(string)$filename.".xlsx",(string)$filename.".xlsx");
        return $filename;
        
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}          
        
    }
    
    public function actionDown($path){
        if (Yii::$app->user->isGuest === false) {
            return \Yii::$app->response->sendFile(Yii::getAlias('@app').'/web/reestr/'.(string)$path.".xlsx",(string)$path.".xlsx");
        } else {
		return $this->render('error', [
                        'message' => 'Недостаточно прав для выполнения запроса. Войдите в систему.',
                        'name' => 'Ошибка доступа'
            ]);
	}             
    }
}
