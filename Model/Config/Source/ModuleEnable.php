<?php
/**
 * Created by PhpStorm.
 * User: edvardas
 * Date: 18.11.2
 * Time: 10.28
 */

namespace Edvardas\Special\Model\Config\Source;

class ModuleEnable implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '1' => 'Yes',
            '0' => 'No',
        ];}

}