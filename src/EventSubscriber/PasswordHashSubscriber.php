<?php 

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

	public static function getSubscribedEvents()
	{
		// Before ( PRE_WRITE ) to the database, run the hassPassword function
		return [
			KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]
		];
	}

	public function hashPassword(ViewEvent $event)
	{
		$user = $event->getControllerResult();
		$method = $event->getRequest()->getMethod();

		// If User is POST ed
		if(! $user instanceof User || Request::METHOD_POST !== $method){
			return;
		}

		$user->setPassword(
			$this->passwordEncoder->encodePassword($user, $user->getPassword())
		);

	}

}