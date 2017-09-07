<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 07.09.2017
 * Time: 19:28
 */

namespace NeuronNetwork;

class FirstLayer extends NeuronLayer
{
    /* @param $inputVector float[] */
    public function setInputVector($inputVector)
    {
        foreach ($this->getNeurons() as $key => $neuron) {
            $neuron->calculateNeuronAnswer([$inputVector[$key]]);
        }
    }
}