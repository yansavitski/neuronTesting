<?php

/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 29.08.2017
 * Time: 16:31
 */
include("ThresholdFunction.php");
include("Neuron.php");
class NeuronNetwork
{
    private $outputNeurons;
    private $hiddenLayer;
    CONST OUTPUTVAL = [
        '0' => 'Ничего не делать',
        '1' => 'Атаковать',
        '2' => 'Бежать',
        '3' => 'Прятаться'
    ];

    public function creteNetwork()
    {
        $activation = new ThresholdFunction();

        for($i = 0; $i < 3; $i++) {
            $neuron = new Neuron([0, 0, 0]);
            $neuron->setActivationFunction($activation);
            $this->hiddenLayer[] = $neuron;
        }
        for($i = 0; $i < 4; $i++) {
            $neuron = new Neuron($this->hiddenLayer);
            $neuron->setActivationFunction($activation);
            $neuron->setValue(self::OUTPUTVAL[$i]);
            $this->outputNeurons[] = $neuron;
        }
    }

    public function study($indexCorrectOutputNeuron, $input)
    {
        $answer = true;
        $output = $this->transfer($input);
        $indexAnswerNetwork = array_keys($output, max($output))[0];
        if($indexAnswerNetwork != $indexCorrectOutputNeuron)
        {
            $answer = false;
        }
        $sigma = [];
        foreach($this->outputNeurons as $key=>$outputNeuron)
        {
            $value = $output[$key];
            if($key != $indexCorrectOutputNeuron) {
                $sigma[$key] = pow($value, 3) - pow($value, 2);
            } else {
                $sigma[$key] = $value - 2 * pow($value, 2) + pow($value, 3);
            }
            $outputNeuron->educateUpOutLayer($sigma[(count($sigma)-1)]);
        }

        foreach($this->hiddenLayer as $hiddenKey=>$hiddenNeuron)
        {
            $sumAndWeight = 0;
            foreach($this->outputNeurons as $key=>$outputNeuron)
            {
                $sumAndWeight += $outputNeuron->getWeight($hiddenKey) * $sigma[$key];
            }
            $hiddenNeuron->educateUpHidLayer($input, $sumAndWeight);
        }
        return $answer;
    }

    public function transfer($input)
    {
        $output = [];
        $hiddenInput = [];
        foreach($this->hiddenLayer as $hiddenNeuron)
        {
            $hiddenInput[] = $hiddenNeuron->calculateAnswer($input);
        }
        foreach($this->outputNeurons as $outputNeuron)
        {
            $output[] = $outputNeuron->calculateAnswer($hiddenInput);
        }
        return $output;
    }
}