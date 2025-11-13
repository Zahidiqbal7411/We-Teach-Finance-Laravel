<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Course;

class BackfillTransactionPercentages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:backfill-percentages {--chunk=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill teacher_amount, platform_amount, teacher_percent and platform_percent on transactions';

    public function handle()
    {
        $chunkSize = (int) $this->option('chunk');
        $this->info("Starting backfill of transactions in chunks of {$chunkSize}...");

        $count = 0;

        Transaction::chunkById($chunkSize, function ($transactions) use (&$count) {
            foreach ($transactions as $tx) {
                $count++;

                // Determine teacher percentage from the course/teacher relation
                $teacherPercent = 0;
                if ($tx->course_id && $tx->teacher_id) {
                    $course = Course::find($tx->course_id);
                    if ($course) {
                        $relation = $course->teacherCourses()->where('teacher_id', $tx->teacher_id)->first();
                        $teacherPercent = $relation?->teacher_percentage ?? 0;
                    }
                }

                $teacherAmount = ($tx->total ?? 0) * ($teacherPercent / 100);
                $platformAmount = ($tx->total ?? 0) - $teacherAmount;

                $tx->teacher_percent = $teacherPercent;
                $tx->platform_percent = 100 - $teacherPercent;
                $tx->teacher_amount = round($teacherAmount, 2);
                $tx->platform_amount = round($platformAmount, 2);

                $tx->save();
            }
        });

        $this->info("Backfilled {$count} transactions.");
        return 0;
    }
}
