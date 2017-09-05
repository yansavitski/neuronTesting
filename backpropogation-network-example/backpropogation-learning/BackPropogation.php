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
    private $stepLearning;

    public function BackPropogation($stepLearning = 0.1)
    {
        $this->stepLearning = $stepLearning;
    }

    public function setLayers($layers)
    {
        $this->layers = $layers;
    }

    public function study($outputVector)
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
        $delta = $this->calculatedDelta($layer->getNeurons(), $countLastLayerDelta, $outputVector);

        $lastHiddenLayerKey = $outputLayerKey - 1;
        for ($index = $lastHiddenLayerKey; $index >= 0; $index--) {
            $layer = $this->layers[$index];
            $sumDeltaAndWeight = $this->countSumDeltaAndWeight($this->layers[($index + 1)], $delta);
            $delta = $this->calculatedDelta($layer->getNeurons(), $countHiddenLayerDelta, $sumDeltaAndWeight);
        }
    }

    /* @param $neurons INeuron[] */
    public function calculatedDelta($neurons, $method, $value)
    {
        $delta = [];
        foreach ($neurons as $key => $neuron) {
            $out = $neuron->getResult();
            $delta[$key] = $method($out, $value[$key]);
        }

        return $delta;
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