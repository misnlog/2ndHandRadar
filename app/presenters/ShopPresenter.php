<?php
namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form,
    Nette\Utils\Image;


class ShopPresenter extends BasePresenter
{
    /** @var Nette\Database\Context */
    private $database;

    //konstruktor
    public function __construct(Nette\Database\Context $database){
        $this->database = $database;
    }

    //vykreslenie stranky s obchodom
    public function renderShow($shopId){        
    $shop = $this->database->table('shops')->get($shopId);
    if (!$shop) {
        $this->error('Stránka nebola nájdená');
        }

    $this->template->shop = $shop;
    $this->template->comments = $shop->related('comment')->order('created_at');
    $this->template->gallery = $shop->related('gallery');

    

    }

    //formular pre vytvaranie komentarov
    protected function createComponentCommentForm(){
        $form = new Form;
        $form->addTextArea('content', 'Komentár:')
            ->setRequired();

        $form->addSubmit('send', 'Publikovať komentár');

        $form->onSuccess[] = array($this, 'commentFormSucceeded');

        return $form;
    }

    //ulozenie komentara do databaze comments
    public function commentFormSucceeded($form, $values){
        $shopId = $this->getParameter('shopId');
        $this->database->table('comments')->insert(array(
            'shop_id' => $shopId,
            /**'user_id' => $values->user_id,*/
            'content' => $values->content,
            ));

        $this->flashMessage('Ďakujeme za Váš komentár.', 'success');
        $this->redirect('this');

    }

