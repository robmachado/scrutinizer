<?php

namespace Scrutinizer\Tests\Functional;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RunTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $proc = $this->runCmd('run', array(__DIR__.'/Fixture/JsProject'));

        $this->assertSame(0, $proc->getExitCode(), $proc->getOutput().$proc->getErrorOutput());

        $expectedOutput = "Running analyzer \"js_hint\"...\n\n\r    Files 1/1 [............................................................] 100%\n\nScanned Files: 1, Comments: 0\n";
        $this->assertEquals($expectedOutput, $proc->getOutput());
    }

    private function runCmd($command, array $args = array())
    {
        $proc = new Process('php '.__DIR__.'/../../../../bin/scrutinizer '.escapeshellarg($command).' '.implode(" ", array_map('escapeshellarg', $args)));
        $proc->run();

        return $proc;
    }
}