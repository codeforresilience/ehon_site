<?php
class BindersController extends AppController {
	public $uses = array('Ehon','Mask','Attachment');
	public $components = array('RequestHandler');

	public function pdf($ehonId = null,$langCode=null) {
		ini_set('memory_limit', '128M');
		set_time_limit(120);

		$this->RequestHandler->respondAs('application/pdf');

		$this->Ehon->id = $ehonId;
		if (!$this->Ehon->exists()) {
			throw new NotFoundException(__('Invalid %s', __('ehon')));
		}
		$ehon=$this->Ehon->read(null, $ehonId);
		$useLang=false;

		foreach ($ehon["Title"] as $title) {
			if($title['lang_code']==$langCode) $useLang=true;
		}
		if(!$useLang){
			throw new NotFoundException(__('Invalid %s', __('lang')));
		}

		$masksAll=array();
		for($i=0;$i<count($ehon["Attachment"]);$i++){
			$masks=$this->Mask->find('all', array(
    			'conditions' => array(
    				'Mask.attachment_id' => $ehon["Attachment"][$i]["id"]
    			)));
			$masksAll[$ehon["Attachment"][$i]["seq"]]=$masks;
		}
//			debug($masksAll);

		$this->set(compact('ehon','masksAll','langCode'));
	}
 }