    protected function createComponentShopForm(){
        $form = new Form;
        $countries = array(
            'Europe' => array(
                'Česká Republika' => 'Česká Republika',
                'Slovensko' => 'Slovensko',
                'Velká Británia' => 'Velká Británia',
            ),
            'CA' => 'Kanada',
            'US' => 'USA',        
        );

        $hours = array(
            '1'=>'01',

            );

        $form->addText('name', 'Názov:')
            ->setRequired('Nezabudni vyplniť názov sekáču.')
            ->setAttribute('placeholder', 'Názov sekáču');        

        $form->addText('street', 'Ulica:')
            ->setRequired('Vyplň prosím kompletnú adresu sekáču.')
            ->setAttribute('placeholder', 'Ulica');

        $form->addText('house_number', 'Číslo:')
            ->setRequired('Vyplň prosím kompletnú adresu sekáču.')
            ->setAttribute('placeholder', 'Číslo');

        $form->addText('city', 'Mesto:')
            ->setRequired('Vyplň prosím kompletnú adresu sekáču.')
            ->setAttribute('placeholder', 'Mesto');

        $form->addSelect('country', 'Krajina:', $countries);
            

        $form->addTextArea('about', 'Popis:')
            ->setRequired('Opíš sekáč aspoň pár vetami.')
            ->setAttribute('placeholder', 'Popis');

        $form->addCheckbox('monday', 'Otvorené');

        $form->addText('monday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')            
            //->setDefaultValue('00:00')
            ->addConditionOn($form['monday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');
                

        $form->addText('monday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            //->setOption('description', 'Čas zapíš prosím vo formáte 00:00.')
            //->setDefaultValue('00:00')
            ->addConditionOn($form['monday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('tuesday', 'Otvorené');

        $form->addText('tuesday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['tuesday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('tuesday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['tuesday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('wednesday', 'Otvorené');

        $form->addText('wednesday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['wednesday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('wednesday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['wednesday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('thursday', 'Otvorené');

        $form->addText('thursday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['thursday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('thursday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['thursday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('friday', 'Otvorené');

        $form->addText('friday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['friday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('friday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['friday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('saturday', 'Otvorené');

        $form->addText('saturday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['saturday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('saturday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['saturday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addCheckbox('sunday', 'Otvorené');

        $form->addText('sunday_open', 'Od:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['sunday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');

        $form->addText('sunday_closed', 'do:')
            ->setAttribute('placeholder', 'formát 00:00')
            ->addConditionOn($form['sunday'], Nette\Application\UI\Form::EQUAL, TRUE)
                ->setRequired('Vyplň prosím otváracie hodiny sekáču.');   


        $form->addText('url', 'Web:')
            ->setAttribute('placeholder', 'Webová stránka sekáču');

        $form->addText('phone', 'Tel. kontakt:')
            ->setAttribute('placeholder', 'Tel. kontakt');

        $form->addText('email', 'Email:')
            ->setAttribute('placeholder', 'Kontaktný email');
            //->addRule(Nette\Application\UI\Form::EMAIL, 'Neplatná emailová adresa.');

        $form->addUpload('profile_photo', 'Profilová fotka:')
            ->setRequired('Prosím pridaj fotku sekáču.')
            ->addRule(Nette\Application\UI\Form::IMAGE, 'Obrázok musí byť vo formáte JPEG, PNG alebo GIF.')
            ->addRule(Nette\Application\UI\Form::MAX_FILE_SIZE, 'Maximálna velikosť súboru je 300 kB.', 300 * 1024 /* v bytech */);


        $form->addMultiUpload('images', 'Fotky:')
            ->setAttribute('placeholder', 'Vyber fotky')
            ->addRule(Nette\Application\UI\Form::IMAGE, 'Obrázok musí byť vo formáte JPEG, PNG alebo GIF.')
            ->addRule(Nette\Application\UI\Form::MAX_FILE_SIZE, 'Maximálna velikosť súboru je 300 kB.', 300 * 1024 /* v bytech */);

        $form->addSubmit('send', 'Uložiť sekáč');
        $form->onSuccess[] = array($this, 'shopFormSucceeded');

        return $form;
    }

    public function shopFormSucceeded($form, $values){
        //zabezpecenie callbacku formulara
        if (!$this->getUser()->isLoggedIn()) {
        $this->error('Pro vytvoření, nebo editování příspěvku se musíte přihlásit.');
        }
        
        $shopId = $this->getParameter('shopId');        

        if ($shopId) {
            $shop = $this->database->table('shops')->get($shopId);
            $shop->update(array(
            'name' => $values->name,
            'street' => $values->street,
            'house_number' => $values->house_number,
            'city' => $values->city,
            'country' => $values->country,
            'about' => $values->about,
            'monday' => $values->monday,
            'monday_open' => $values->monday_open,
            'monday_closed' => $values->monday_closed,
            'tuesday' => $values->tuesday,
            'tuesday_open' => $values->tuesday_open,
            'tuesday_closed' => $values->tuesday_closed,
            'wednesday' => $values->wednesday,
            'wednesday_open' => $values->wednesday_open,
            'wednesday_closed' => $values->wednesday_closed,
            'thursday' => $values->thursday,
            'thursday_open' => $values->thursday_open,
            'thursday_closed' => $values->thursday_closed,
            'friday' => $values->friday,
            'friday_open' => $values->friday_open,
            'friday_closed' => $values->friday_closed,
            'saturday' => $values->saturday,
            'saturday_open' => $values->saturday_open,
            'saturday_closed' => $values->saturday_closed,
            'sunday' => $values->sunday,
            'sunday_open' => $values->sunday_open,
            'sunday_closed' => $values->sunday_closed,
            'url' => $values->url,
            'phone' => $values->phone,
            'email' => $values->email,

            ));

        } else {
            //$shop = $this->database->table('shops')->insert($values);
            $shop=$this->database->table('shops')->insert(array(
            'name' => $values->name,
            'street' => $values->street,
            'house_number' => $values->house_number,
            'city' => $values->city,
            'country' => $values->country,
            'about' => $values->about,
            'monday' => $values->monday,
            'monday_open' => $values->monday_open,
            'monday_closed' => $values->monday_closed,
            'tuesday' => $values->tuesday,
            'tuesday_open' => $values->tuesday_open,
            'tuesday_closed' => $values->tuesday_closed,
            'wednesday' => $values->wednesday,
            'wednesday_open' => $values->wednesday_open,
            'wednesday_closed' => $values->wednesday_closed,
            'thursday' => $values->thursday,
            'thursday_open' => $values->thursday_open,
            'thursday_closed' => $values->thursday_closed,
            'friday' => $values->friday,
            'friday_open' => $values->friday_open,
            'friday_closed' => $values->friday_closed,
            'saturday' => $values->saturday,
            'saturday_open' => $values->saturday_open,
            'saturday_closed' => $values->saturday_closed,
            'sunday' => $values->sunday,
            'sunday_open' => $values->sunday_open,
            'sunday_closed' => $values->sunday_closed,
            'url' => $values->url,
            'phone' => $values->phone,
            'email' => $values->email,
            'image_path' => $this->processPhoto($values->profile_photo),
            ));

            $shopId=$shop->id;
            $values = $form->getValues();
            $gallery = $values['images'];
            foreach ($gallery as $photo) {
                $name = $this->processPhoto($photo);
                $shop2=$this->database->table('gallery')->insert(array(
                'shop_id' => $shopId,
                'image_path' => $name,
            ));          
            }

            //$shopId = $this->database->getInsertId();

            
            
        }

        $this->flashMessage("Sekáč bol úspešne uložený.", 'success');
        $this->redirect('show', $shop->id);      
    }

//umozni editovat sekace iba prihlasenym uzivatelom
    public function actionEdit($shopId){

        if (!$this->getUser()->isLoggedIn()) {
        $this->redirect('Sign:in');
        }

        $shop = $this->database->table('shops')->get($shopId);
        if(!$shop){
            $this->error('Sekáč sme nenašli.');
        }

        $this['shopForm']->setDefaults($shop->toArray());
    }

//umozneni pridavat sekace iba prihlasenym uzivatelom
    public function actionCreate(){
        if(!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    private function processPhoto($photo){
        $name = $photo->getName();
        $image = $photo->toImage();
        $thumb = $photo->toImage();
        $original = $photo->toImage();

        
        $path = $this->context->expand('%appDir%'.\DIRECTORY_SEPARATOR. '..'.\DIRECTORY_SEPARATOR . 'www'. \DIRECTORY_SEPARATOR . 'images');
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        $image->resize(1000, 800);
        $thumb->resize(215, 230, Nette\Utils\Image::EXACT);

        $time = time();
        $hash = substr(md5($name), 0, 12);
        $newName = $time . '_' . $hash . '.' .$ext;
        $image->save($path . \DIRECTORY_SEPARATOR . 'full' . \DIRECTORY_SEPARATOR . $newName);
        $thumb->save($path .  \DIRECTORY_SEPARATOR. 'thumbs'. \DIRECTORY_SEPARATOR . $newName);
        $original->save($path . \DIRECTORY_SEPARATOR. 'originals' . \DIRECTORY_SEPARATOR . $newName);
        return $newName;
    }

}