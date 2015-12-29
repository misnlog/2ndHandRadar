<?php

namespace App\Presenters;

use Nette;
use App\Forms\SignFormFactory;
use Nette\Security as NS;


class SignPresenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $factory;



	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Nette\Application\UI\Form;
    	$form->addText('username', 'Uživateľské meno:')
        	->setRequired('Prosím vyplňte svoje užívateľské meno.');

    	$form->addPassword('password', 'Heslo:')
        	->setRequired('Prosím vyplňte svoje heslo.');

    	$form->addCheckbox('remember', 'Zostať prihlásený');

    	$form->addSubmit('send', 'Prihlásiť');
    		//->onClick[] = array($this, 'signInFormSubmitted');

    	$form->onSuccess[] = array($this, 'signInFormSucceeded');
    	return $form;
	}


	public function signInFormSucceeded($form){
    	$values = $form->values;

   		try {
        	$this->getUser()->login($values->username, $values->password);
        	$this->redirect('Homepage:');

    	} catch (Nette\Security\AuthenticationException $e) {
        	$form->addError('Nesprávne prihlasovacie meno alebo heslo.');
        	dump($e);

    	}
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený z aplikácie Radar.');
		$this->redirect('Homepage:');
	}

}