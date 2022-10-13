<?php

namespace Plugin\ProductVideo42\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ProductVideo42\Form\Type\Admin\ConfigType;
use Plugin\ProductVideo42\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/product_video/config", name="product_video42_admin_config")
     * @Template("@ProductVideo42/admin/config.twig")
     */
    public function index(Request $request)
    {
        $Config = $this->configRepository->get();
        $form = $this->createForm(ConfigType::class, $Config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Config = $form->getData();
            $this->entityManager->persist($Config);
            $this->entityManager->flush();
            $this->addSuccess(trans('plugin.settings.product_video.message_success'), 'admin');

            return $this->redirectToRoute('product_video42_admin_config');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
