<?php

/**
 * @author Beatris Bunova <bibunova@gmail.com>
 */
class State
{
    const LEFT_FROG = 1;
    const RIGHT_FROG = 2;
    const EMPTY_SPACE = 0;

    private $frogs = array();
    private $zeroPosition;
    private $path;
    private static $goal;
    private static $numberOfFrogs;

    public function __construct(array $frogs, $zeroPosition, $path)
    {
        $this->frogs = $frogs;
        $this->zeroPosition = $zeroPosition;
        $this->path = $path;
    }

    public static function generateInitialState($numberOfFrogs)
    {
        static::$numberOfFrogs = $numberOfFrogs;

        $frogs = array_fill(0, $numberOfFrogs, self::LEFT_FROG);
        $frogs[] = self::EMPTY_SPACE;
        $frogs = array_merge($frogs, array_fill($numberOfFrogs + 1, $numberOfFrogs, self::RIGHT_FROG));

        return new State($frogs, $numberOfFrogs, static::getStateAsString($frogs));
    }

    public function isSolution()
    {
        if (!isset(self::$goal))
        {
            $frogs = array_fill(0, static::$numberOfFrogs, self::RIGHT_FROG);
            $frogs[] = self::EMPTY_SPACE;
            $frogs = array_merge($frogs, array_fill(static::$numberOfFrogs + 1, static::$numberOfFrogs, self::LEFT_FROG));

            static::$goal = $frogs;
        }

        if (!empty(array_diff_assoc($this->frogs, static::$goal)))
        {
            return false;
        }

        return true;
    }
    
    private static function getStateAsString(array $frogs)
    {
        $stringState = '';
        foreach ($frogs as $frog)
        {
            switch ($frog)
            {
                case self::LEFT_FROG:
                    $stringState .= 'L';
                    break;
                case self::RIGHT_FROG:
                    $stringState .= 'R';
                    break;
                default :
                    $stringState .= '_';
                    break;
            }
        }

        return $stringState . PHP_EOL;
    }
    
    public function printState()
    {
        echo static::getStateAsString($this->frogs);
    }
    
    public function printPath()
    {
        echo $this->path;
    }

    public function canLeftFrogMoveRight()
    {
        if (isset($this->frogs[$this->zeroPosition - 1]) && ($this->frogs[$this->zeroPosition - 1] === static::LEFT_FROG))
        {
            return true;
        }

        return false;
    }

    public function canLeftFrogJumpRight()
    {
        if (isset($this->frogs[$this->zeroPosition - 2]) && ($this->frogs[$this->zeroPosition - 2] === static::LEFT_FROG))
        {
            return true;
        }

        return false;
    }

    public function canRightFrogMoveLeft()
    {
        if (isset($this->frogs[$this->zeroPosition + 1]) && ($this->frogs[$this->zeroPosition + 1] === static::RIGHT_FROG))
        {
            return true;
        }

        return false;
    }

    public function canRightFrogJumpLeft()
    {
        if (isset($this->frogs[$this->zeroPosition + 2]) && ($this->frogs[$this->zeroPosition + 2] === static::RIGHT_FROG))
        {
            return true;
        }

        return false;
    }

    public function moveLeftFrogRight()
    {
        $frogs = $this->frogs;
        $frogs[$this->zeroPosition] = static::LEFT_FROG;
        $frogs[$this->zeroPosition - 1] = static::EMPTY_SPACE;

        return new State($frogs, $this->zeroPosition - 1, $this->path . static::getStateAsString($frogs));
    }

    public function jumpLeftFrogRight()
    {
        $frogs = $this->frogs;
        $frogs[$this->zeroPosition] = static::LEFT_FROG;
        $frogs[$this->zeroPosition - 2] = static::EMPTY_SPACE;

        return new State($frogs, $this->zeroPosition - 2, $this->path . static::getStateAsString($frogs));
    }

    public function moveRightFrogLeft()
    {
        $frogs = $this->frogs;
        $frogs[$this->zeroPosition] = static::RIGHT_FROG;
        $frogs[$this->zeroPosition + 1] = static::EMPTY_SPACE;

        return new State($frogs, $this->zeroPosition + 1, $this->path . static::getStateAsString($frogs));
    }

    public function jumpRightFrogLeft()
    {
        $frogs = $this->frogs;
        $frogs[$this->zeroPosition] = static::RIGHT_FROG;
        $frogs[$this->zeroPosition + 2] = static::EMPTY_SPACE;

        return new State($frogs, $this->zeroPosition + 2, $this->path . static::getStateAsString($frogs));
    }

}
