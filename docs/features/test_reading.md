# Reading Proficiency Test

## Overview
A timed assessment of English reading comprehension.

## UI Components
- **Get Ready Screen**: Instructions and timer start.
- **Question Screen**: Displays reading passage and multiple-choice questions.
- **Navigation**: Submit answer and proceed to next question.
- **Result Summary**: Real-time feedback after the test completion.

## Technical Implementation
- **Routes**: `/reading-get-ready`, `/test/reading/q1`, `/test/reading/{q}` (POST)
- **Controller**: `App\Http\Controllers\TestController@submitReading`
- **Dynamic Logic**: Supports dynamic test loading from `dynamic_test_ids.reading` session variable.

## How to use from Browser
1. Start the student session.
2. Navigate to the reading test from the dashboard or sequence.
3. Read the passage and select correct options.
4. Click submit to move through the questions.
