<?php

namespace Thrashzone13\SrtParser;

class SrtParser
{
    const states = [
        'SRT_STATE_SUBNUMBER'   => 0,
        'SRT_STATE_TIME'        => 1,
        'SRT_STATE_TEXT'        => 2,
        'SRT_STATE_BLANK'       => 3,
    ];

    protected $file;

    protected $subNumber;

    protected $subText;

    protected $subTime;

    protected $parseState;

    protected $subBlocks = [];

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function parse(): array
    {
        $lines = new \SplFileObject($this->file);

        $this->state   = self::states['SRT_STATE_SUBNUMBER'];

        while (!$lines->eof()) {

            $line = $lines->fgets();

            switch ($this->parseState) {
                case self::states['SRT_STATE_SUBNUMBER']:
                    $this->parseSubNumber($line);
                    break;
                case self::states['SRT_STATE_TIME']:
                    $this->parseTime($line);
                    break;
                case self::states['SRT_STATE_TEXT']:
                    $this->parseText($line);
                    break;
            }
        }

        if ($this->state == self::states['SRT_STATE_TEXT']) {
            // if file was missing the trailing newlines, we'll be in this
            // state here.  Append the last read text and add the last sub.
            $lastSubBlock = end($this->subBlocks);
            $lastSubBlock->setText($this->subText);
        }

        return $this->subBlocks;
    }

    protected function parseSubNumber(string $line)
    {
        $this->subNumber = trim($line);
        $this->parseState  = self::states['SRT_STATE_TIME'];
    }

    protected function parseTime(string $line)
    {
        $this->subTime = explode(' --> ', $line);
        $this->state   = self::states['SRT_STATE_TEXT'];
    }

    protected function parseText(string $line)
    {
        if (trim($line) == '') {
            $this->subText = $line;
            $this->createSubBlock();
        } else {
            $this->subText .= $line;
        }
    }

    protected function createSubBlock()
    {
        $subBlock = new SubBlock(
            $this->subNumber,
            $this->subText,
            $this->subTime[0],
            $this->subTime[1]
        );

        array_push($this->subBlocks, $subBlock);

        $this->subText     = '';
        $this->state       = self::states['SRT_STATE_SUBNUMBER'];
    }

    public function __destruct()
    {
        $this->file = null;
    }
}
