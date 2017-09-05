<?php
namespace InterfaceNeuronNetwork;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:09
 * It class needed if we can create Kohonen or similar networks
 */
interface INeuronLink
{
    /* @return INeuron */
    public function getPreviousNeuron();

    /* @return float */
    public function getWeight();

    /* @param $weight float */
    public function setWeight($weight);
}