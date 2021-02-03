<?php

namespace Thrashzone13\SrtParser;

class SubBlock
{
    protected $number;

    protected $text;

    protected $startTime;

    protected $stopTime;

    public function __construct(int $number, string $text, string $startTime, string $stopTime)
    {
        $this->setNumber($number)
            ->setText($text)
            ->setStartTime($startTime)
            ->setStopTime($stopTime);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = trim($text);
        return $this;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getStopTime(): string
    {
        return $this->stopTime;
    }

    public function setStopTime(string $stopTime): self
    {
        $this->stopTime = $stopTime;
        return $this;
    }
}
