<?php
namespace InterfaceNeuronNetwork;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:09
 */
interface INeuron
{
    /* @return INeuronLink[] */
    public function getLinks();

    /* @return float[] */
    public function getWeights();

    /* @return float */
    public function getResult();

    /* @param $inputVector float[]
     * @return float */
    public function calculateNeuronAnswer($inputVector);
}