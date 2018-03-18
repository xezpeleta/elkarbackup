<?php

namespace Binovo\ElkarBackupBundle\Api;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiController extends FOSRestController
{
    const GRP_USER_BASIC  = 'user-basic';
    const GRP_USER_DETAIL = 'user-detail';

    private function getResponse($data = null, $groups = array('Default'))
    {
        $view = $this->view($data);
        $view->getContext()->enableMaxDepth();
        $view->getContext()->addGroups($groups);
        return $this->handleView($view);
    }

    /**
     * @Get("/users/{id}", name="api_get_user", requirements={"id" = "\d+"})
     * @param integer $id
     */
    public function getUserAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('BinovoElkarBackupBundle:User');
        $user = $repository->find($id);
        if (is_null($user)) {
            $msg = sprintf('User with ID=%d was not found', $id);
            throw new HttpException(Response::HTTP_NOT_FOUND, $msg);
        }
        return $this->getResponse($user, array(self::GRP_USER_DETAIL));
    }

    /**
     * @Get("/users", name="api_get_users")
     */
    public function getUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository('BinovoElkarBackupBundle:User');
        $users = $repository->findAll();
        return $this->getResponse($users, array(self::GRP_USER_BASIC));
    }
}
