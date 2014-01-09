<?php

/**
 * Este arquivo contém uma classe auxiliar que lista os
 * tipos de taxas adicionais que podem ser cobradas
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
 * Lista os formatos de taxa adicional nas configuração do módulo
 *
 * @category Pet_Projects
 * @package  Rosantoz_Correios
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: <1.1>
 * @link     https://rodrigodossantos.ws
 */
class Rosantoz_Correios_Model_Source_Taxes
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label' => Mage::helper('adminhtml')->__('Nenhum')),
            array('value' => '1', 'label' => Mage::helper('adminhtml')->__('Valor Fixo')),
            array('value' => '2', 'label' => Mage::helper('adminhtml')->__('Porcentagem')),
        );
    }
}
