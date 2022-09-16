<?php

namespace Plugin\ProductVideo4\Form\Extension\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Plugin\ProductVideo4\Repository\ConfigRepository;
use Eccube\Entity\Product;
use Eccube\Form\Type\Admin\ProductType;
use Plugin\ProductVideo4\Entity\ProductVideo;
use Plugin\ProductVideo4\Form\Type\Admin\ProductVideoType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Plugin\ProductVideo4\Entity\Config;

/**
 * Class VideoCollectionExtension.
 */
class VideoCollectionExtension extends AbstractTypeExtension
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(
        ConfigRepository $configRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->configRepository = $configRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * VideoCollectionExtension.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ProductVideos', CollectionType::class, [
                'label' => 'product_video.block.title',
                'entry_type' => ProductVideoType::class,
            ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Product $Product */
            $Product = $event->getData();
            $Config = $this->configRepository->get();
            $max = empty($Config) ? Config::DEFAULT_MAX : $Config->getVideoMax() ;
            $ProductVideos = $Product->getProductVideos();

            for ($i = 0; $i < $max; $i++) {
                if (!isset($ProductVideos[$i])) {
                    $ProductVideo = new ProductVideo();
                    $ProductVideo->setProduct($Product);
                    $Product->addProductVideo($ProductVideo);
                }
            }
            $form = $event->getForm();
            $form['ProductVideos']->setData($Product->getProductVideos());
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var Product $Product */
            $Product = $event->getData();
            $ProductVideos = $Product->getProductVideos();
            
            foreach ($ProductVideos as $ProductVideo) {
                if (null === $ProductVideo->getVideoUrl()) {
                    $Product->removeProductVideo($ProductVideo);
                    $this->entityManager->remove($ProductVideo);
                }
            }
        });


    }

    /**
     * product admin form name.
     *
     * @return string
     */
    public function getExtendedType()
    {
        return ProductType::class;
    }

    /**
     * product admin form name.
     *
     * @return string[]
     */
    public static function getExtendedTypes()
    {
        yield ProductType::class;
    }
}
