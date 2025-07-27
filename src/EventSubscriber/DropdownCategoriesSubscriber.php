<?php

namespace App\EventSubscriber;


use App\Repository\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class DropdownCategoriesSubscriber implements EventSubscriberInterface
{
public const ROUTES = ['app_main_all'];

public function __construct(private readonly CategoryRepository $categoryRepository, private readonly Environment $twig)
{}
    public function injectGlobalVariable(RequestEvent $event): void
{
    $route = $event->getRequest()->get('_route');
    if(in_array($route, self::ROUTES, true)){
        $categories = $this->categoryRepository->findAll();
        $this->twig->addGlobal('allCategories',$categories);
    }
}

public static function getSubscribedEvents(): array
{
    return [KernelEvents::REQUEST=>'injectGlobalVariable'];
}

}
