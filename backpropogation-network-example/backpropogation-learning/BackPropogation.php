<?php
namespace NeuronLearning;
use InterfaceNeuronNetwork\INeuronLayer;
use InterfaceNeuronNetwork\INeuron;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 18:29
 *
 * delta(LastLayer) = OUT * (1 - OUT) * (T - OUT)
 * delta(HiddensLayer) = OUT * (1 - OUT) * sum(delta(NeuronNextLayer) * w(NeuronNextLayer))
 *
 */
class BackPropogation
{
    /* @var INeuronLayer[] */
    private $layers;
    /* @var float */
    private $stepLearning;

    function __construct($stepLearning = 0.8)
    {
        $this->stepLearning = $stepLearning;
    }

    public function setLayers($layers)
    {
        $this->layers = $layers;
    }

    public function study($expectedOutputVector)
    {
        $countLastLayerDelta = function ($out, $expectedOut)
        {
            return $out * (1 - $out) * ($expectedOut - $out);
        };

        $countHiddenLayerDelta = function ($out, $sumDeltaAndWeight)
            {
            return $out * (1 - $out) * $sumDeltaAndWeight;
        };

        $outputLayerKey = count($this->layers) - 1;
        $layer = $this->layers[$outputLayerKey];
        $delta = $this->calculatedDeltaAndChangedWeights($layer->getNeurons(), $countLastLayerDelta, $expectedOutputVector);

        $lastHiddenLayerKey = $outputLayerKey - 1;
        for ($index = $lastHiddenLayerKey; $index > 0; $index--) {
            $layer = $this->layers[$index];
            $sumDeltaAndWeight = $this->countSumDeltaAndWeight($this->layers[($index + 1)], $delta);
            $delta = $this->calculatedDeltaAndChangedWeights($layer->getNeurons(), $countHiddenLayerDelta, $sumDeltaAndWeight);
        }
    }

    /* @return float */
    public function getStepLearning()
    {
        return $this->stepLearning;
    }

    /* @param $neurons INeuron[]
     * @param $value */
    private function calculatedDeltaAndChangedWeights($neurons, $method, $value)
    {
        $delta = [];
        foreach ($neurons as $key => $neuron) {
            $out = $neuron->getResult();
            $delta[$key] = $method($out, $value[$key]);
            $this->changedWeights($neuron, $delta[$key]);
        }

        return $delta;
    }

    /* @param $neuron INeuron
     * @param $delta float */
    private function changedWeights($neuron, $delta)
    {
        foreach ($neuron->getLinks() as $link) {
            $result = $link->getPreviousNeuron() ? $link->getPreviousNeuron()->getResult() : 0;
            $weight = $link->getWeight() + $this->getStepLearning() * $delta * $result;
            $link->setWeight($weight);
        }
    }

    public function isLastLayer($layer)
    {
        return end($this->layers) === $layer;
    }

    /* @param $layer INeuronLayer
     * @param $delta float[]
     * @return float[] */
    public function countSumDeltaAndWeight($layer, $delta)
    {
        $result = [];
        foreach ($layer->getNeurons() as $key => $neuron) {
            foreach ($neuron->getLinks() as $keyLink => $link) {
                $result[$keyLink] += $link->getWeight() * $delta[$key];
            }
        }

        return $result;
    }
}