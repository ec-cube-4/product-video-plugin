<?php

namespace Plugin\ProductVideo42;

use Eccube\Event\TemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductVideoEvent implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            '@admin/Product/product.twig' => 'onRenderAdminProduct',
            'Product/detail.twig' => 'onRenderProductDetail',
        ];
    }

    /**
     * Front: Display related products on the product detail screen.
     *
     * @param TemplateEvent $event
     */
    public function onRenderProductDetail(TemplateEvent $event)
    {
        $event->addSnippet('Block/ProductVideo42/product_video.twig');
    }

    /**
     * Management screen: Display the related product registration form on the product registration screen.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminProduct(TemplateEvent $event)
    {
        $event->addSnippet('@ProductVideo42/admin/product_video.twig');
    }
}
