--TEST--
Test continue stmt
--DESCRIPTION--
Lowlevel basic test
--FILE--
<?php

require __DIR__ . '/../../../../Bootstrap.php';

use PhpToZephir\EngineFactory;
use PhpToZephir\Logger;
use Symfony\Component\Console\Output\NullOutput;
use PhpToZephir\Render\StringRender;
use PhpToZephir\CodeCollector\StringCodeCollector;

$engine = EngineFactory::getInstance(new Logger(new NullOutput(), false));
$code   = <<<'EOT'
<?php

namespace Code\Condition\IfStmt;

class IsWithYodaCondition
{
    public function test($toto)
    {
        if ('tata' === $toto) {
            echo 'tata';
        }
    }
}
EOT;
$render = new StringRender();
$codeValidator = new PhpToZephir\CodeValidator();

foreach ($engine->convert(new StringCodeCollector(array($code))) as $file) {
	$zephir = $render->render($file);
	$codeValidator->isValid($zephir);
	
	echo $zephir;
}

?>
--EXPECT--
namespace Code\Condition\IfStmt;

class IsWithYodaCondition
{
    public function test(toto) -> void
    {
        
        if toto === "tata" {
            echo "tata";
        }
    }

}