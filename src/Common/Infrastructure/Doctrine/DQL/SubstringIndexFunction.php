<?php

namespace Common\Infrastructure\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "SUBSTRING_INDEX" "(" ArithmeticPrimary "," ArithmeticPrimary "," ArithmeticPrimary ")".
 *
 * @author  Andrey Stepanov <stepashka@gmail.com>
 *
 * @link http://stackoverflow.com/a/25508062/2051414
 */
class SubstringIndexFunction extends FunctionNode
{
    public $str = null;
    public $delim = null;
    public $count = null;

    /**
     * @override
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'SUBSTRING_INDEX('.
        $this->str->dispatch($sqlWalker).', '.
        $this->delim->dispatch($sqlWalker).', '.
        $this->count->dispatch($sqlWalker).
        ')';
    }

    /**
     * @override
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->str = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->delim = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->count = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
