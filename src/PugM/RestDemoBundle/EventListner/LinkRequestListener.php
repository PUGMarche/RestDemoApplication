<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ftassi
 * Date: 23/05/13
 * Time: 21:46
 * To change this template use File | Settings | File Templates.
 */

namespace PugM\RestDemoBundle\EventListner;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

/**
 * Class LinkRequestListener
 *
 * http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/
 *
 * @package PugM\RestDemoBundle\EventListner
 */
class LinkRequestListener
{
    /**
     * @var ControllerResolverInterface
     */
    private $resolver;
    private $urlMatcher;

    /**
     * @param ControllerResolverInterface $controllerResolver The 'controller_resolver' service
     * @param UrlMatcherInterface $urlMatcher         The 'router' service
     */
    public function __construct(ControllerResolverInterface $controllerResolver, UrlMatcherInterface $urlMatcher)
    {
        $this->resolver = $controllerResolver;
        $this->urlMatcher = $urlMatcher;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->getRequest()->headers->has('link')) {
            return;
        }

        $linkHeader = $event->getRequest()->headers->get('link', null, false);
        $requestMethod = $this->urlMatcher->getContext()->getMethod();
        $this->urlMatcher->getContext()->setMethod('GET');

        // The controller resolver needs a request to resolve the controller.
        $stubRequest = new Request();
        $links = array();
        foreach ($linkHeader as $link) {
            preg_match('/(<)(.*)(>)/', $link, $matches);
            $resource = parse_url($matches[2])['path'];

            try {
                $route = $this->urlMatcher->match($resource);
            } catch (\Exception $e) {
                continue;
            }

            $stubRequest->attributes->replace($route);

            if (false === $controller = $this->resolver->getController($stubRequest)) {
                continue;
            }

            $arguments = $this->resolver->getArguments($stubRequest, $controller);

            try {
                $result = call_user_func_array($controller, $arguments);

                // The key of first item is discarded
                if(!is_null($result)){
                    $links[] = $result;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        $event->getRequest()->attributes->set('links', $links);
        $this->urlMatcher->getContext()->setMethod($requestMethod);
    }
}