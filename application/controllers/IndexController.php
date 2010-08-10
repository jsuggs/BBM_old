<?php

use Zend\Controller\Action,
    BBM\GameRepository;

class IndexController extends Action
{
    public function indexAction()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $em = $bootstrap->getResource('doctrine');
        $gameRepository = new GameRepository($em);

        $this->view->games = $gameRepository->getAllGames();
    }
}
