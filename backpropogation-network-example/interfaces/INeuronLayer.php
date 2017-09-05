<?php
namespace InterfaceNeuronNetwork;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:07
 */
interface INeuronLayer
{
    /* @return INeuron[] */
    public function getNeurons();

    /* @param $key int
     * @return INeuron */
    public function getNeuron($key);

    /* @return float[] */
    public function getOutputVector();

    /* @param $inputVector float[] */
    public function setInputVector($inputVector);
}