<?php

namespace Plugin\ProductVideo42\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{
    /**
     * @var ProductVideo[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\ProductVideo42\Entity\ProductVideo", mappedBy="Product", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "id"="ASC"
     * })
     */
    private $ProductVideos;

    /**
     * @return ProductVideo[]|Collection
     */
    public function getProductVideos()
    {
        if (null === $this->ProductVideos) {
            $this->ProductVideos = new ArrayCollection();
        }

        return $this->ProductVideos;
    }

    /**
     * @param ProductVideo $ProductVideo
     */
    public function addProductVideo(ProductVideo $ProductVideo)
    {
        if (null === $this->ProductVideos) {
            $this->ProductVideos = new ArrayCollection();
        }

        $this->ProductVideos[] = $ProductVideo;
    }

    /**
     * @param ProductVideo $ProductVideo
     *
     * @return bool
     */
    public function removeProductVideo(ProductVideo $ProductVideo)
    {
        if (null === $this->ProductVideos) {
            $this->ProductVideos = new ArrayCollection();
        }

        return $this->ProductVideos->removeElement($ProductVideo);
    }
}
