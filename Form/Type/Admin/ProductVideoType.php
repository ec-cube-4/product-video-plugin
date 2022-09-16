<?php

namespace Plugin\ProductVideo4\Form\Type\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Plugin\ProductVideo4\Entity\ProductVideo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ProductVideoType.
 */
class ProductVideoType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * ProductVideoType constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        EntityManagerInterface $entityManager, 
        ValidatorInterface $validator,
        EccubeConfig $eccubeConfig
    ) {
        $this->entityManager = $entityManager;
        $this->eccubeConfig = $eccubeConfig;
        $this->validator = $validator;
    }

    /**
     * ProductVideo form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => trans('product_video.type.title'),
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
                'attr' => [
                    'placeholder' => trans('product_video.type.title.placeholder'),
                ],
            ])
            ->add('video_url', TextareaType::class, [
                'label' => trans('product_video.type.video_url'),
                'required' => false,
                'attr' => [
                    'placeholder' => trans('product_video.type.video_url.placeholder'),
                ],
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var ProductVideo $Product */
            $ProductVideo = $event->getData();
            if (
                null != $ProductVideo->getVideoUrl() && 
                $ProductVideo->getTitle() == null
            ) {
                $errors = $this->validator->validate($ProductVideo['title'], [
                    new Assert\NotBlank(),
                ]);
                $this->addErrors('title', $form, $errors);
            }

            if (
                null == $ProductVideo->getVideoUrl() && 
                $ProductVideo->getTitle() != null
            ) {
                $errors = $this->validator->validate($ProductVideo['video_url'], [
                    new Assert\NotBlank(),
                ]);
                $this->addErrors('video_url', $form, $errors);
            }
            
        });
    }

    protected function addErrors($key, FormInterface $form, ConstraintViolationListInterface $errors)
    {
        foreach ($errors as $error) {
            $form[$key]->addError(new FormError($error->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductVideo::class,
        ]);
    }
}
