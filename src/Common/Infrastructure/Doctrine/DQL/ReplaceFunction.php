<?php

namespace Common\Infrastructure\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * REPLACE(str, from_str, to_str)
 * "REPLACE" "(" StringPrimary "," StringPrimary "," StringPrimary ")".
 */
class ReplaceFunction extends FunctionNode
{
    protected $stringStr;
    protected $stringFromStr;
    protected $stringToStr;

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'REPLACE(%s, %s, %s)',
            $sqlWalker->walkStringPrimary($this->stringStr),
            $sqlWalker->walkStringPrimary($this->stringFromStr),
            $sqlWalker->walkStringPrimary($this->stringToStr)
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);                // REPLACE
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->stringStr = $parser->StringPrimary();        // str
        $parser->match(Lexer::T_COMMA);
        $this->stringFromStr = $parser->StringPrimary();    // from_str
        $parser->match(Lexer::T_COMMA);
        $this->stringToStr = $parser->StringPrimary();      // to_str
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
