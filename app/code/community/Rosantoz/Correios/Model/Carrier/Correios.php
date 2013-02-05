<?php

/**
 * Este arquivo contém a classe Rosantoz_Correios_Model_Carrier_Correios
 * cujo objetivo é realizar a cálculo de frete dos correios de acordo
 * com as configurações do magento.
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
 * Esta classe utiliza a classe RsCorreios para realizar o cálculo de frete
 *
 * @category Pet_Projects
 * @package  Rosantoz_Correios
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: <1.0>
 * @link     https://rodrigodossantos.ws
 */
class Rosantoz_Correios_Model_Carrier_Correios extends Mage_Shipping_Model_Carrier_Abstract
{
    /**
     * Identificador interno do módulo
     *
     * @var string [a-z0-9_]
     */
    protected $_code = 'rosantoz_correios';

    /**
     * Verifica os pré-requisitos para funcionamento do módulo,
     * realiza o cálculo de frete e adiciona no checkout do magento
     *
     * @param Mage_Shipping_Model_Rate_Request $request Informações do pedido
     *
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        // skip if not enabled
        if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
            Mage::log('Rosantoz_Correios: module disabled');
            return false;
        }

        // skip if outside Brazil
        if ($request->getDestCountryId() != 'BR') {
            Mage::log('Rosantoz_Correios: delivery address is outside Brazil');
            return false;
        }

        // skip if the packet weight is over 30 kilos
        if ($request->getPackageWeight() >= 30) {
            Mage::log('Rosantoz_Correios: package is over 30 kilos');
        }


        $methods = $this->getMethods();
        $result  = Mage::getModel('shipping/rate_result');

        foreach ($methods as $rMethod) {
            $method        = Mage::getModel('shipping/rate_result_method');
            $correios      = Mage::getModel('rosantoz_correios/carrier_correios_rscorreios');
            $origin        = Mage::getStoreConfig('shipping/origin/postcode');
            $packageFormat = $this->getConfigData('formato');

            $frete = $correios
                ->setCepOrigem($origin)
                ->setCepDestino($request->getDestPostcode())
                ->setPeso($request->getPackageWeight())
                ->setAltura($request->getPackageHeight())
                ->setLargura($request->getPackageWidth())
                ->setComprimento($request->getPackageDepth())
                ->setFormatoDaEncomenda($packageFormat)
                ->setServico($rMethod);

            // Usar mão própria?
            if(Mage::getStoreConfig('carriers/' . $this->_code . '/mao_propria')) {
                $correios->setMaoPropria(true);
            }

            // Usar aviso de recebimento?
            if(Mage::getStoreConfig('carriers/' . $this->_code . '/aviso_recebimento')) {
                $correios->setAvisoDeRecebimento(true);
            }

            // Usar valor declarado?
            if(Mage::getStoreConfig('carriers/' . $this->_code . '/valor_declarado')) {
                $correios->setValorDeclarado($request->getPackageValue());
            }

            $frete = $correios->dados();

            // loggin error
            if ($frete['erro'] != 0) {
                Mage::log('Rosantoz_Correios: ' . $frete['msg_erro'] . '');
            }

            // skip if tax is zero
            if ($frete['valor'] <= 0) {
                continue;
            }

            $method->setCarrier($this->_code);
            $method->setCarrierTitle(Mage::getStoreConfig('carriers/' . $this->_code . '/title'));

            $method->setMethod(strtolower($correios->getNomeServico($rMethod)));
            $title = $correios->getNomeServico($rMethod);

            $prazo = $this->getConfigData('prazo');
            if (!empty($prazo)) {
                if ($frete['prazoEntrega'] == 1) {
                    $title .= ' (' . $frete['prazoEntrega'] . ' dia útil)';
                } else {
                    $title .= ' (' . $frete['prazoEntrega'] . ' dias úteis)';
                }
            }

            $method->setMethodTitle($title);
            $method->setPrice($frete['valor']);
            $result->append($method);
        }

        return $result;
    }

    /**
     * Retorna o nome do serviço de entrega de acordo com
     * seu respectivo código
     *
     * @return array
     */
    protected function getMethods()
    {
        $servicesList = Mage::getStoreConfig('carriers/' . $this->_code . '/servicos');
        $arr          = explode(',', $servicesList);
        return $arr;
    }
}