<?php
App::uses('AppController', 'Controller');
/**
 * Ehons Controller
 *
 * @property Ehon $Ehon
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EhonsController extends AppController {
	public $uses = array('Ehon','Attachment','Mask','Translation','Lang','Title');
	public $components = array('Paginator');
/**
 * index method
 *
 * @return void
 */
	public function index($langCode=null) {
		// top carousel
		$newEhons=$this->Ehon->find('all', array(
    		'order' => array('Ehon.created' => 'desc'),
    		'limit' => 3
		));

		$this->Title->recursive = 0;
	    $this->Paginator->settings = array(
    		'order' => array('Ehon.created' => 'desc'),
	        'contain' => array('Title'),
	        'limit' => 10
	    );
	    $ehons=$this->Paginator->paginate();
	    $langs=$this->Lang->find("list");

		$this->set(compact('ehons','langs','newEhons'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($ehonId = null) {
		$this->Ehon->id = $ehonId;
		if (!$this->Ehon->exists()) {
			throw new NotFoundException(__('Invalid %s', __('ehon')));
		}
		$ehon=$this->Ehon->read(null, $ehonId);
		$langs=$this->Lang->find("list");
		$mask=$this->Mask->find('first', array(
    		'order' => array('Mask.id' => 'asc'),
    			'conditions' => array(
    				'Attachment.ehon_id' => $ehonId,
    			)
    	));


		$this->set(compact('ehon','langs','mask'));
	}

	// create ehon
	public function create() {
		ini_set('memory_limit', '128M');
		if ($this->request->is('post')) {
	    	$saveEhon = $this->request->data;
			if(!isset($saveEhon["Attachment"][0]["file"]["tmp_name"]) || mb_strlen($saveEhon["Attachment"][0]["file"]["tmp_name"])==0){
					$this->Session->setFlash(
						__('The %s could not be saved. Please, try again.', __('ehon')),
						'alert',
						array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-error'
						)
					);
			}else{
				$authUser=$this->Auth->user();
				$this->Ehon->create();
		    	// set user id
		    	$saveEhon['Ehon']['user_id']=$authUser['id'];
		    	// set image size
		    	for($i=0;$i<count($saveEhon["Attachment"]);$i++) {
		    		$att=$saveEhon["Attachment"][$i];
		    		$image_info = getimagesize($att["file"]["tmp_name"]);
		    		$saveEhon["Attachment"][$i]["width"]=$image_info[0];
		    		$saveEhon["Attachment"][$i]["height"]=$image_info[1];
		    	}
		    	// save ehon
				if ($this->Ehon->saveAll($saveEhon)){
					$this->Session->setFlash(
						'The ehon has been saved',
						'alert',
						array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-success'
						)
					);
					$this->redirect(array('action' => 'mask',$this->Ehon->id));
				} else {
					$this->Session->setFlash(
						__('The %s could not be saved. Please, try again.', __('ehon')),
						'alert',
						array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-error'
						)
					);
				}
			}
		}
	}

	public function mask($ehonId=null,$attId=null) {
		$this->Ehon->id = $ehonId ;
		if (!$this->Ehon->exists()) {
			throw new NotFoundException(__('Invalid %s', __('Ehon')));
		}
		$ehon = $this->Ehon->read(null, $ehonId);
		$this->Attachment->id = $attId ;
		if (!$this->Attachment->exists()) {
			$this->redirect(array('action' => 'mask',$ehonId,$ehon["Attachment"][0]['id']));
		}

		$att = $this->Attachment->read(null, $attId);
		if ($this->request->is('post')) {
			$masks = $this->request->data["Mask"];

			foreach( $masks as $mask ){
				$mask["attachment_id"]=$attId;
				$this->Mask->create();
				$this->Mask->save($mask);
			}
			$nextAtt;
			for($i=0;$i<count($ehon["Attachment"]);$i++){
				if($ehon["Attachment"][$i]['id']==$attId){
					$nextAtt=$i+1;
				}
			}
			
			$this->Session->setFlash(
				'The mask has been saved',
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			if(isset($nextAtt) && $nextAtt!=count($ehon["Attachment"])){
				$this->redirect(array('action' => 'mask',$ehonId,$ehon["Attachment"][$nextAtt]['id']));
			}else{

				$this->redirect(array('action' => 'translation',$ehonId));
			}

		}
		$this->set(compact('ehon','att','attId'));
	}

	public function translation($ehonId=null,$maskId=null,$langCode=null) {
		$this->Ehon->id = $ehonId ;
		if (!$this->Ehon->exists()) {
			throw new NotFoundException(__('Invalid %s', __('Ehon')));
		}
		//$ehon = $this->Ehon->read(null, $ehonId);

		if(isset($maskId) && isset($langCode)){
			$this->Mask->id = $maskId ;
			if (!$this->Ehon->exists()) {
				throw new NotFoundException(__('Invalid %s', __('Mask')));
			}

			$translation=$this->Translation->find('first', array(
    			'conditions' => array(
    				'Translation.mask_id' => $maskId,
    				'Translation.lang_code' => $langCode
    				)
    		));

			if ($this->request->is('post')) {
				$writeTranslation = $this->request->data["Translation"];

    			if(count($translation)!=0){
    				$writeTranslation["id"]=$translation["Translation"]["id"];
    			}
				$this->Translation->create();
				$writeTranslation["mask_id"]=$maskId;
				$writeTranslation["lang_code"]=$langCode;
				$writeTranslation["user_id"]=$this->Auth->user("id");

				$mask=$this->Mask->find('first', array(
    				'order' => array('Mask.id' => 'asc'),
    				'conditions' => array(
    					'Attachment.ehon_id' => $ehonId,
    					'Mask.id >' => $maskId,
    					)
    			));
				if($this->Translation->save($writeTranslation,false)){
					if(isset($mask["Mask"])){
						$this->Session->setFlash(
							'The translation has been saved',
							'alert',
							array(
								'plugin' => 'TwitterBootstrap',
								'class' => 'alert-success'
							)
						);
						$this->redirect(array($ehonId,$mask["Mask"]["id"],$langCode));
					}else{
						$this->Session->setFlash(
							'The ehon has been all saved.',
							'alert',
							array(
								'plugin' => 'TwitterBootstrap',
								'class' => 'alert-success'
							)
						);
						$this->redirect(array('action' => 'view',$ehonId));
					}
				}else{
					$this->Session->setFlash(
						__('This data could not be saved. Please, try again.'),
						'alert',
						array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-success'
						)
					);
				}

			}
			$mask = $this->Mask->read(null, $maskId);
			$langs=$this->Lang->find("list");
			$this->set(compact('mask','langs','translation'));
		}else{
			if ($this->request->is('post')) {
				$title = $this->request->data["Title"];
				$ckTitle=$this->Title->find('first', array(
    				'conditions' => array('Title.ehon_id' => $ehonId,'Title.lang_code'=>$title["lang_code"])
    			));
    			if(count($ckTitle)!=0){
    				$title["id"]=$ckTitle["Title"]["id"];
    			}
				$this->Title->create();
				$title["ehon_id"]=$ehonId;
				$title["user_id"]=$this->Auth->user("id");

				$mask=$this->Mask->find('first', array(
    				'order' => array('Mask.id' => 'asc'),
    				'conditions' => array('Attachment.ehon_id' => $ehonId)
    			));

				if($this->Title->save($title,false)){
					$this->redirect(array('controller' => 'ehons','action' => 'translation',$ehonId,$mask["Mask"]["id"],$this->request->data["Title"]["lang_code"]));
				}else{
					$this->Session->setFlash(
						__('This data could not be saved. Please, try again.'),
						'alert',
						array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-success'
						)
					);					
				}
			}
			// lang set
			$langs=$this->Lang->find("list");
			$this->set(compact('langs'));
			$this->render("translation_select");
		}
	}


	public function delete($ehonId = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Ehon->id = $ehonId;
		if (!$this->Ehon->exists()) {
			throw new NotFoundException(__('Invalid %s', __('ehon')));
		}
		$ehon=$this->Ehon->read(null, $ehonId);
		foreach ($ehon["Attachment"] as $attachment) {
			$masks=$this->Mask->find('all', array(
    			'conditions' => array(
    				'Mask.attachment_id' => $attachment["id"]
    			)));
			foreach ($masks as $mask) {
				foreach ($mask["Translation"] as $translation) {
					$this->Translation->id=$translation["id"];
					$this->Translation->delete();
				}
				$this->Mask->id=$mask["Mask"]["id"];
				$this->Mask->delete();
			}
			$this->Attachment->id=$attachment["id"];
			$this->Attachment->delete();
		}
		foreach ($ehon["Title"] as $title) {
			$this->Title->id=$title["id"];
			$this->Title->delete();
		}

		if ($this->Ehon->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('ehon')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('ehon')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));

	}


}
