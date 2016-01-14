<?php

namespace Pixie\QueryBuilder;

trait Transaction
{
    
    /**
     * @var integer
     */
    protected $transactions = 0;
    
    /**
     * @return void
     */
    public function beginTransaction() 
    {
        ++$this->transactions;
        
        if ($this->transactions === 1) {
            $this->pdo->beginTransaction();
        }
    }
    
    /**
     * Commit the database changes
     * @return void
     * @throw Pixie\QueryBuilder\TransactionHaltException
     */
    public function commit()
    {
        if ($this->transactions === 1) {
            $this->pdo->commit();
        }
        
        --$this->transactions;
        
        throw new TransactionHaltException();
    }

    /**
     * Rollback the database changes
     * @return void
     * @throw Pixie\QueryBuilder\TransactionHaltException
     */
    public function rollback()
    {
        if ($this->transactions == 1) {
            $this->transactions = 0;
            $this->pdo->rollBack();
        }
        else {
            --$this->transactions;
        }
        
        throw new TransactionHaltException();
    }
}
