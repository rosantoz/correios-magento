<?php

/**
 * Este arquivo contém uma classe auxiliar que lista os serviços
 * de entrega dos correios dentro da configuração do módulo
 *
 * PHP version 5.3.5
 *
 * @category Pet_Projects
 * @package  Rosantoz_Correios
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://rodrigodossantos.ws
 */

/**
 * Lista os serviços de entrega nas configuração do módulo
 *
 * @category Pet_Projects
 * @package  Rosantoz_Correios
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: <1.0>
 * @link     https://rodrigodossantos.ws
 */
class Rosantoz_Correios_Model_Source_Services
{
    public function toOptionArray()
    {
        return array(
            array('value' => '41106', 'label' => Mage::helper('adminhtml')->__('PAC')),
            array('value' => '40010', 'label' => Mage::helper('adminhtml')->__('SEDEX')),
            array('value' => '40215', 'label' => Mage::helper('adminhtml')->__('SEDEX 10')),
            array('value' => '40290', 'label' => Mage::helper('adminhtml')->__('SEDEX HOJE')),
        );
    }
}
