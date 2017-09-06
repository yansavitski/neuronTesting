<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 17:52
 */

namespace NeuronNetwork;
use InterfaceNeuronNetwork\INeuronLayer;
use InterfaceNeuronNetwork\INeuronNetwork;

class PerceptronNetwork implements INeuronNetwork
{
    /* @var INeuronLayer[] */
    private $layers;

    /* @param $networkMap int[] */
    function __construct($networkMap)
    {
        $this->initNetworkByMap($networkMap);
    }

    private function initNetworkByMap($networkMap)
    {
        foreach ($networkMap as $key => $countNeurons) {
            $lastLayer = !empty($this->layers) ? end($this->layers) : null;
            $this->layers[] = new NeuronLayer($countNeurons, $lastLayer);
        }
    }

    /* @param $inputVector float[]
     * @return float[]
     */
    public function handleData($inputVector)
    {
        foreach ($this->layers as $key => $layer) {
            $layer->setInputVector($inputVector);
            $inputVector = $layer->getOutputVector();
        }

        return $inputVector;
    }

    /* @return INeuronLayer[] */
    public function getLayers()
    {
        return $this->layers;
    }
}