<?php

namespace Common\Application;

interface TransactionManager
{
    public function persist($entity);

    public function flush();
}
