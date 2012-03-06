<?php
// src/Niepi/BlogBundle/Menu/Builder.php
namespace Niepi\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        $menu->setchildrenAttributes(array('class' => 'nav nav-list'));
        $menu->addChild('Sidebar', array('class' => 'nav-header'));
        $menu->addChild('Dashboard', array('route' => '_admin_index'));
        $menu->addChild('Posts', array('route' => '_posts_list'));
        $menu->addChild('Comments', array('route' => '_comments_list'));        


        return $menu;
    }
}