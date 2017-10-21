<?php

require_once 'State.php';

/**
 * @author Beatris Bunova <bibunova@gmail.com>
 */
class Solver
{

    public function run()
    {
        echo 'Enter number of frogs by one side: ';
        $numberOfFrogs = (int) readline();

        $initialState = State::generateInitialState($numberOfFrogs);
        $this->dfsRecursive($initialState);
//        $this->dfs($initialState);
    }

    private function dfsRecursive(State $state)
    {
        if ($state->isSolution())
        {
//            $state->printPath();
            return true;
        }

        if ($state->canLeftFrogMoveRight())
        {
            if ($this->dfsRecursive($state->moveLeftFrogRight()))
            {
                $state->printState();
                return true;
            }
        }
        if ($state->canRightFrogMoveLeft())
        {
            if ($this->dfsRecursive($state->moveRightFrogLeft()))
            {
                $state->printState();
                return true;
            }
        }
        if ($state->canLeftFrogJumpRight())
        {
            if ($this->dfsRecursive($state->jumpLeftFrogRight()))
            {
                $state->printState();
                return true;
            }
        }
        if ($state->canRightFrogJumpLeft())
        {
            if ($this->dfsRecursive($state->jumpRightFrogLeft()))
            {
                $state->printState();
                return true;
            }
        }

        return false;
    }

    private function dfs(State $frogs)
    {
        $stack = new SplStack();
        $stack->push($frogs);

        while (!$stack->isEmpty())
        {
            $state = $stack->pop();

            if ($state->isSolution())
            {
                $state->printPath();
                return;
            }

            if ($state->canRightFrogJumpLeft())
            {
                $stack->push($state->jumpRightFrogLeft());
            }
            if ($state->canLeftFrogJumpRight())
            {
                $stack->push($state->jumpLeftFrogRight());
            }
            if ($state->canRightFrogMoveLeft())
            {
                $stack->push($state->moveRightFrogLeft());
            }
            if ($state->canLeftFrogMoveRight())
            {
                $stack->push($state->moveLeftFrogRight());
            }
        }
    }

}

(new Solver())->run();
