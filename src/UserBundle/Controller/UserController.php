<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function adminAction(Request $request)
    {

        return $this->render('@User/Admin/base2.html.twig');
    }

    public function ClientAction(Request $request)
    {

        return $this->render('@User/Client/base2.html.twig');
    }
    public function AgentGestAction(Request $request)
    {

        return $this->render('@User/AgentGestionnaire/base2.html.twig');
    }
    public function AgentTraAction(Request $request)
    {
        return $this->render('@User/AgentTransport/base2.html.twig');
    }
    public function AgentFinancAction(Request $request)
    {
        return $this->render('@User/AgentFinancier/base2.html.twig');
    }

}
