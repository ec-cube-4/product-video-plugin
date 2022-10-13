<?php
namespace Plugin\ProductVideo42;

use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Eccube\Entity\Block;
use Eccube\Entity\Master\DeviceType;

class PluginManager extends AbstractPluginManager
{
    private $originalDir = __DIR__.'/Resource/template/front/';
    
    private $file_name = 'product_video';

    private $template = 'product_video.twig';

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        $this->copyBlock($container);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine')->getManager();
        $Block = $entityManager->getRepository(Block::class)->findOneBy([
            'file_name' => 'ProductVideo42/' . $this->file_name]
        );
        if (is_null($Block)) {
            $this->createBlock($container);
        }
    }

    /**
     * Copy block template.
     *
     * @param ContainerInterface $container
     */
    private function copyBlock(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        // file copy
        $file = new Filesystem();
        // copy block file
        $file->copy($this->originalDir.$this->template, $templateDir.'/Block/ProductVideo42/'.$this->template);
    }

    private function createBlock(ContainerInterface $container)
    {
        // Assign values to page layouts when using plugins
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine')->getManager();

        $DeviceType = $entityManager->getRepository(DeviceType::class)
            ->find(DeviceType::DEVICE_TYPE_PC);

        /** @var Block $Block */
        $Block = $entityManager->getRepository(Block::class)->newBlock($DeviceType);
        $Block->setDeviceType($DeviceType)
            ->setName('product video')
            ->setFileName('ProductVideo42/' . $this->file_name)
            ->setDeletable(false);

        $entityManager->persist($Block);
        $entityManager->flush($Block);
    }

    /**
     * Remove block.
     *
     * @param ContainerInterface $container
     */
    private function removeBlock(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        $file = new Filesystem();
        $file->remove($templateDir.'/Block/ProductVideo42/' . $this->template);
    }

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function disable(array $meta, ContainerInterface $container)
    {
        $this->removeBlock($container);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine')->getManager();
        $Block = $entityManager->getRepository(Block::class)->findOneBy([
            'file_name' => 'ProductVideo42/'.$this->file_name
        ]);
        
        if ($Block) {
            // Remove block 
            $entityManager->remove($Block);
            $entityManager->flush();
        }
    }
}
