<?php

namespace Bigfoot\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Extends the TextType for js upload purpose.
 *
 * Class UploadType
 * @package Bigfoot\Bundle\CoreBundle\Form\Type
 */
class UploadType extends AbstractType
{
    public function getParent()
    {
        return 'text';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'upload';
    }
}
