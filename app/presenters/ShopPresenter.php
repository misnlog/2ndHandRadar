<?php
namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;


class ShopPresenter extends BasePresenter
{
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderShow($shopId)
    {
        $this->template->shop = $this->database->table('shops')->get($shopId);
    }
}