<?php

class sudijeController Extends baseController {
	
	/**
	 * Return HTML content
	 * 
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		include_once 'model/sudije.model.php';
		$sudija = new sudijaModel($this->register);
		$this->register->template->sudija = $sudija;
		
		$action_parts = explode('/', $action);
			
		if (count($action_parts) > 1) {
			$this->register->template->id = $action_parts[0];
			$this->register->template->akcija = $action_parts[1];
			if ($action_parts[1] == 'edit') {
				$sudija->get_sudija($action_parts[0]);
			}
		}
		else {
			$this->register->template->akcija = 'add';
		}
		
		if (isset($_POST) && isset($_POST['submit-sudija']) && $sudija->valid_data($_POST)) {
								
			switch($_POST['akcija']) {
		
				case 'edit':
					if ($sudija->update($action_parts[0], $_POST)) {
						$this->register->infos->set_info('Podatak je uspešno promenjen.');
					}
					else {
						$this->register->infos->set_error('Podatak NIJE promenjen! Proverite unete podatke.');
					}
					break;
						
				case 'add':
					if ($sudija->save($_POST)) {
						$this->register->infos->set_info('Podatak je uspešno sačuvan.');
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
				if ($sudija->delete($action_parts[0])) {
					$paths = explode('?', $_SERVER['REQUEST_URI']);
					header('Location: ' . $paths[0] . '?ruta=sudije');
					exit();
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
			$content = $this->register->template->load_template('sudije');
		} catch (Exception $e) {
			$this->register->infos->set_error($e->getMessage());
		}
		
		return $content;
	}
	
}