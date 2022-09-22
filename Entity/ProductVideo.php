<?php

namespace Plugin\ProductVideo42\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\AbstractEntity;
use Eccube\Entity\Product;

/**
 * ProductVideo
 *
 * @ORM\Table(name="plg_product_video")
 * @ORM\Entity(repositoryClass="Plugin\ProductVideo42\Repository\ProductVideoRepository")
 */
class ProductVideo extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="text", nullable=true)
     */
    private $video_url;

     /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=true, options={"unsigned":true})
     */
    protected $sort_no;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $Product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetimetz")
     */
    private $create_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetimetz")
     */
    private $update_date;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $video_name
     *
     * @return ProductVideo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get video_url.
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * Set video_url.
     *
     * @param string $video_url
     *
     * @return ProductVideo
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;

        return $this;
    }

    /**
     * Set Product.
     *
     * @param Product $Product
     *
     * @return $this
     */
    public function setProduct(Product $Product)
    {
        $this->Product = $Product;

        return $this;
    }

    /**
     * Get Product.
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * Set sortNo.
     *
     * @param int|null $sortNo
     *
     * @return Cart
     */
    public function setSortNo($sortNo = null)
    {
        $this->sort_no = $sortNo;

        return $this;
    }

    /**
     * Get sortNo.
     *
     * @return int|null
     */
    public function getSortNo()
    {
        return $this->sort_no;
    }

    /**
     * getContent.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * set related product content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set create_date.
     *
     * @param \DateTime $createDate
     *
     * @return $this
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date.
     *
     * @param \DateTime $updateDate
     *
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
