<?php

namespace App\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{

   /** @var Nette\Database\Context */
   /**konstruktor zaistujuci propojenie k databaze*/
  private $database;

  public function __construct(Nette\Database\Context $database)
  {
    $this->database = $database;
  }

	  
  /**nacitanie prispevkov z databaze a poslanie do sablony - v premennej shops*/
  
  public function renderDefault()
  {
    $this->template->shops = $this->database->table('shops')
        ->order('added_at DESC')
        ->limit(20);

   // $this->template->gallery = $this->database->table('gallery');

    //$this->$database->query('SELECT image_path FROM gallery WHERE id=?', $shop->id)->dump();

    
  }



}