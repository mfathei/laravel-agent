<?php

namespace App\Console\Commands;

use App\Ai\Agents\AskLaravelAgent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('ai:ask-agent {question}')]
#[Description('Test AI agent')]
class TestAiAgent extends Command
{
    public function handle(): int
    {
        $question = $this->argument('question');
        $this->info('Thinking...');

        $response = app(AskLaravelAgent::class)->prompt($question);
        $this->line($response);

        return self::SUCCESS;
    }
}
