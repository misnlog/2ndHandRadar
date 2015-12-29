<?php

namespace App\Presenters;

use Nette;
use App\Forms\RegisterFormFactory;
use Nette\Utils\Html;
use Nette\Security\Passwords;
use Nette\Security;


class RegistrationPresenter extends BasePresenter
{
	/** @var RegisterFormFactory @inject */
	public $factory;
    private $database;


	/**
	 * Register form factory.
	 * @return Nette\Application\UI\Form
	 */
	

    //konstruktor
    public function __construct(Nette\Database\Context $database){
        $this->database = $database;
    }


    protected function createComponentRegisterForm() {
		$form = new Nette\Application\UI\Form;
		
    	$form->addText('username', 'Uživateľské meno:')    		
        	->setRequired('Zadaj svoje užívateľské meno')
        	->setAttribute('class', 'registration-form')        	
        	->addRule(Nette\Application\UI\Form::MIN_LENGTH, 'užívateľské meno musí mať aspoň %d znaky', 3)
        	->addRule(Nette\Application\UI\Form::MAX_LENGTH, 'užívateľské meno musí mať najviac %d znakov', 15);

        $form->addText('email', 'Email:')
        	->setRequired('Zadaj svoj email')
        	->setAttribute('class', 'registration-form')
        	->addRule(Nette\Application\UI\Form::EMAIL, 'Neplatná emailová adresa.');

    	$form->addPassword('password', 'Heslo:')
        	->setRequired('Zadaj svoje heslo')
        	->setAttribute('class', 'registration-form')
        	->addRule(Nette\Application\UI\Form::MIN_LENGTH, 'Heslo musí mať aspoň %d znakov.', 8)
        	->addRule(Nette\Application\UI\Form::MAX_LENGTH, 'Heslo musí mať najviac %d znakov.', 16);

        $form->addPassword('password2', 'Potvrdenie hesla:')
        	->setRequired('Zadaj svoje heslo znovu')
        	->setAttribute('class', 'registration-form')        	
        	->addRule(Nette\Application\UI\Form::EQUAL, 'Heslá sa nezhodujú.', $form['password']);

    	$form->addSubmit('send', 'Registrovať')
    		->setAttribute('class', 'registration-form');

    	$form->onSuccess[] = array($this, 'registerFormSucceeded');
    	return $form;
	}


    public function registerFormSucceeded($form, $values){

            $hash = \Nette\Security\Passwords::hash($values['password']);
               
            
            $reguser=$this->database->table('users')->insert(array(
            'username' => $values->username,
            'password' => $hash,
            'email' => $values->email,            
            )); 
        
        $this->flashMessage("Gratulujeme. Boli ste úspešne zaregistrovaný. Môžte sa prihlásiť do aplikácie.", 'success');
        $this->redirect('Sign:in');      
    }
}