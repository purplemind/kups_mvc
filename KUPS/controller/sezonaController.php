<?php

class sezonaController Extends baseController {
	
	/**
	 * Return HTML content
	 * 
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		include_once 'model/sezona.model.php';
		
		$sezona = new sezonaModel($this->register);
		$this->register->template->sezona = $sezona;
		
		$action_parts = explode('/', $action);
			
		if (count($action_parts) > 1) {
			$this->register->template->id = $action_parts[0];
			$this->register->template->akcija = $action_parts[1];
			if ($action_parts[1] == 'edit') {
				$sezona->get_sezona($action_parts[0]);
			}
		}
		else {
			$this->register->template->akcija = 'add';
		}
		
		if (isset($_POST) && isset($_POST['submit-sezona'])) {

			$god = strip_tags(trim($_POST['godina-sezone']));
			$naz = strip_tags(trim($_POST['naziv-sezone']));
			
			switch($_POST['akcija']) {
				
				case 'edit':
					if ($sezona->update($god, $naz)) {
						$this->register->infos->set_info('Podatak je uspešno promenjen.');
					}
					else {
						$this->register->infos->set_error('Podatak NIJE promenjen! Proverite unete podatke.');
					}
					break;
					
				case 'add':
					if ($sezona->save($god, $naz)) {
						$this->register->infos->set_info('Podatak je uspešno sačuva.');
					}
					else {
						$this->register->infos->set_error('Podatak NIJE sačuvan! Proverite unete podatke.');
					}
					break;
			}
			
		}
		else {
			if (count($action_parts) > 1 && $action_parts[1] == 'delete') {
				//@todo: are you sure!!!
				if ($sezona->delete($action_parts[0])) {
					$this->register->infos->set_info('Podatak je obrisan.');
				}
				else {
					$this->register->infos->set_error('Podatak NIJE obrisan!');
				}
			}
		}
		
	  //load template and return content:
	  $content = "";
		try {
			$content = $this->register->template->load_template('sezona');
		} catch (Exception $e) {
			$this->register->infos->set_error($e->getMessage());
		}
		
		return $content;
	}
	
}