<?php

namespace Plugin\ProductVideo4\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\ProductVideo4\Entity\Config', false)) {
    /**
     * Config
     *
     * @ORM\Table(name="plg_product_video_config")
     * @ORM\Entity(repositoryClass="Plugin\ProductVideo4\Repository\ConfigRepository")
     */
    class Config
    {
        const DEFAULT_MAX = 1;

        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $id;

        /**
         * @var int
         *
         * @ORM\Column(name="video_max", type="smallint", nullable=true, options={"unsigned":true, "default":1})
         */
        private $video_max;

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return int
         */
        public function getVideoMax()
        {
            return $this->video_max;
        }

        /**
         * @param int $video_max
         *
         * @return $this;
         */
        public function setVideoMax($video_max)
        {
            $this->video_max = $video_max;

            return $this;
        }
    }
}
