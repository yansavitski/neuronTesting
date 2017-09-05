<?php
namespace NeuronNetwork;
use InterfaceNeuronNetwork;
use InterfaceNeuronNetwork\INeuron;
use InterfaceNeuronNetwork\INeuronLink;
use InterfaceNeuronNetwork\INeuronLayer;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:09
 */
class Neuron implements INeuron
{
    /* @var IActivationFunction */
    private $activationFunction;
    /* @var INeuronLink[] */
    private $links;
    /* @var float */
    private $result;

    /* @param $activationFunction IActivationFunction
     * @param $previousLayer INeuronLayer
     */
    public function Neuron($activationFunction = null, $previousLayer = null)
    {
        $this->activationFunction = $activationFunction;
        $this->initLinks($previousLayer);
    }

    /* @return INeuronLink[] */
    public function getLinks()
    {
        return $this->links;
    }

    /* @return float[] */
    public function getWeights()
    {
        $weights = [];
        foreach ($this->links as $link) {
            $weights[] = $link->getWeight();
        }

        return $weights;
    }

    /* @return float */
    public function getResult()
    {
        return $this->result;
    }

    /* @param $previousLayer InterfaceNeuronNetwork\INeuronLayer */
    private function initLinks($previousLayer)
    {
        $this->links = [];
        foreach ($previousLayer->getNeurons() as $neuron) {
            $this->links[] = new NeuronLink($neuron);
        }
    }

    /* @param $inputVector float[]
     * @return float
     */
    public function calculateNeuronAnswer($inputVector)
    {
        if (empty($this->links) || count($this->links) != count($inputVector)) {
            return;
        }

        $result = 0;

        foreach ($this->links as $key=>$link) {
            $result += $inputVector[$key] * $link->getWeight();
        }

        $this->result = $this->activationFunction;

        return $this->getResult();
    }
}