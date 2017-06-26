<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 16/06/2017
 * Time: 18:11
 */

namespace BM\UserBundle\Services;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Form\Factory\FormFactory;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

class Registration
{
    private $formFactory;
    private $userManager;
    private $dispatcher;

    public function __construct(FormFactory $formFactory, UserManager $userManager, TraceableEventDispatcher $dispatcher)
    {
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->dispatcher = $dispatcher;
    }

    public function registerUser(Request $request)
    {
        $user = $this->userManager->createUser();
        $user->setEnabled(true);

        $form = $this->formFactory->createForm();

        $form->setData($user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            try{
                $this->userManager->updateUser($user, true);
            }catch (UniqueConstraintViolationException $e){
                return false;
            }
        }
        return true;
    }
}