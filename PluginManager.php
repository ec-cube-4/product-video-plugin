<?php
namespace Plugin\ProductVideo4;

use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Eccube\Entity\Page;

class PluginManager extends AbstractPluginManager
{
    private $originalDir = __DIR__.'/Resource/template/default/';

    private $template = 'product_video.twig';

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        $this->copyBlock($container);
        // /** @var EntityManagerInterface $entityManager */
        // $entityManager = $container->get('doctrine')->getManager();
        // $PageLayout = $entityManager->getRepository(Page::class)->findOneBy(['url' => 'plugin_coupon_shopping']);
        // if (is_null($PageLayout)) {
        //     // pagelayoutの作成
        //     // $this->createPageLayout($container);
        // }
    }

    /**
     * Copy block template.
     *
     * @param ContainerInterface $container
     */
    private function copyBlock(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        // ファイルコピー
        $file = new Filesystem();
        // ブロックファイルをコピー
        $file->copy($this->originalDir.$this->template, $templateDir.'/ProductVideo4/default/'.$this->template);
    }

}