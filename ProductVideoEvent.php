<?php

namespace Plugin\ProductVideo4;

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
     * フロント：商品詳細画面に関連商品を表示する.
     *
     * @param TemplateEvent $event
     */
    public function onRenderProductDetail(TemplateEvent $event)
    {
        $event->addSnippet('@ProductVideo4/front/product_video.twig');
    }

    /**
     * 管理画面：商品登録画面に関連商品登録フォームを表示する.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminProduct(TemplateEvent $event)
    {
        $event->addSnippet('@ProductVideo4/admin/product_video.twig');
    }
}
