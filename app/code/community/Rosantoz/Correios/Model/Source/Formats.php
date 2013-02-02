<?php

/**
 * Este arquivo contém uma classe auxiliar que lista os
 * formatos da encomenda dentro das configuração do módulo
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
 * Lista os formatos de encomenda nas configuração do módulo
 *
 * @category Pet_Projects
 * @package  Rosantoz_Correios
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: <1.0>
 * @link     https://rodrigodossantos.ws
 */
class Rosantoz_Correios_Model_Source_Formats
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => Mage::helper('adminhtml')->__('Caixa')),
            array('value' => '2', 'label' => Mage::helper('adminhtml')->__('Rolo')),
            array('value' => '3', 'label' => Mage::helper('adminhtml')->__('Envelope')),
        );
    }
}
