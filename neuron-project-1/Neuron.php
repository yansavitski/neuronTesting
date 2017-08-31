<?php

/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 29.08.2017
 * Time: 15:11
 */
include("INeuron.php");
class Neuron implements INeuron
{
    /*
     * @param IActivationFunction */
    private $function;
    private $stepEducate;
    private $prevNeuronLayer;
    private $weights;
    private $value;
    private $resultPrevLayer;

    public function Neuron($neurons = null, $stepEducate = 0.1)
    {
        $this->prevNeuronLayer = $neurons;
        $this->stepEducate = $stepEducate;
        $this->initWeights();
    }

    private function initWeights()
    {
        for($i = 0; $i < count($this->prevNeuronLayer); $i++)
        {
            $this->weights[] = rand(0, 1);
        }
    }

    public function setWeights($values)
    {
        $this->weights = $values;
    }

    public function setActivationFunction(IActivationFunction $function)
    {
        $this->function = $function;
    }

    public function educateUpOutLayer($sigma)
    {
        if (!empty($this->prevNeuronLayer)) {
            foreach ($this->prevNeuronLayer as $key => $neuron) {
                $weight = $this->weights[$key] + ($sigma * $neuron->resultPrevLayer) * $this->stepEducate;
                $this->educateUpWeight($key, $weight);
            }
        }
    }

    public function educateUpHidLayer($inputData, $sumAndWeight)
    {
        $sigma = $this->resultPrevLayer * ( 1 - $this->resultPrevLayer) * $sumAndWeight;
        if (!empty($this->prevNeuronLayer)) {
            foreach ($inputData as $key => $input) {
                $weight = $this->weights[$key] + ($sigma * $input) * $this->stepEducate;
                $this->educateUpWeight($key, $weight);
            }
        }
    }

    public function setInputData($input)
    {
        $this->setValue($input);
    }

    public function calculateAnswer($vectorInputData = [])
    {
        if(!empty($vectorInputData))
        {
            $result = 0;
            foreach($this->weights as $key => $value) {
                $result += $vectorInputData[$key] * $value;
            }
            $this->resultPrevLayer =  $this->function->calculateExit($result);
            return $this->resultPrevLayer;
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getWeight($key)
    {
        return $this->weights[$key];
    }

    public function educateUpWeight($key, $weight)
    {
        $this->weights[$key] = $weight;
    }
}