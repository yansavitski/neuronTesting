<?php
namespace NeuronNetwork;
use InterfaceNeuronNetwork;
use InterfaceNeuronNetwork\INeuronLayer;
use InterfaceNeuronNetwork\INeuron;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:08
 */
class NeuronLayer implements INeuronLayer
{
    /* @var INeuron[] */
    private $neurons;

    /* @param $countNeurons int
     * @param $previousLayer INeuronLayer */
    function __construct($countNeurons, $previousLayer = null)
    {
        $this->initNeurons($countNeurons, $previousLayer);
    }

    /* @param $countNeurons int
     * @param $previousLayer INeuronLayer */
    private function initNeurons($countNeurons, $previousLayer = null)
    {
        $activationFunction = new SigmoidFunction();
        for ($index = 0; $index < $countNeurons; $index++) {
            $this->neurons[] = new Neuron($activationFunction, $previousLayer);
        }
    }

    /* @return INeuron[] */
    public function getNeurons()
    {
        return $this->neurons;
    }

    /* @param $key int
     * @return INeuron
     */
    public function getNeuron($key)
    {
        if (array_key_exists($key, $this->neurons)) {
            return $this->neurons[$key];
        }
    }

    /* @return float[] */
    public function getOutputVector()
    {
        $outputVector = [];
        foreach ($this->neurons as $neuron) {
            $outputVector[] = $neuron->getResult();
        }

        return $outputVector;
    }

    /* @param $inputVector float[] */
    public function setInputVector($inputVector)
    {
        foreach ($this->neurons as $key => $neuron) {
            $neuron->calculateNeuronAnswer($inputVector);
        }
    }
}