<?php

namespace Catrobat\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="media_package_category")
 */
class MediaPackageCategory
{
  public $file;
  public $removed_id;
  public $old_extension;

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(type="text", nullable=false)
   */
  protected $name;

  /**
   * @ORM\ManyToOne(targetEntity="MediaPackage", inversedBy="categories")
   **/
  protected $package;

  /**
   * @ORM\ManyToMany(targetEntity="MediaPackageFile", mappedBy="category")
   */
  protected $files;

  /**
   * @ORM\Column(type="string")
   */
  protected $extension;

  /**
   * @ORM\Column(type="integer")
   */
  protected $priority = 0;

  /**
   * @ORM\Column(type="integer")
   */
  protected $title_image_or_both = 0;

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param mixed $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @return mixed
   */
  public function getPackage()
  {
    return $this->package;
  }

  /**
   * @param mixed $package
   */
  public function setPackage($package)
  {
    $this->package = $package;
  }

  /**
   * @return mixed
   */
  public function getFiles()
  {
    return $this->files;
  }

  /**
   * @param mixed $files
   */
  public function setFiles($files)
  {
    $this->files = $files;
  }


  public function __toString()
  {
    if($this->package)
      return $this->name." (".$this->package->getName().")";
    else
      return $this->name;
  }

  /**
   * @return mixed
   */
  public function getPriority()
  {
    return $this->priority;
  }

  /**
   * @param mixed $priority
   */
  public function setPriority($priority)
  {
    $this->priority = $priority;
  }

  /**
   * @return mixed
   */
  public function getRemovedId()
  {
    return $this->removed_id;
  }

  /**
   * @param mixed $removed_id
   */
  public function setRemovedId($removed_id)
  {
    $this->removed_id = $removed_id;
  }

  /**
   * @return mixed
   */
  public function getOldExtension()
  {
    return $this->old_extension;
  }

  /**
   * @param mixed $old_extension
   */
  public function setOldExtension($old_extension)
  {
    $this->old_extension = $old_extension;
  }

  /**
   * @return mixed
   */
  public function getExtension()
  {
    return $this->extension;
  }

  /**
   * @param mixed $extension
   */
  public function setExtension($extension)
  {
    $this->extension = $extension;
  }

  /**
   * @return mixed
   */
  public function getFile()
  {
    return $this->file;
  }

  /**
   * @param mixed $file
   */
  public function setFile($file)
  {
    $this->file = $file;
  }

  /**
   * @return mixed
   */
  public function getTitleImageOrBoth()
  {
    return $this->title_image_or_both;
  }

  /**
   * @param mixed $title_image_or_both
   */
  public function setTitleImageOrBoth($title_image_or_both)
  {
    $this->title_image_or_both = $title_image_or_both;
  }

}