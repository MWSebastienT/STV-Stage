<?php

namespace ConnexionBundle\Event;

use ConnexionBundle\Entity\LogBruteForce;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class Fail implements EventSubscriberInterface
{
    private $request;
    private $em;

    public function __construct(ObjectManager $em,
                                RequestStack $requestStack)
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
    }


    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            KernelEvents::REQUEST => ['beforeFirewall', 10],
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $ip = $this->request->getClientIp(); // on récupère l'ip du client qui a fail
        if (strlen($ip) > 0) {
            $logBruteForce = new LogBruteForce();
            $logBruteForce->setIp($ip);
            $this->em->persist($logBruteForce);
            $this->em->flush();
        }
    }

    public function beforeFirewall(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isMethod(Request::METHOD_POST)) {
            $ip = $request->getClientIp();
            $listOfOneIp = $this->em->getRepository('ConnexionBundle:LogBruteForce')->NbIp($ip);

            if ($listOfOneIp >= 3) {
                $this->em->getRepository('ConnexionBundle:LogBruteForce')->clean();
                throw new \Symfony\Component\HttpKernel\Exception\HttpException(
                    '429',
                    'Trop de t\'entative de reconnexion, veuillez réessayer dans 1 H'
                );
            }
        }
    }
}