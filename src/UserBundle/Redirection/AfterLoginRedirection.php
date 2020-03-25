<?php


namespace UserBundle\Redirection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request        $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ADMIN', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('admin_dashboard'));
        }
        elseif (in_array('ROLE_GESTIONNAIRE', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('agentgest'));
        }
        elseif (in_array('ROLE_AGENTFINANCIER', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('agentFinan'));
        }
        elseif (in_array('ROLE_AGENTTRANSPORT', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('agentTransport'));
        }
        elseif (in_array('ROLE_CLIENT', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('index_achat'));
        }
        else{
            $redirection = new RedirectResponse($this->router->generate('homepage'));
        }
        return $redirection;
    }

}