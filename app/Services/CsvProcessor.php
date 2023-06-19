<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

final class CsvProcessor
{
    private array $formattedData = [];
    private int $counter = 0;

    public function __construct(protected UploadedFile $csvFile)
    {
        $this->convertToArray();
    }

    private function convertToArray()
    {
        $csv = fopen($this->csvFile, 'r');
        $row = 1;
        while (($csvData = fgetcsv($csv)) !== false) {
            if ($row === 1) {
                $row++;
                continue;
            }
            $this->parseHomeOwnerString($csvData[0]);
            $row++;
        }
    }

    private function parseHomeOwnerString(string $homeOwner)
    {
        try {
            // Initial check for and & ampersand
            $initialSplit = explode(' ', $homeOwner);
            $initialLastName = end($initialSplit);
            // Check for multiple people in string
            $multipleOwners = str_contains($homeOwner, 'and') || str_contains($homeOwner, '&');
            if ($multipleOwners) {
                // Split and handle differently
                $multiSplitPeople = preg_split('/ (and|&) /', $homeOwner);
                $this->handleMultipleSplit(
                    people: $multiSplitPeople,
                    initialLastName: $initialLastName
                );
            } else {
                // Process single person logic here
                $title = $initialSplit[0];
                $initial = str_contains($initialSplit[1], '.') || strlen(
                    $initialSplit[1]
                ) === 1 ? $initialSplit[1] ?? null : null;
                $first = ($initial === null) && $initialSplit[1] !== $initialLastName ? $initialSplit[1] : null;
                $last = $initialLastName;
                $this->addToArray(
                    title: $title,
                    first_name: $first,
                    initial: $initial,
                    last_name: $last
                );
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage() . ' ' . $exception->getLine(), $homeOwner, $this->formattedData);
        }
    }

    private function handleMultipleSplit(array $people, string $initialLastName): void
    {
        // Split into multiples, i am bad at regex
        foreach ($people as $splitItem) {
            $segments = explode(' ', $splitItem);
            $title = $segments[0];
            if (!isset($segments[1])) {
                $this->addToArray(
                    title: $title,
                    first_name: null,
                    initial: null,
                    last_name: $initialLastName
                );
                continue;
            }
            $initial = str_contains($segments[1] ?? null, '.') || strlen(
                $segments[1] ?? null
            ) === 1 ? $segments[1] ?? null : null;
            $first = ($initial === null) && $segments[1] !== $initialLastName ? $segments[1] : null;
            $last = count($segments) === 1 ? $initialLastName : end($segments);
            $this->addToArray(
                title: $title,
                first_name: $first,
                initial: $initial,
                last_name: $last
            );
        }
    }

    private function addToArray(string $title, ?string $first_name, ?string $initial, string $last_name)
    {
        $this->formattedData[] = [
            'title' => $title,
            'initial' => $initial,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'created_at' => now()->toDateTimeString()
        ];
    }


    public function getFormattedData(): array
    {
        return $this->formattedData;
    }

}
