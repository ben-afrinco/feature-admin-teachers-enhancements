<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestResultsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $scores;
    public string $studentName;
    public string $overallLevel;
    public array $tips;

    public function __construct(string $studentName, array $scores)
    {
        $this->studentName = $studentName;
        $this->scores = $scores;
        $this->overallLevel = $this->calculateLevel($scores);
        $this->tips = $this->generateTips($scores);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'LingoPulse AI — Your English Test Results',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.test-results',
            with: [
                'studentName' => $this->studentName,
                'scores' => $this->scores,
                'overallLevel' => $this->overallLevel,
                'tips' => $this->tips,
                'average' => $this->getAverage(),
            ],
        );
    }

    private function getAverage(): int
    {
        $vals = array_values($this->scores);
        return count($vals) > 0 ? (int) round(array_sum($vals) / count($vals)) : 0;
    }

    private function calculateLevel(array $scores): string
    {
        $avg = $this->getAverage();
        if ($avg >= 90) return 'C2 — Mastery';
        if ($avg >= 80) return 'C1 — Advanced';
        if ($avg >= 70) return 'B2 — Upper-Intermediate';
        if ($avg >= 60) return 'B1 — Intermediate';
        if ($avg >= 45) return 'A2 — Elementary';
        return 'A1 — Beginner';
    }

    private function generateTips(array $scores): array
    {
        $tips = [];

        if (($scores['reading'] ?? 0) < 60) {
            $tips[] = '📖 Reading: Try reading short English articles daily. Start with graded readers at your level.';
        } elseif (($scores['reading'] ?? 0) < 80) {
            $tips[] = '📖 Reading: Good foundation! Challenge yourself with longer texts and academic articles.';
        } else {
            $tips[] = '📖 Reading: Excellent! Keep reading diverse materials to maintain your level.';
        }

        if (($scores['listening'] ?? 0) < 60) {
            $tips[] = '🎧 Listening: Watch English videos with subtitles. Try podcasts for beginners.';
        } elseif (($scores['listening'] ?? 0) < 80) {
            $tips[] = '🎧 Listening: Good progress! Try listening without subtitles and practice note-taking.';
        } else {
            $tips[] = '🎧 Listening: Great ear! Listen to native speakers in debates, TED talks, and news.';
        }

        if (($scores['writing'] ?? 0) < 60) {
            $tips[] = '✍️ Writing: Practice writing simple paragraphs daily. Focus on grammar and sentence structure.';
        } elseif (($scores['writing'] ?? 0) < 80) {
            $tips[] = '✍️ Writing: Nice work! Try writing essays and get feedback on vocabulary variety.';
        } else {
            $tips[] = '✍️ Writing: Strong writer! Focus on academic and formal writing styles.';
        }

        if (($scores['speaking'] ?? 0) < 60) {
            $tips[] = '🗣️ Speaking: Practice speaking with a partner or use language exchange apps.';
        } elseif (($scores['speaking'] ?? 0) < 80) {
            $tips[] = '🗣️ Speaking: Good fluency! Work on pronunciation and intonation patterns.';
        } else {
            $tips[] = '🗣️ Speaking: Excellent communicator! Try presenting and debating in English.';
        }

        return $tips;
    }
}
