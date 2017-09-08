<?php
namespace NeuronNetwork;
use InterfaceNeuronNetwork;
use InterfaceNeuronNetwork\INeuron;

/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:10
 */
class NeuronLink implements InterfaceNeuronNetwork\INeuronLink
{
    /* @var INeuron */
    private $previousNeuron;
    /* @var float */
    private $weight;

    /* @param $previousNeuron INeuron */
    function __construct($previousNeuron)
    {
        $this->previousNeuron = $previousNeuron;
        $this->initRandomWeight();
    }

    private function initRandomWeight()
    {
        $this->weight = 0.28;//rand(1, 30)/100;
    }

    /* @return INeuron */
    public function getPreviousNeuron()
    {
        return $this->previousNeuron;
    }

    /* @return float */
    public function getWeight()
    {
        return $this->weight;
    }

    /* @param $weight float */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}