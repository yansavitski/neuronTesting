<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 17:48
 */

namespace InterfaceNeuronNetwork;

interface INeuronNetwork
{
    /* @param $inputVector float[]
     * @return float[] */
    public function handleData($inputVector);

    /* @return INeuronLayer[] */
    public function getLayers();
}